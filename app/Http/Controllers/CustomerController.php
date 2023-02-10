<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller {
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display single customer
     *
     * @param Customer $customer
     * @return void
     */
    public function show(Customer $customer) {
        return view("customers.show", compact("customer"));
    }
}
