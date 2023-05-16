<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use App\Repositories\AccountRepository;

class CreateOrderAccounts extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:accounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create order accounts from its metadata into Accounts table';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(AccountRepository $accountRepository): void {
        $orders = Order::all();

        foreach ($orders as $order) {
            if(!isset($order->metadata) || empty($order->metadata)) {
                continue;
            }

            foreach ($order->metadata["order_dynamic_fields"] as $account) {
                $account = $accountRepository->createOrUpdate($order, $account);

                $this->info("Order #{$order->id} - New account #{$account->id} created");
            }
        }
    }
}
