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
     * @since 1.0.0
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
     * @since 1.0.0
     * @var string
     */
    protected $signature = 'account:proccess-expired';

    /**
     * The console command description.
     *
     * @since 1.0.0
     * @var string
     */
    protected $description = 'Process expired accounts and send a notification to users and also change the WooCommerce status of order remotely';

    /**
     * Execute the console command.
     *
     * @since 1.0.0
     * @return int
     */
    public function handle(): void {
        // Only fetch accounts that are expired and their notification is not sent yet
        $expired_accounts = Account::whereDate('expire_at', "<=", now())
        ->where(["notification_sent" => false, 'guarantee' => false])
        ->get();

        foreach ($expired_accounts as $account) {
            $customer = $account->order->customer;

            // Send account expiration notification to user
            $customer->notify((new CustomerAccountExpired($account))->locale('fa'));

            // Update account's notification sent status to prevent duplication on sending notification
            $account->update(["notification_sent" => true]);

            $this->info("Notification sent for account #{$account->id} of order #{$account->order->id}");
        }
    }
}
