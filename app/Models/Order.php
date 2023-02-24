<?php

namespace App\Models;

use App\Models\Note;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    protected $fillable = [
        "order_id",
        "customer_id",
        "variation",
        "price",
        "status",
    ];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function notes() {
        return $this->hasMany(Note::class);
    }

    public static function get_variations($items): string {
        $item_variation = "";

        foreach ($items as $key => $value) {
            $quantity = $value['quantity'];
            $product_name = $key;
            $item_variation .= "({$product_name} - x{$quantity} - ";

            $count = count($value["variations"]);
            $i = 0;
            foreach ($value["variations"] as $variation) {
                $item_variation .= $variation["key"] . " => " . $variation["value"];

                if (++$i !== $count) {
                    $item_variation .= " - ";
                }
            }
            $item_variation .= ") - ";
        }

        return $item_variation;
    }
}
