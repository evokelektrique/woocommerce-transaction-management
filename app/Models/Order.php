<?php

namespace App\Models;

use App\Models\Note;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    protected $fillable = [
        "order_id",
        "customer_id",
    ];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function notes() {
        return $this->hasMany(Note::class);
    }
}
