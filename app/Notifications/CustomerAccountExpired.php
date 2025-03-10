<?php

namespace App\Notifications;

use App\Models\Account;
use Illuminate\Bus\Queueable;
use Kavenegar\Laravel\Message\KavenegarMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Kavenegar\Laravel\Notification\KavenegarBaseNotification;

class CustomerAccountExpired extends KavenegarBaseNotification {
    use Queueable;

    /**
     * Temporary account variable
     *
     * @since 1.0.0
     * @var Account
     */
    protected $account;

    /**
     * Temporary Kavenegar's tokens variable
     *
     * @since 1.0.0
     * @var array
     */
    protected $tokens;

    /**
     * Mail subject
     *
     * @since 1.0.0
     * @var string
     */
    protected $mail_subject;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Account $account) {
        $this->account = $account;
        $this->tokens = [];

        // Customer first name
        $this->tokens["token1"] = $this->account->order->customer->first_name;

        // Account title (White spaces are removed)
        $this->tokens["token2"] = str_replace(" ", "", $this->account->title);

        // WooCommerce order ID
        $this->tokens["token3"] = $this->account->order->wc_order_id;

        // Mail Subject
        $this->mail_subject = "سفارش {$this->tokens["token3"]} منقضی شده است";
    }

    public function via($notifiable) {
        return ['kavenegar', 'database', 'mail'];
    }

    public function toKavenegar($notifiable) {
        return (new KavenegarMessage())
            ->verifyLookup(
                env("KAVENEGAR_TEMPLATE_CUSTOMER_ACCOUNT_EXPIRED"),
                [
                    $this->tokens["token1"],
                    $this->tokens["token2"],
                    $this->tokens["token3"],
                ]
            );
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage {
        $url = "https://account4all.ir/my-account/view-order/" . $this->tokens["token3"];

        return (new MailMessage)
            ->subject($this->mail_subject)
            ->markdown('mail.account.expired', [
                'url' => $url,
                "token1" => $this->tokens["token1"],
                "token2" => $this->tokens["token2"],
                "token3" => $this->tokens["token3"],
            ]);
    }

    public function toDatabase(object $notifiable) {
        return [
            "customer_id" => $notifiable->id,
            "account_id" => $this->account->id,
            "tokens" => [
                "token1" => $this->tokens["token1"],
                "token2" => $this->tokens["token2"],
                "token3" => $this->tokens["token3"],
            ],
        ];
    }
}
