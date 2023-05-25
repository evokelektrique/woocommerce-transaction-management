<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;

class OrderRepository {
    public function __construct() {
    }

    public function create(Customer $customer, Request $request): Order {
        return $customer->orders()->updateOrCreate(
            ["wc_order_id" => $request->order['id']],
            [
                "status" => $request->order['status'],
                "price" => $request->order['price'],
                "metadata" => $request->metadata,
                "variation" => $this->get_variations($request->order['items']),
            ]
        );
    }

    public function get_variations($items): string {
        return json_encode($items);
    }
}
