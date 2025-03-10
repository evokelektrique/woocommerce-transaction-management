<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;

class OrderRepository {
    public function __construct() {
    }

    public function create(Customer $customer, Request $request): Order {
        return $customer->orders()->lockForUpdate()->updateOrCreate(
            ["wc_order_id" => $request->order['id']],
            [
                "status" => $request->order['status'],
                "price" => $request->order['price'],
                "metadata" => $request->metadata,
                "variation" => $this->get_variations($request->order['items']),
                "wc_created_at" => $request->order['dates']['created_at']['date'] ?? null,
                "wc_paid_at" => $request->order['dates']['paid_at']['date'] ?? null,
                "wc_modified_at" => $request->order['dates']['modified_at']['date'] ?? null,
                "wc_completed_at" => $request->order['dates']['completed_at']['date'] ?? null,
            ]
        );
    }

    /**
     * Used for console command for retrieving products from WooCommerce
     *
     * @param Customer $customer
     * @param array $data
     * @return Order
     */
    public function createFromArray(Customer $customer, array $data): Order {
        return $customer->orders()->lockForUpdate()->updateOrCreate(
            ["wc_order_id" => $data['id']],
            [
                "status" => $data['status'],
                "price" => $data['price'],
                "metadata" => $data["metadata"],
                "variation" => $this->get_variations($data['items']),
            ]
        );
    }

    public function get_variations($items): mixed {
        return $items;
    }
}
