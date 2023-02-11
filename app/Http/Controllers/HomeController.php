<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\DataTables\OrdersDataTable;

class HomeController extends Controller {
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $orders_total = Order::count();

        return view("home", compact("orders_total"));
    }
}
