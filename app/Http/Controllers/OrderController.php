<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Events\SupportNote;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\DataTables\OrdersDataTable;
use Illuminate\Contracts\View\View;
use App\Repositories\NoteRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\OrderRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\AccountRepository;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller {

    /**
     * Customer Repository
     *
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * Order Repository
     *
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * Note Repository
     *
     * @var NoteRepository
     */
    private $noteRepository;

    /**
     * Customer Repository
     *
     * @var AccountRepository
     */
    private $accountRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CustomerRepository $customerRepository, OrderRepository $orderRepository, NoteRepository $noteRepository, AccountRepository $accountRepository) {
        $this->middleware('auth');
        $this->customerRepository = $customerRepository;
        $this->orderRepository = $orderRepository;
        $this->noteRepository = $noteRepository;
        $this->accountRepository = $accountRepository;
    }

    public function index(OrdersDataTable $dataTable): mixed {
        $data = [];

        if (request()->filled('datepicker')) {
            $data['datepicker'] = explode(' - ', request()->get('datepicker'));
        }

        return $dataTable->with($data)->render('orders.index');
    }

    public function update_support_note(Order $order, Request $request): JsonResponse {
        $message = $request->support_note;
        $user = Auth::user();
        $order->update(["support_note" => $message]);

        event(new SupportNote($user, $order, $message));

        return response()->json(["success" => true]);
    }

    public function create(Request $request): JsonResponse {
        Log::info('incoming request', $request->toArray());

        if (empty($request->customer['email']) && empty($request->customer['phone'])) {
            return response()->json(["message" => "Email and phone not found"], 403);
        }

        // Create customer
        $customer = $this->customerRepository->create($request);

        // Create an order for customer
        $order = $this->orderRepository->create($customer, $request);

        // Create accounts for order from order's metadata
        $accounts = $this->accountRepository->create($order, $request);

        // Create notes for order
        $notes = $this->noteRepository->createNotes($order, $request);

        return response()->json([
            "customer" => $customer,
            "order"    => $order,
            "notes"    => $notes,
            "accounts" => $accounts,
        ]);
    }

    public function show(Order $order): View {
        return view("orders.show", compact("order"));
    }
}
