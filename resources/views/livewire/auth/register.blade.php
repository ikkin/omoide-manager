<x-layouts.auth>
    <div class="flex flex-col gap-4 border-2 border-zinc-400 rounded-xl p-4 bg-white">

        <div class="flex justify-center mb-2">
            <img src="{{ asset('app-image-bg-white.png') }}" alt="アプリ画像" class="w-72 h-auto">
        </div>

        <p class="text-center text-sm">
            このアプリは思い出の品々（家財）を<br>
            「廃棄」「売却」「譲渡」「保管」<br>
            の４つの処分方針で選択して登録し、<br>
            管理するアプリです。
        </p>

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <p class="font-bold text-lg my-1">アカウントの作成</p>

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-4">
            @csrf

            <!-- Name -->
            <flux:input
                name="name"
                label="ユーザー名"
                type="text"
                required
                autofocus
                autocomplete="name"
                placeholder="username"
            />

            <!-- Email Address -->
            <flux:input
                name="email"
                label="メールアドレス"
                type="email"
                required
                autocomplete="email"
                placeholder="email@example.com"
            />

            <!-- Password -->
            <div>
                <flux:input
                    name="password"
                    label="パスワード"
                    type="password"
                    required
                    autocomplete="new-password"
                    viewable
                />
            </div>

            <!-- Confirm Password -->
            <flux:input
                name="password_confirmation"
                label="パスワード（確認）"
                type="password"
                required
                autocomplete="new-password"
                viewable
            />

            <flux:button type="submit" variant="primary" class="w-full !bg-[#807E79] mt-2 !text-white hover:bg-zinc-300! cursor-pointer">
                登　録
            </flux:button>
        </form>

        <div class="text-start text-sm">
            <p class="mb-1">アカウントをお持ちの方</p>
            <flux:link :href="route('login')" wire:navigate class="!text-zinc-600">こちらからログイン</flux:link>
        </div>

    </div>
</x-layouts.auth>