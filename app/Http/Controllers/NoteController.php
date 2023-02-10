<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class NoteController extends Controller {
    
    /**
     * Display single note
     *
     * @param Order $order
     * @return void
     */
    public function show(Order $order) {
        return view("notes.show", compact("order"));
    }
}
