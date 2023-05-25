<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\NoteRequest;
use App\Repositories\NoteRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class NoteController extends Controller {

    private $noteRepository;

    public function __construct(NoteRepository $noteRepository) {
        $this->noteRepository = $noteRepository;
    }

    public function store(Order $order, NoteRequest $request): RedirectResponse {
        // Create note
        $this->noteRepository->create($order, $request);

        return redirect()->back()->with("success", "Note created successfully");
    }

    /**
     * Display single note
     *
     * @param Order $order
     * @return void
     */
    public function show(Order $order): View {
        return view("notes.show", compact("order"));
    }

    public function sync(Request $request): JsonResponse {
        // Find order
        $order = Order::where("wc_order_id", $request->order["id"])->firstOrFail();

        // Create notes for order
        $notes = $this->noteRepository->createNotes($order);

        return response()->json([
            "notes" => $notes,
        ]);
    }

    public function destroy(Note $note): RedirectResponse {
        $note->delete();

        return redirect()->back()->with("success", "Note deleted successfully");
    }
}
