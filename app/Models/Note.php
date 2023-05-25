<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class Note extends Model {
    protected $fillable = [
        "content",
        "customer_note",
        "date_created_gmt",
        "author",
    ];

    protected $casts = [
        "date_created_gmt" => "datetime",
    ];

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function is_added_by_user(): bool {
        return $this->customer_note;
    }

    public function is_added_by_system(): bool {
        return $this->author === "system";
    }
}
