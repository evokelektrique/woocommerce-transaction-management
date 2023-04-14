<div class="d-flex gap-1 flex-column">
    @foreach (json_decode($variation, true) as $variation)
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
                    <span class="d-inline-block">{{ $var["value"] }}</span>
                    @if (!$loop->last)
                        &bull;
                    @endif
            @empty
                No variation found
            @endforelse
        </div>
    @endforeach
</div>
