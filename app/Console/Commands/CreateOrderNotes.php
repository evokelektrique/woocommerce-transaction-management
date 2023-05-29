<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use App\Repositories\NoteRepository;

class CreateOrderNotes extends Command {
    private $noteRepository;

    public function __construct(NoteRepository $noteRepository) {
        parent::__construct();

        $this->noteRepository = $noteRepository;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:notes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate notes for all orders';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): void {
        $orders = Order::all();

        foreach ($orders as $order) {
            // Delete and fetch all order notes before adding new ones, to prevent duplication.
            $notes = $this->noteRepository->createNotes($order);
            $notes_count = count($notes);

            $this->info("Order #{$order->id} - Added {$notes_count} notes");
        }
    }
}
