<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Account;
use Illuminate\Http\Request;

class AccountRepository {
    private $accounts;

    public function __construct() {
        $this->accounts = [];
    }
    public function create(Order $order, Request $request) {

        // Delete all accounts for orders if it exists, just to prevent duplications
        // since we're using title field to detect updates.
        $this->deleteOrderAccounts($order);

        foreach ($request->metadata["order_dynamic_fields"] as $account) {
            $this->createOrUpdate($order, $account);
        }

        return $this->accounts;
    }

    public function createOrUpdate(Order $order, array $account) {
        // Generate expires at value
        $expires_at = Carbon::parse($account["field_date"]);
        $expires_at->addDays(intval($account["field_expire_days"]));

        $account = $order->accounts()->updateOrCreate(
            [
                "title" => $account["field_title"]
            ],
            [
                "title"       => $account["field_title"],
                "code"        => $account["field_code"],
                "date"        => $account["field_date"],
                "email"       => $account["field_email"],
                "password"    => $account["field_password"],
                "username"    => $account["field_username"],
                "expire_days" => $account["field_expire_days"],
                "expire_at"   => $expires_at,
            ]
        );

        $this->accounts[] = $account;

        return $account;
    }

    public function update(Account $Account, array $data): Account {
        return tap($Account)->update([
            "date"        => $data["date"],
            "email"       => $data["email"],
            "title"       => $data["title"],
            "username"    => $data["username"],
            "password"    => $data["password"],
            "expire_days" => $data["expire_days"],
        ]);
    }

    public function getOrderAccounts(Order $order) {
        return Account::where("order_id", $order->id)->get()->all();
    }

    public function deleteOrderAccounts(Order $order): bool {
        return $order->accounts()->delete();
    }
}
