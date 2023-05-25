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

    public function getPattern(string $token1, string $token2, string $token3): mixed {
        $pattern = "سلام %token
        سفارش ( %token2 ) منقضی شده و هم اکنون در انتظار تمدید اشتراک میباشد.

        جهت تمدید اشتراک از طریق سایت ، خرید جدیدی ثبت کنید:
        Account4all.ir
        ";

        return str_replace(
            ["%token", $token1],
            ["%token2", $token2],
            ["%token3", $token3],
            $pattern
        );
    }
}
