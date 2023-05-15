<?php

namespace App\Models;

use App\Models\Note;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model {

    protected $casts = [
        'variation' => 'array',
        'metadata' => 'array'
    ];

    protected $fillable = [
        "order_id",
        "customer_id",
        "variation",
        "price",
        "metadata",
        "status",
        "support_note",
    ];

    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class);
    }

    public function notes(): HasMany {
        return $this->hasMany(Note::class);
    }
}
