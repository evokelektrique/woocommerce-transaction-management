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
        // $products = [];

        // foreach ($items as $key => $value) {
        //     // Quantity
        //     $products[$key]["quantity"] = $value['quantity'];
        //     $products[$key]["quantity"] = $value['quantity'];

        //     $item_variations = [];
        //     foreach ($value["variations"] as $variation) {
        //         $item_variations[] = [
        //             $variation["key"] => $variation["value"]
        //         ];
        //     }

        //     $product_name[$key]["variations"] = $item_variations;
        // }

        return json_encode($items);
    }
}
