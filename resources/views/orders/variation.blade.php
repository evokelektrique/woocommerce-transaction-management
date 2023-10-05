<div class="d-flex gap-1 flex-column">
    @if (gettype($variation) === 'string')
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
                @isset($variation['variations'])
                    @forelse($variation["variations"] as $var)
                        <span class="d-inline-block">{{ $var['value'] }}</span>
                        @if (!$loop->last)
                            &bull;
                        @endif
                    @empty
                        No variation found
                    @endforelse
                @endisset
            </div>
        @endforeach
    @else
        @foreach ($variation as $variation)
            <div class="text-dark">

                {{-- Variation ID --}}
                <span class="d-inline-block">
                    variation_id:({{ $variation['variation_id'] }})
                    &bull;
                </span>

                {{-- Product ID --}}
                <span class="d-inline-block">
                    product_id:({{ $variation['product_id'] }})
                    &bull;
                </span>

                {{-- Quantity --}}
                <span class="d-inline-block">
                    x{{ $variation['quantity'] }}
                    &bull;
                </span>

                {{-- Product name --}}
                <span class="d-inline-block">
                    {{ $variation['product_name'] }}
                    &bull;
                </span>

                {{-- Variations --}}
                @isset($variation['variations'])
                    @forelse($variation["variations"] as $var)
                        <span class="d-inline-block">{{ $var['value'] }}</span>
                        @if (!$loop->last)
                            &bull;
                        @endif
                    @empty
                        No variation found
                    @endforelse
                @endisset
                &nbsp;-&nbsp;
            </div>
        @endforeach
    @endif
</div>
