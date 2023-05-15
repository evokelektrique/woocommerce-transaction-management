<?php

namespace App\Models;

use App\Models\Order;
use App\Models\CustomerAccount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function accounts(): HasMany {
        return $this->hasMany(CustomerAccount::class);
    }
}
