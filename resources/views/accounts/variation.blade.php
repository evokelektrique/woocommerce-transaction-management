<div class="d-flex gap-1 flex-column">
    @if (gettype($order["variation"]) === 'string')
        @foreach (json_decode($order["variation"], true) as $variation)
            <div class="text-dark">
                {{-- Product name --}}
                <span class="d-inline-block">
                    {{ $variation['product_name'] }}
                    &bull;
                </span>

                {{-- Quantity --}}
                <span class="d-inline-block">
                    x{{ $variation['quantity'] }}
                    &bull;
                </span>

                {{-- Variations --}}
                @forelse($variation["variations"] as $var)
                    <span class="d-inline-block">{{ $var['value'] }}</span>
                    @if (!$loop->last)
                        &bull;
                    @endif
                @empty
                    No variation found
                @endforelse
            </div>
        @endforeach
    @else
        @foreach ($order["variation"] as $variation)
            <div class="text-dark">
                {{-- Product name --}}
                <span class="d-inline-block">
                    {{ $variation['product_name'] }}
                    &bull;
                </span>

                {{-- Quantity --}}
                <span class="d-inline-block">
                    x{{ $variation['quantity'] }}
                    &bull;
                </span>

                {{-- Variations --}}
                @forelse($variation["variations"] as $var)
                    <span class="d-inline-block">{{ $var['value'] }}</span>
                    @if (!$loop->last)
                        &bull;
                    @endif
                @empty
                    No variation found
                @endforelse
            </div>
        @endforeach
    @endif
</div>
