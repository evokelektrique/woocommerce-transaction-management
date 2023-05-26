<time data-bs-toggle="popover" data-bs-placement="left" data-bs-title="Expire at" data-bs-custom-class="custom-popover" data-bs-content="{{ $expire_at }}" data-bs-trigger="hover">
    {{ \Carbon\Carbon::createFromTimeStamp(strtotime($expire_at))->diffForHumans() }}
</time>
