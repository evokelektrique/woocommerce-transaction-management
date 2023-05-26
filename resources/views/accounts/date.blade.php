<time data-bs-toggle="popover" data-bs-placement="left" data-bs-title="Date created at in WooCommerce" data-bs-custom-class="custom-popover" data-bs-content="{{ $date }}" data-bs-trigger="hover">
    {{ \Carbon\Carbon::createFromTimeStamp(strtotime($date))->diffForHumans() }}
</time>
