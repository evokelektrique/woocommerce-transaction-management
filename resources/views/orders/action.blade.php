<a class="btn btn-sm btn-primary mb-2" href="{{ route("note.show", $id) }}" data-bs-toggle="popover" data-bs-placement="left" data-bs-title="Notes" data-bs-custom-class="custom-popover" data-bs-content="List of order notes" data-bs-trigger="hover">
    <i class="bi bi-journals"></i>
</a>

<a class="btn btn-sm btn-secondary" href="{{ route("customer.show", $customer["id"]) }}" data-bs-toggle="popover" data-bs-placement="left" data-bs-title="Customer" data-bs-custom-class="custom-popover" data-bs-content="Retrieve customer information" data-bs-trigger="hover">
    <i class="bi bi-person"></i>
</a>
