<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\DataTables\OrdersDataTable;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(OrdersDataTable $dataTable) {
        return $dataTable->render('orders.index');
    }

    public function update_support_note(Order $order, Request $request) {
        $order->update(["support_note" => $request->support_note]);

        return response()->json(["success" => true]);
    }

    public function create(Request $request) {
        $customer = Customer::updateOrCreate(
            ["email" => $request->customer['email']],
            [
                "first_name" => $request->customer['first_name'],
                "last_name" => $request->customer['last_name'],
                "username" => $request->customer['username'] ?? "undefined",
                "phone" => $request->customer['phone'],
            ]
        );

        $order = $customer->orders()->updateOrCreate(
            ["order_id" => $request->order['id']],
            [
                "status" => $request->order['status'],
                "price" => $request->order['price'],
                "metadata" => $request->metadata,
                "variation" => Order::get_variations($request->order['items']),
            ]
        );

        $notes = [];
        foreach($request->notes as $note) {
            $notes[] = $order->notes()->updateOrCreate([
                "content" => $note["content"] ?? "",
                "type" => $note["type"],
            ], [
                "content" => $note["content"] ?? "",
                "type" => $note["type"]
            ]);
        }

        return response()->json([
            "customer" => $customer,
            "order" => $order,
            "notes" => $notes,
        ]);
    }

    public function show(Order $order) {
        return view("orders.show", compact("order"));
    }
}
