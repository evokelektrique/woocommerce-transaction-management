<?php

namespace App\Repositories;

use App\Http\Requests\NoteRequest;
use App\Models\Note;
use App\Models\Order;
use Illuminate\Http\Request;

class NoteRepository {
    private $notes;

    public function __construct() {
        $this->notes = [];
    }

    public function createNotes(Order $order, Request $request): array {
        // Delete all notes before creating any
        $this->deleteAll($order);

        foreach ($request->notes as $note) {
            $note = [
                "content" => $note["content"] ?? "",
                "type" => $note["type"],
            ];

            $this->notes[] = $order->notes()->updateOrCreate($note, $note);
        }

        return $this->notes;
    }

    public function create(NoteRequest $request): Note {
        return Note::firstOrCreate([
            "order_id" => $request->order_id,
            "content" => $request->content,
            "type" => $request->type
        ]);
    }

    public function deleteAll(Order $order): bool {
        return $order->notes()->delete();
    }
}
