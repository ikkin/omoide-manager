<x-layouts.auth>
    <div class="flex flex-col gap-4 border-2 border-zinc-400 rounded-xl p-4 bg-white">
        
        <div class="flex justify-center mb-2">
            <img src="{{ asset('app-image-bg-white.png') }}" alt="アプリ画像" class="w-72 h-auto">
        </div>

        <p class="font-bold text-lg my-1">ログイン</p>

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <flux:input
                name="email"
                label="メールアドレス"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="email@example.com"
            />

            <!-- Password -->
            <div class="relative">
                <flux:input
                    name="password"
                    label="パスワード"
                    type="password"
                    required
                    autocomplete="current-password"
                    viewable
                />

                @if (Route::has('password.request'))
                    <flux:link class="absolute top-0 text-sm end-0 !text-zinc-600" :href="route('password.request')" wire:navigate>
                        パスワードを再設定する
                    </flux:link>
                @endif
            </div>

            {{-- <!-- Remember Me -->
            <flux:checkbox name="remember" :label="__('Remember me')" :checked="old('remember')" /> --}}

            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full !bg-[#807E79] !text-white mt-2 hover:bg-zinc-300! cursor-pointer" data-test="login-button">
                    ログイン
                </flux:button>
            </div>
        </form>

        @if (Route::has('register'))
            <div class="text-sm text-start">
                <p class="mb-1">アカウントをお持ちでない方</p>
                <flux:link :href="route('register')" wire:navigate class="!text-zinc-600">こちらから登録</flux:link>
            </div>
        @endif
    </div>
</x-layouts.auth>
