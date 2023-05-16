<?php

namespace App\Models;

use App\Models\Note;
use App\Models\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model {

    protected $casts = [
        'variation' => 'array',
        'metadata' => 'array'
    ];

    protected $fillable = [
        "order_id",
        "variation",
        "price",
        "metadata",
        "status",
        "support_note",
    ];

    public function accounts(): HasMany {
        return $this->hasMany(Account::class);
    }

    public function notes(): HasMany {
        return $this->hasMany(Note::class);
    }
}
