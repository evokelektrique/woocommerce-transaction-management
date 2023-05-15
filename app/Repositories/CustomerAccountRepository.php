<?php

namespace App\Repositories;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\CustomerAccount;
use Carbon\Carbon;

class CustomerAccountRepository {
    private $accounts;

    public function __construct() {
        $this->accounts = [];
    }

    public function create(Customer $customer, Request $request): array {
        $this->accounts = [];

        foreach ($request->metadata["order_dynamic_fields"] as $account) {

            // Generate expires at value
            $expires_at = Carbon::parse($account["field_date"]);
            $expires_at->addDays(intval($account["field_expire_days"]));

            $this->accounts[] = $customer->accounts()->updateOrCreate(
                [
                    "title" => $account["field_title"]
                ],
                [
                    "title" => $account["field_title"],
                    "code" => $account["field_code"],
                    "date" => $account["field_date"],
                    "email" => $account["field_email"],
                    "password" => $account["field_password"],
                    "username" => $account["field_username"],
                    "expire_days" => $account["field_expire_days"],
                    "expire_at" => $expires_at,
                ]
            );
        }

        return $this->accounts;
    }

    public function update(CustomerAccount $CustomerAccount, array $data): CustomerAccount {
        return tap($CustomerAccount)->update([
            "date" => $data["date"],
            "email" => $data["email"],
            "title" => $data["title"],
            "username" => $data["username"],
            "password" => $data["password"],
            "expire_days" => $data["expire_days"],
        ]);
    }
}
