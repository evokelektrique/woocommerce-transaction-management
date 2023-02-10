<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model {
    protected $fillable = [
        "username",
        "first_name",
        "last_name",
        "email",
        "phone",
    ];

    public function orders() {
        return $this->hasMany(Order::class);
    }
}
