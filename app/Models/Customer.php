<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Customer extends Model {

    use Notifiable;

    protected $fillable = [
        "username",
        "first_name",
        "last_name",
        "email",
        "phone",
    ];


    public function routeNotificationForKavenegar($driver, $notification = null) {
        return $this->phone;
    }

    public function orders(): HasMany {
        return $this->hasMany(Order::class);
    }
}
