<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\OrdersDataTable;

class OrderController extends Controller {
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function create(Request $request) {
        // return response()->json(["test" => "test !!", "body" => $request->all()]);
    }

    public function index(OrdersDataTable $dataTable) {
        return $dataTable->render('orders.index');
    }
}
