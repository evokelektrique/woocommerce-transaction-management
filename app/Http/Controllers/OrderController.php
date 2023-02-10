<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\OrdersDataTable;

class OrderController extends Controller {
    public function create(Request $request) {
        // return response()->json(["test" => "test !!", "body" => $request->all()]);
    }

    public function index(OrdersDataTable $dataTable) {
        return $dataTable->render('home');
    }
}
