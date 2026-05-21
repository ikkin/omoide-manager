<x-layouts.auth>
    <div class="flex flex-col gap-4 border-3  border-gray-300 rounded-xl p-4 bg-white">

        <div class="flex justify-center mb-2">
            <img src="{{ asset('app-image.png') }}" alt="アプリ画像" class="w-72 h-auto">
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <p class="font-bold text-lg my-1">パスワードの再設定</p>

        <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <flux:input
                name="email"
                label="登録済みのメールアドレス"
                type="email"
                required
                autofocus
                placeholder="email@example.com"
            />

            <flux:button variant="primary" type="submit" class="w-full !bg-[#C4C598] mt-2 text-black" data-test="email-password-reset-link-button">
                送　信
            </flux:button>
        </form>

        <div class="text-start text-sm">
            <flux:link :href="route('login')" wire:navigate class="!text-zinc-600">ログイン画面に戻る</flux:link>
        </div>
    </div>
</x-layouts.auth>
