<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="{{ route('welcome') }}">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Base -->
            <div>
                <x-label for="base" value="拠点" />
                <select id="base" name="base" class="rounded-lg mt-1 w-full">
                    @foreach($bases as $base_id => $base_name)
                        <option value="{{ $base_id }}">{{ $base_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- User ID -->
            <div class="mt-4">
                <x-label for="user_id" value="ユーザーID" />
                <x-input id="user_id" class="block mt-1 w-full" type="text" name="user_id" :value="old('user_id')" required autocomplete="off" />
            </div>

            <!-- User Name -->
            <div class="mt-4">
                <x-label for="user_name" value="氏名" />
                <x-input id="user_name" class="block mt-1 w-full" type="text" name="user_name" :value="old('user_name')" required autocomplete="off" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" value="メールアドレス" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="off" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" value="パスワード" />
                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" value="確認パスワード" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>
            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-3">
                    登録
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
