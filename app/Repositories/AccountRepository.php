<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AccountRepository {

    /**
     * Accounts temporary collection
     *
     * @since 1.0.0
     * @var array
     */
    private $accounts;

    public function __construct() {
        $this->accounts = [];
    }

    /**
     * Delete order accounts and generate a list from `order_dynamic_fields` of order's meta data
     * and insert them into database
     *
     * @since 1.0.0
     * @param Order $order
     * @param Request $request
     * @return array
     */
    public function create(Order $order, Request $request): array {

        // Delete all accounts for orders if it exists, just to prevent duplications
        // since we're using title field to detect updates.
        $this->deleteOrderAccounts($order);

        foreach ($request->metadata["order_dynamic_fields"] as $account) {
            $this->createOrUpdate($order, $account);
        }

        return $this->accounts;
    }

    /**
     * Find and insert or update the account in database
     *
     * @since 1.0.0
     * @param Order $order
     * @param array $account
     * @return Account
     */
    public function createOrUpdate(Order $order, array $account): Account {
        // Generate expires at value
        $expires_at = Carbon::parse($account["field_date"]);
        $expires_at->addDays(intval($account["field_expire_days"]));

        Log::info($account);

        // Using Lock for updates to prevent race conditions
        $account = $order->accounts()->lockForUpdate()->updateOrCreate(
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
                "guarantee"   => $account["field_guarantee"],
                "expire_at"   => $expires_at,
            ]
        );

        $this->accounts[] = $account;

        return $account;
    }

    /**
     * This function is only used for command line
     *
     * @since 1.0.0
     * @param Account $Account
     * @param array $data
     * @return Account
     */
    public function update(Account $Account, array $data): Account {
        return tap($Account)->update([
            "date"        => $data["date"],
            "email"       => $data["email"],
            "title"       => $data["title"],
            "username"    => $data["username"],
            "password"    => $data["password"],
            "guarantee"   => $data["guarantee"],
            "expire_days" => $data["expire_days"],
        ]);
    }

    /**
     * This function is not used anywhere
     *
     * @since 1.0.0
     * @param Order $order
     * @return void
     */
    public function getOrderAccounts(Order $order): Account {
        return Account::where("order_id", $order->id)->get()->all();
    }

    /**
     * Delete all accounts from order
     *
     * @since 1.0.0
     * @param Order $order
     * @return boolean
     */
    public function deleteOrderAccounts(Order $order): bool {
        return $order->accounts()->delete();
    }
}
