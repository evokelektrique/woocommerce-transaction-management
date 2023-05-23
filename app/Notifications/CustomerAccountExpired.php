<?php

namespace App\Notifications;

use App\Models\Account;
use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Kavenegar\Laravel\Message\KavenegarMessage;
use Kavenegar\Laravel\Notification\KavenegarBaseNotification;

class CustomerAccountExpired extends KavenegarBaseNotification {
    use Queueable;

    protected $account;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Account $account) {
        $this->account = $account;
    }

    public function via($notifiable) {
        return ['kavenegar', 'database'];
    }

    public function toKavenegar($notifiable) {
        // dd([$notifiable->toArray(), "test"]);

        return (new KavenegarMessage())
            ->verifyLookup(env("KAVENEGAR_TEMPLATE_CUSTOMER_ACCOUNT_EXPIRED"), ['token1', 'token2']);
    }

    public function toDatabase($notifiable) {
        return [
            "customer_id" => $notifiable->id,
            "account_id" => $this->account->id,
        ];
    }
}
