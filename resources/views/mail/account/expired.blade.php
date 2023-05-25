<x-mail::message>
# سلام {{ $token1 }}

سفارش ( {{ $token2 }} ) منقضی شده و هم اکنون در انتظار تمدید اشتراک میباشد.

جهت تمدید اشتراک از طریق سایت ، خرید جدیدی ثبت کنید:
<a href="https://account4all.ir">Account4all.ir</a>

<x-mail::button :url="$url">
مشاهده سفارش
</x-mail::button>

</x-mail::message>
