<?php

namespace App\Repositories;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerRepository {
    public function __construct() {
    }

    public function create(Request $request): Customer {

        return Customer::updateOrCreate(
            ["email" => $request->customer['email']],
            [
                "first_name" => $request->customer['first_name'],
                "last_name" => $request->customer['last_name'],
                "username" => $request->customer['username'] ?? "undefined",
                "phone" => $request->customer['phone'],
            ]
        );
    }
}
