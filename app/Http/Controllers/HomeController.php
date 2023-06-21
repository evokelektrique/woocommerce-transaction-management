<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Order;
use App\Models\Account;
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
        $accounts_total = Account::count();
        $notes_total = Note::count();

        return view("home", compact("orders_total", "accounts_total", "notes_total"));
    }

    public function token() {
        $token_name = "admin_token";
        $token = auth()->user()->createToken($token_name)->plainTextToken;

        return view("token", compact("token"));
    }
}
