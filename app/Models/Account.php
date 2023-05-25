<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Account extends Model {
    use HasFactory;

    protected $fillable = [
        "date",
        "email",
        "title",
        "code",
        "username",
        "password",
        "expire_days",
        "expire_at",
        "notification_sent",
    ];

    protected $casts = [
        "expire_at" => "datetime",
        "date" => "datetime",
    ];

    public function order(): BelongsTo {
        return $this->belongsTo(Order::class);
    }

    public function is_expired() {
        return !$this->expire_at->isFuture();
    }
}
