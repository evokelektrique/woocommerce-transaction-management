<div class="d-flex gap-1" style="max-width: 420px">
    @foreach (json_decode($variation, true) as $variation)
        <div class="bg-primary p-1 gap-1 rounded d-inline-flex flex-wrap" style="max-width: 420px">
            {{-- Product name --}}
            <span class="bg-dark text-white text-truncate rounded px-1">{{ $variation['product_name'] }}</span>

            {{-- Quantity --}}
            <span class="bg-dark text-white text-truncate rounded px-1">x{{ $variation['quantity'] }}</span>

            {{-- Variations --}}
            @forelse($variation["variations"] as $var)
                <ul class="list-unstyled m-0 d-inline-flex flex-wrap gap-1 bg-dark rounded text-white">
                    @foreach ($var as $key => $value)
                        <li class="d-inline-block px-1 gap-1">
                            <span class="text-truncate">{{ $value }}</span>
                        </li>
                    @endforeach
                </ul>
            @empty
                No variation found
            @endforelse
        </div>
    @endforeach
</div>
