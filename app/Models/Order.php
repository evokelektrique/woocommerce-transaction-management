<?php

namespace App\Models;

use App\Models\Note;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;

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

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function notes() {
        return $this->hasMany(Note::class);
    }

    public static function get_variations($items): string {

        foreach ($items as $key => $value) {
            $quantity = $value['quantity'];
            $product_name = $key;
            $item_variations = [];
            foreach ($value["variations"] as $variation) {
                $item_variations[] = [
                    $variation["key"] => $variation["value"]
                ];
            }
        }

        return json_encode([
            "product_name" => $product_name,
            "quantity" => $quantity,
            "variations" => $item_variations,
        ]);
    }
}
