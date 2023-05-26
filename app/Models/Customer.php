<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function getPattern(array $tokens): mixed {
        $pattern = "سلام %token
        سفارش ( %token ) منقضی شده و هم اکنون در انتظار تمدید اشتراک میباشد.

        جهت تمدید اشتراک از طریق سایت ، خرید جدیدی ثبت کنید:
        Account4all.ir
        ";

        return Str::replaceArray("%token", $tokens, $pattern);
    }

    public function notification_account(Account $account) {
        return $this->notifications()
            ->where('data->account_id', $account->id)
            ->latest()->first();
    }
}
