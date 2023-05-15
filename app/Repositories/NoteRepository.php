<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Http\Request;

class NoteRepository {
    private $notes;

    public function __construct() {
        $this->notes = [];
    }

    public function create(Order $order, Request $request): array {
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

    public function deleteAll(Order $order): bool {
        return $order->notes()->delete();
    }
}
