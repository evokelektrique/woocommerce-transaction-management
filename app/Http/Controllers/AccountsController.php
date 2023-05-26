<?php

namespace App\Http\Controllers;

use App\DataTables\AccountsDataTable;

class AccountsController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(AccountsDataTable $dataTable): mixed {
        return $dataTable->render('accounts.index');
    }
}
