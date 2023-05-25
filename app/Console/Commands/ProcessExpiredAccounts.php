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
        $expired_accounts = Account::whereDate('expire_at', "<=", now())->where(["notification_sent" => false])->get();

        foreach ($expired_accounts as $expired_account) {
            $customer = $expired_account->order->customer;

            // Send account expiration notification to user
            $customer->notify((new CustomerAccountExpired($expired_account))->locale('fa'));

            // Update account's notification sent status to prevent duplication on sending notification
            $expired_account->update(["notification_sent" => true]);
        }
    }
}
