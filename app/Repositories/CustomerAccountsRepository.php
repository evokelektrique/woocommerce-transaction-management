<?php

namespace App\Repositories;

use App\Models\CustomerAccount;
use Illuminate\Http\Request;

class CustomerAccountRepository {
    private $accounts;

    public function __construct() {
        $this->accounts = [];
    }

    public function create(Request $request): array {
        $metadata = json_decode($request->metadata, true);
        $this->accounts = [];

        foreach($metadata["order_dynamic_fields"] as $account) {
            $this->accounts[] = CustomerAccount::updateOrCreate($account);
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
