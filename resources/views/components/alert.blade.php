<div id="alert_div" class="mx-5 mb-2">
    @if(session('alert_success'))
        <div id="alert_success" class="bg-blue-100 border border-blue-500 text-blue-700 px-4 py-3 rounded mt-5">
            <p class="text-sm">{!! nl2br(e(session('alert_success'))) !!}</p>
        </div>
    @endif
    @if(session('alert_danger'))
        <div id="alert_danger" class="bg-red-200 border border-red-500 text-red-700 px-4 py-3 rounded mt-5">
            <p class="text-sm">{!! nl2br(e(session('alert_danger'))) !!}</p>
        </div>
    @endif
    @foreach ($errors->all() as $error)
        <div class="bg-red-200 border border-red-500 text-red-700 px-4 py-3 rounded mt-5">
            <li class="text-sm text-red-700">{{ $error }}</li>
        </div>
    @endforeach
</div>