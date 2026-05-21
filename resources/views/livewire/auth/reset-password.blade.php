<x-layouts.auth>
    <div class="flex flex-col gap-4 border-3  border-gray-300 rounded-xl p-4 bg-white">
        
        <div class="flex justify-center mb-2">
            <img src="{{ asset('app-image.png') }}" alt="アプリ画像" class="w-72 h-auto">
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <p class="font-bold text-lg my-1">パスワードの設定</p>

        <form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-6">
            @csrf
            <!-- Token -->
            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            <!-- Email Address -->
            <flux:input
                name="email"
                value="{{ request('email') }}"
                label="メールアドレス"
                type="email"
                required
                autocomplete="email"
            />

            <!-- Password -->
            <flux:input
                name="password"
                label="新しいパスワード"
                type="password"
                required
                autocomplete="new-password"
                viewable
            />

            <!-- Confirm Password -->
            <flux:input
                name="password_confirmation"
                label="新しいパスワード（確認）"
                type="password"
                required
                autocomplete="new-password"
                viewable
            />

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full !bg-[#C4C598] mt-2 text-black" data-test="reset-password-button">
                    登　録
                </flux:button>
            </div>
        </form>
    </div>
</x-layouts.auth>
