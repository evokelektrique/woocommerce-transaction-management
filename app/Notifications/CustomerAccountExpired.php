<?php

namespace App\Notifications;

use App\Models\Account;
use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Kavenegar\Laravel\Message\KavenegarMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Kavenegar\Laravel\Notification\KavenegarBaseNotification;

class CustomerAccountExpired extends KavenegarBaseNotification {
    use Queueable;

    protected $account;
    protected $tokens;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Account $account) {
        $this->account = $account;
        $this->tokens = [];

        $this->tokens["token1"] = $this->account->order->customer->first_name;
        $this->tokens["token2"] = $this->account->title;
    }

    public function via($notifiable) {
        // return ['kavenegar', 'database', 'mail'];
        return ['database', 'mail'];
    }

    public function toKavenegar($notifiable) {
        return (new KavenegarMessage())
            ->verifyLookup(
                env("KAVENEGAR_TEMPLATE_CUSTOMER_ACCOUNT_EXPIRED"),
                [
                    $this->tokens["token1"],
                    $this->tokens["token2"]
                ]
            );
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage {
        $url = "http://google.com";

        return (new MailMessage)
        ->markdown('mail.account.expired', ['url' => $url]);
    }

    public function toDatabase($notifiable) {
        return [
            "customer_id" => $notifiable->id,
            "account_id" => $this->account->id,
            "tokens" => [
                "token1" => $this->tokens["token1"],
                "token2" => $this->tokens["token2"],
            ],
        ];
    }
}
