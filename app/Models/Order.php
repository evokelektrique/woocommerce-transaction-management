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
        'metadata' => 'array',
        "wc_created_at" => "datetime",
        "wc_paid_at" => "datetime",
        "wc_modified_at" => "datetime",
        "wc_completed_at" => "datetime",
    ];

    protected $fillable = [
        "wc_order_id",
        "variation",
        "price",
        "metadata",
        "status",
        "support_note",
        "wc_created_at",
        "wc_paid_at",
        "wc_modified_at",
        "wc_completed_at",
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
