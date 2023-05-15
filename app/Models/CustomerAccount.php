<?php

namespace App\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerAccount extends Model {
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
    ];

    protected $casts = [
        "expire_at" => "datetime"
    ];

    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class);
    }
}
