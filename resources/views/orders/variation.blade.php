@php
    $variation = json_decode($variation, true);
@endphp
<div class="bg-primary rounded p-2" style="max-width: 420px">
    {{-- Product name --}}
    <div class="badge rounded border border-dark fw-bold border-2 text-dark p-0 my-1 d-flex align-items-center justify-content-between gap-3">
        <span class="bg-dark px-1 py-2 text-white text-truncate">Product</span>
        <span class="bg-dark px-1 py-2 text-white text-truncate">{{ $variation['product_name'] }}</span>
    </div>

    {{-- Quantity --}}
    <div class="badge rounded border border-dark fw-bold border-2 text-dark p-0 my-1 d-flex align-items-center justify-content-between gap-3">
        <span class="bg-dark px-1 py-2 text-white text-truncate">Quantity</span>
        <span class="bg-dark px-1 py-2 text-white text-truncate">{{ $variation['quantity'] }}</span>
    </div>

    {{-- Variations --}}
    <ul class="list-unstyled m-0">
        @forelse($variation["variations"] as $var)
            @foreach ($var as $key => $value)
                <li class="badge rounded border border-dark fw-bold border-2 text-dark p-0 my-1 d-flex align-items-center justify-content-between gap-3">
                    <span class="bg-dark px-1 py-2 text-white text-truncate">{{ $key }}</span>
                    <span class="bg-dark px-1 py-2 text-white text-truncate">{{ $value }}</span>
                </li>
            @endforeach
        @empty
            No variation found
        @endforelse
    </ul>
</div>
