<time data-bs-toggle="popover" data-bs-placement="left" data-bs-title="Updated at" data-bs-custom-class="custom-popover" data-bs-content="{{ $updated_at }}" data-bs-trigger="hover">
    {{ \Carbon\Carbon::createFromTimeStamp(strtotime($updated_at))->diffForHumans() }}
</time>
