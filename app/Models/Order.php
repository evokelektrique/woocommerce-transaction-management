<?php

namespace App\Models;

use App\Models\Note;
use App\Models\Account;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model {

    protected $casts = [
        'variation' => 'array',
        'metadata' => 'array'
    ];

    protected $fillable = [
        "wc_order_id",
        "variation",
        "price",
        "metadata",
        "status",
        "support_note",
    ];

    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class);
    }

    public function accounts(): HasMany {
        return $this->hasMany(Account::class);
    }

    public function notes(): HasMany {
        return $this->hasMany(Note::class)->orderBy('created_at', 'desc');
    }
}
