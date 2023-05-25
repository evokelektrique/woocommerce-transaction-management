<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Notifications\CustomerAccountExpired;
use Illuminate\Console\Command;
use Automattic\WooCommerce\Client as WooCommerce;

class ProcessExpiredAccounts extends Command {
    private $woocommerce;

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
            $customer = $expired_accounts->first()->order->customer;
            dd($this->woocommerce->get("customers"));
            // dd($customer->notifications);
            // $customer->notify(new CustomerAccountExpired($expired_account));
        }
    }
}
