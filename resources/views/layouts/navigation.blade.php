<header class="nav-header py-2">
    <div class="grid grid-cols-12">
        <div class="col-span-2">
            <input type="checkbox" class="menu-btn" id="menu-btn">
            <label for="menu-btn" class="menu-icon"><span class="navicon"></span></label>
            <ul class="menu">
                <li><a href="{{ route('punch.index') }}">打刻</a></li>
                <li><a href="{{ route('punch_manual.index') }}">手動打刻</a></li>
                <li><a href="{{ route('kintai_list.index') }}">勤怠一覧</a></li>
                <li><a href="{{ route('employee_list.index') }}">従業員一覧</a></li>
                <li><a href="{{ route('over_time_rank.index') }}">残業ランキング</a></li>
                <li><a href="{{ route('kintai_report_output.index') }}">勤怠表出力</a></li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">ログアウト</a></li>
                </form>
            </ul>
        </div>
        <p class="col-start-5 col-span-4 text-6xl text-blue-500 text-center" style="font-family:Merriweather">T<lord-icon src="https://cdn.lordicon.com/mgmiqlge.json" trigger="loop" delay="2000" style="width:50px;height:50px"></lord-icon>uch</p>
        <p class="col-start-11 col-span-2 text-right text-xl mr-3 mt-3">{{ Auth::user()->name }}</p>
    </div>
</header>