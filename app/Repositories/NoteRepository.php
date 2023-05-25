<?php

namespace App\Repositories;

use App\Http\Requests\NoteRequest;
use App\Models\Note;
use App\Models\Order;
use Automattic\WooCommerce\Client as WooCommerce;

class NoteRepository {
    private $notes;
    private $woocommerce;

    public function __construct(WooCommerce $woocommerce) {
        $this->notes = [];
        $this->woocommerce = $woocommerce;
    }

    public function createNotes(Order $order): array {
        // Delete all notes before creating any
        $this->deleteAll($order);
        $notes_from_woocommerce = $this->fetchNotesFromWooCommerce($order);

        foreach ($notes_from_woocommerce as $note) {
            $note = [
                "content"          => $note->note ?? "",
                "author"           => $note->author,
                "date_created_gmt" => $note->date_created_gmt,
                "customer_note"    => $note->customer_note,
            ];

            $this->notes[] = $order->notes()->updateOrCreate($note, $note);
        }

        return $this->notes;
    }

    public function create(Order $order, NoteRequest $request): Note {
        return $order->notes()->firstOrCreate([
            "content"       => $request->content,
            "customer_note" => false, // Default is false because it's written by admins
        ]);
    }

    public function deleteAll(Order $order): bool {
        return $order->notes()->delete();
    }

    public function fetchNotesFromWooCommerce(Order $order): mixed {
        return $this->woocommerce->get("orders/" . $order->wc_order_id . "/notes");
    }
}
