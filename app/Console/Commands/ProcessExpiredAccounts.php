<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Notifications\CustomerAccountExpired;
use Illuminate\Console\Command;
use Automattic\WooCommerce\Client as WooCommerce;

class ProcessExpiredAccounts extends Command {
    /**
     * WooCommerce client SDK
     *
     * @var WooCommerce
     */
    private $woocommerce;

    /**
     * Status for expired accounts to be changed in orders
     */
    const WC_ORDER_STATUS = "processing";

    public function __construct(WooCommerce $woocommerce) {
        parent::__construct();

        $this->woocommerce = $woocommerce;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'account:proccess-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process expired accounts and send a notification to users and also change the WooCommerce status of order remotely';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): void {
        $expired_accounts = Account::whereDate('expire_at', "<=", now())->get();

        foreach ($expired_accounts as $expired_account) {
            $customer = $expired_account->order->customer;
            $wc_order_id = $expired_account->order->wc_order_id;

            // Update order's status in WooCommerce
            // $this->woocommerce->put("orders/$wc_order_id", ["status" => self::WC_ORDER_STATUS]);
            // dd($this->woocommerce->get("orders/432"));

            // dd($customer->notifications);
            // $customer->notify(new CustomerAccountExpired($expired_account));
        }
    }
}
