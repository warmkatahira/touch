{{-- <nav x-data="{ open: false }" class="bg-white border-b border-gray-500">
    <!-- Primary Navigation Menu -->
    <div class="mx-5">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('punch.menu') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                    </a>
                </div>
            </div>
            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            @auth
                                <div class="navtext-container">
                                    <div class="navtext">company</div>
                                </div>
                                <input type="checkbox" class="menu-btn" id="menu-btn">
                                <label for="menu-btn" class="menu-icon"><span class="navicon"></span></label>
                            @endauth
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>
 --}}

{{-- <header class="nav-header py-2">
    <div class="navtext-container">
        <p class="text-6xl text-blue-500" style="font-family:DynaPuff">T<i class="las la-clock la-xs la-spin"></i>uch</p>
    </div>
    <input type="checkbox" class="menu-btn" id="menu-btn">
    <label for="menu-btn" class="menu-icon"><span class="navicon"></span></label>
    <ul class="menu">
        <li><a href="{{ route('punch.menu') }}">打刻</a></li>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">ログアウト</a></li>
        </form>
    </ul>
</header> --}}

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