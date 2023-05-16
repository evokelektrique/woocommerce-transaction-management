<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Customer extends Model {
    protected $fillable = [
        "username",
        "first_name",
        "last_name",
        "email",
        "phone",
    ];

    public function orders(): HasMany {
        return $this->hasMany(Order::class);
    }
}
