<x-layouts.app.header :title="$title ?? null">
    <div class="flex min-h-screen">
        <flux:main class="!p-0">
            {{ $slot }}
        </flux:main>
    </div>
</x-layouts.app.header>