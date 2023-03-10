<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\NoteRequest;

class NoteController extends Controller {

    public function store(NoteRequest $request) {
        Note::firstOrCreate(["order_id" => $request->order_id, "content" => $request->content, "type" => $request->type]);

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
        $order = Order::where("order_id", $request->order["id"])->firstOrFail();
        $notes = [];

        foreach ($request->notes as $note) {
            $notes[] = $order->notes()->updateOrCreate([
                "content" => $note["content"] ?? "",
                "type" => $note["type"],
            ], [
                "content" => $note["content"] ?? "",
                "type" => $note["type"]
            ]);
        }

        return response()->json([
            "notes" => $notes,
        ]);
    }

    public function destroy(Note $note) {
        $note->delete();

        return redirect()->back()->with("success", "Note deleted successfully");
    }
}
