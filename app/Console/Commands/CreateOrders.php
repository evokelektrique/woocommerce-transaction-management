<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\NoteRepository;
use App\Repositories\OrderRepository;
use App\Repositories\AccountRepository;
use App\Repositories\CustomerRepository;
use Automattic\WooCommerce\Client as WooCommerce;

class CreateOrders extends Command {
    /**
     * WooCommerce client SDK
     *
     * @since 1.0.0
     * @var WooCommerce
     */
    private $woocommerce;

    /**
     * Current page of woocommerce orders endpoint
     *
     * @since 1.0.0
     * @var int
     */
    private $page;

    /**
     * Customer Repository
     *
     * @since 1.0.0
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * Order Repository
     *
     * @since 1.0.0
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * Note Repository
     *
     * @since 1.0.0
     * @var NoteRepository
     */
    private $noteRepository;

    /**
     * Customer Repository
     *
     * @since 1.0.0
     * @var AccountRepository
     */
    private $accountRepository;

    /**
     * Total items per page
     *
     * @since 1.0.0
     */
    const PER_PAGE_ITEM = 100;

    public function __construct(WooCommerce $woocommerce, OrderRepository $orderRepository, CustomerRepository $customerRepository, AccountRepository $accountRepository, NoteRepository $noteRepository) {
        parent::__construct();

        $this->page = 1;
        $this->woocommerce = $woocommerce;
        $this->orderRepository = $orderRepository;
        $this->customerRepository = $customerRepository;
        $this->accountRepository = $accountRepository;
        $this->noteRepository = $noteRepository;
    }

    /**
     * The name and signature of the console command.
     *
     * @since 1.0.0
     * @var string
     */
    protected $signature = 'order:create';

    /**
     * The console command description.
     *
     * @since 1.0.0
     * @var string
     */
    protected $description = 'Fetch orders from WooCommerce website and insert them into database';

    /**
     * Execute the console command.
     *
     * @since 1.0.0
     * @return int
     */
    public function handle() {

        $total_items = $this->get_total_items();
        $total_pages = $this->get_total_pages($total_items);

        for ($i = 0; $i < $total_pages; $i++) {
            // Fetch orders
            $wc_orders = $this->get_wc_orders($this->page);
            $this->info("Total orders found $total_items");
            $this->info("Found " . count($wc_orders) . " items at page " . $this->page);

            foreach ($wc_orders as $wc_order) {
                // Skip if no customer found or the order is made by a guest
                if (!isset($wc_order->customer_id) || $wc_order->customer_id === 0) {
                    continue;
                }

                try {
                    // Create customer
                    $customer_data = $this->get_customer_by_id($wc_order->customer_id);
                    $customer = $this->customerRepository->createFromArray($customer_data);
                } catch (\Exception $e) {
                    $this->error("Couldn't create customer for WC_Order {$wc_order->id}, skipped");
                }

                try {
                    // Create order
                    $order_data = $this->convert_order($wc_order);
                    $order = $this->orderRepository->createFromArray($customer, $order_data);
                } catch (\Exception $e) {
                    $this->error("Couldn't create order for WC_Order {$wc_order->id}, skipped");
                }

                try {
                    // Create notes
                    // Delete and fetch all order notes before adding new ones, to prevent duplication.
                    $notes = $this->noteRepository->createNotes($order);
                    $notes_count = count($notes);
                    $this->info("WC_Order #{$wc_order->id} - Added {$notes_count} notes");
                } catch (\Exception $e) {
                    $this->error("Couldn't create notes for WC_Order {$wc_order->id}, skipped");
                }

                // Create accounts
                if (!isset($order->metadata) || empty($order->metadata["order_dynamic_fields"]) || empty($order->metadata)) {
                    $this->error("WC_Order #{$wc_order->id} - Empty meta data, skipped");
                    continue;
                }
                foreach ($order->metadata["order_dynamic_fields"] as $account) {
                    if (empty($account) || !isset($account["field_title"])) {
                        $this->error("WC_Order #{$wc_order->id} - Empty account, skipped");
                        continue;
                    }

                    try {
                        $account = $this->accountRepository->createOrUpdate($order, $account);
                        $this->info("WC_Order #{$wc_order->id} - New account #{$account->id} created");
                    } catch (\Exception $e) {
                        $this->error("WC_Order #{$wc_order->id} - Caught an error, skipped");
                        continue;
                    }
                }
            }

            // Increase page
            $this->page++;
        }
    }

    /**
     * Fetch customer data by its ID from WooCommerce website
     *
     * @since 1.0.0
     * @param integer $customer_id
     * @return array
     */
    private function get_customer_by_id(int $customer_id): array {
        $customer = $this->woocommerce->get("customers/$customer_id");
        $phone = null;

        foreach ($customer->meta_data as $meta_data) {
            if ($meta_data->key === "phone") {
                $phone = $meta_data->value;
            }
        }

        return [
            "email"      => $customer->email,
            "first_name" => $customer->first_name,
            "last_name"  => $customer->last_name,
            "username"   => $customer->username,
            "phone"      => $phone,
        ];
    }

    /**
     * Fetch orders from WooCommerce
     *
     * @since 1.0.0
     * @param integer $page
     * @return mixed
     */
    private function get_wc_orders(int $page): mixed {
        return $this->woocommerce->get("orders", [
            "per_page" => self::PER_PAGE_ITEM,
            "page"     => $page
        ]);
    }

    /**
     * Fetch total orders from X-WP-Total header of Guzzle http client
     *
     * @since 1.0.0
     * @return integer
     */
    private function get_total_items(): int {
        $this->woocommerce->get("orders", ["per_page" => 1]);
        $headers = $this->woocommerce->http->getResponse()->getHeaders();

        return (int)($headers['X-WP-Total'] ?? $headers['x-wp-total']);
    }

    /**
     * Calculate total pages
     *
     * @since 1.0.0
     * @param integer $total_items
     * @return integer
     */
    private function get_total_pages(int $total_items): int {
        return ceil($total_items / self::PER_PAGE_ITEM);
    }

    private function convert_order(object $wc_order): array {
        $dynamic_fields = $this->get_order_dynamic_fields($wc_order->meta_data);
        $product_fields = $this->get_order_product_fields($wc_order);
        $order_items    = $this->convert_order_items($this->get_order_items($wc_order));

        $data = [
            "id"       => $wc_order->id,
            "status"   => $wc_order->status,
            "price"    => $wc_order->total,
            "items"    => $order_items,
            "metadata" => [
                "telegram"               => $product_fields["telegram"] ?? "undefined",
                "whatsapp"               => $product_fields["whatsapp"] ?? "undefined",
                "order_dynamic_fields"   => $dynamic_fields,
                "product_dynamic_fields" => [],
            ],
        ];

        return $data;
    }

    /**
     * Retrieve accounts from meta data
     *
     * @since 1.0.0
     * @param array $meta_data
     * @return array
     */
    private function get_order_dynamic_fields(array $meta_data): array {
        $keys = [];
        $accounts = [];

        foreach ($meta_data as $meta) {
            if (str_contains($meta->key, "_order_dynamic_fields|||")) {
                $keys[] = $meta->key;
            }
        }

        foreach ($keys as $key => $value) {
            $needles = [
                "field_title"       => "_order_dynamic_fields|field_title|$key|0|value",
                "field_email"       => "_order_dynamic_fields|field_email|$key|0|value",
                "field_username"    => "_order_dynamic_fields|field_username|$key|0|value",
                "field_password"    => "_order_dynamic_fields|field_password|$key|0|value",
                "field_code"        => "_order_dynamic_fields|field_code|$key|0|value",
                "field_date"        => "_order_dynamic_fields|field_date|$key|0|value",
                "field_guarantee"   => "_order_dynamic_fields|field_guarantee|$key|0|value",
                "field_expire_days" => "_order_dynamic_fields|field_expire_days|$key|0|value",
            ];

            foreach ($meta_data as $meta) {
                foreach ($needles as $needle_index => $needle) {
                    if ($meta->key === $needle) {
                        $accounts[$key][$needle_index] = $meta->value;
                    }
                }
            }
        }

        return $accounts;
    }

    /**
     * Fetch Carbon fields from product fields of its meta data
     *
     * @since 1.0.0
     * @param object $wc_order
     * @return array
     */
    private function get_order_product_fields(object $wc_order): array {
        $data = [];
        $keys = ["telegram" => "_billing_telegram", "whatsapp" => "_billing_whatsapp"];

        foreach ($wc_order->meta_data as $meta_data) {
            foreach ($keys as $index => $key) {
                if ($meta_data->key === $key) {
                    $data[$index] = $meta_data->value;
                }
            }
        }

        return $data;
    }

    private function get_order_items(object $wc_order): array {
        return $wc_order->line_items;
    }

    private function convert_order_items(array $items): array {
        $data = [];

        foreach ($items as $index => $item) {
            $variations = [];

            foreach ($item->meta_data as $meta_data) {
                $variations[] = [
                    "key"   => $meta_data->key,
                    "value" => $meta_data->value,
                ];
            }

            $data[$index] = [
                "product_name" => $item->name,
                "quantity"     => $item->quantity,
                "variations"   => $variations,
            ];
        }

        return $data;
    }
}
