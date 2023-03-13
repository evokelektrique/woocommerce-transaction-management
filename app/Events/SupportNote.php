<?php

namespace App\Events;

use App\Models\User;
use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SupportNote implements ShouldBroadcast {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $message;
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Order $order, String $message) {
        $this->order = $order;
        $this->message = $message;
        $this->user = $user;
    }

    public function broadcastWith() {
        return [
            'order' => $this->order,
            'user' => $this->user,
            'message' => $this->message,
            'on' => now()->setTimezone("UTC"),
        ];
    }

    public function broadcastAs() {
        return 'support-note';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn() {
        return new Channel('notes');
    }
}
