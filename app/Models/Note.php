<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class Note extends Model {
    protected $fillable = [
        "order_id",
        "content",
        "type",
    ];

    public function order() {
        return $this->belongsTo(Order::class);
    }
}
