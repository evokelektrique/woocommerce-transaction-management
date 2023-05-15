<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\NoteRequest;
use App\Repositories\NoteRepository;

class NoteController extends Controller {

    private $noteRepository;

    public function __construct(NoteRepository $noteRepository) {
        $this->noteRepository = $noteRepository;
    }

    public function store(NoteRequest $request) {
        Note::firstOrCreate([
            "order_id" => $request->order_id,
            "content" => $request->content,
            "type" => $request->type
        ]);

        return redirect()->back()->with("success", "Note created successfully");
    }

    /**
     * Display single note
     *
     * @param Order $order
     * @return void
     */
    public function show(Order $order) {
        return view("notes.show", compact("order"));
    }

    public function create(Request $request) {
        // Find order
        $order = Order::where("order_id", $request->order["id"])->firstOrFail();

        // Create notes for order
        $notes = $this->noteRepository->create($order, $request);

        return response()->json([
            "notes" => $notes,
        ]);
    }

    public function destroy(Note $note) {
        $note->delete();

        return redirect()->back()->with("success", "Note deleted successfully");
    }
}
