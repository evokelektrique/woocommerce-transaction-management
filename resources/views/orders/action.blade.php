<a class="btn btn-sm btn-secondary my-2 py-2" href="{{ route('order.show', $id) }}" data-bs-toggle="popover"
    data-bs-placement="left" data-bs-title="More Info" data-bs-custom-class="custom-popover"
    data-bs-content="Order metadata, accounts, notes ..." data-bs-trigger="hover">
    <i class="d-flex bi bi-journals"></i>
</a>

<a class="btn btn-sm btn-secondary my-2 py-2" href="{{ route('customer.show', $customer['id']) }}"
    data-bs-toggle="popover" data-bs-placement="left" data-bs-title="Customer" data-bs-custom-class="custom-popover"
    data-bs-content="Retrieve customer information" data-bs-trigger="hover">
    <i class="d-flex bi bi-person"></i>
</a>
