<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use Automattic\WooCommerce\Client as WooCommerce;

class UpdateOrderWooCommerceDates extends Command {

    /**
     * WooCommerce client SDK
     *
     * @since 1.0.0
     * @var WooCommerce
     */
    private $woocommerce;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:wc_update_dates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update WooCommerce dates';

    public function __construct(WooCommerce $woocommerce) {
        parent::__construct();

        $this->woocommerce = $woocommerce;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $orders = Order::all();

        foreach ($orders as $order) {
            try {
                $wc_order = $this->woocommerce->get('orders/' . $order->wc_order_id);

                $order->update([
                    "wc_created_at" => $wc_order->date_created ?? null,
                    "wc_paid_at" => $wc_order->date_paid ?? null,
                    "wc_modified_at" => $wc_order->date_modified ?? null,
                    "wc_completed_at" => $wc_order->date_completed ?? null,
                ]);

                $this->info("Updated Order #{$order->wc_order_id} dates");
            } catch(\Exception $e) {
                $this->error("Error: " . $e->getMessage());
            }
        }
    }
}
