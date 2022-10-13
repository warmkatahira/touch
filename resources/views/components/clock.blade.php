<script src="{{ asset('js/clock.js') }}" defer></script>
<link rel="stylesheet" href="{{ asset('css/clock.css') }}">

<!-- 時計を表示 -->
<div class="col-start-4 col-span-9 clock_container rounded-lg">
    <div class="clock grid grid-cols-12" style="font-family:'Share Tech Mono'">
        <p class="clock-date col-span-6 text-5xl py-2 text-center"></p>
        <p class="clock-time col-span-6 text-6xl py-1 text-center"></p>
    </div>
</div>