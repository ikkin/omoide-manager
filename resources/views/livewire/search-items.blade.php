@php
    use App\Constants\ItemConstants;
@endphp

<div class="md:flex min-h-screen p-0" x-data="{open : false}">

    {{-- スマホ用 --}}
    <div class="md:hidden bg-[#E2EBB7] p-4 border-b">
        <flux:button
            type="button"
            @click="open = !open"
            icon="arrows-up-down"
            class="w-full !bg-[#C4C597] rounded px-4 py-2"
        >
            追加・検索メニュー表示切替
        </flux:button>
    </div>
    
    {{-- サイドバー --}}
    <aside id="sidebar" class="w-full pl-4 pb-4 bg-[#E2EBB7] md:w-60 md:block" x-show="open || window.innerWidth >= 768" x-transition>
        <div>
            <section id="add-item" class="pt-4">
                <flux:heading size="lg" class="mb-2">家財新規登録</flux:heading>
                <div class="px-5">
                    <flux:button 
                        icon="plus-circle"
                        href="{{ route('items.create') }}"
                        wire:navigate size="sm"
                        class="!bg-[#C4C598] w-full hover:bg-gray-500!"
                    >
                        新規登録
                    </flux:button>    
                </div>
            </section>
            <section id="search-item" class="mt-6">
                <div>
                    <flux:heading size="lg" class="mb-2">家財検索</flux:heading>
                    <div class="px-5">
                        <flux:button
                            type="button"
                            icon="magnifying-glass"
                            wire:click="search"
                            size="sm"
                            class="!bg-[#C4C598] w-full cursor-pointer hover:bg-gray-500!"
                        >
                            検索
                        </flux:button>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <flux:heading size="lg" class="mt-2">検索条件</flux:heading>

                    <div class="flex flex-col">
                        <p class="text-sm font-bold px-2 py-1">名称</p>
                        <input type="text" wire:model="item_name" class="border border-gray-300 rounded mx-5 pl-1 bg-white">
                    </div>

                    <div class="flex flex-col">
                        <p class="text-sm font-bold px-2 py-1">カテゴリ</p>
                        <select wire:model="category_id" class="border border-gray-300 rounded mx-5 pl-1 bg-white">
                            <option value="">未選択</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col gap-1">
                        <p class="text-sm font-bold px-2 py-1">状態</p>
                        @foreach(ItemConstants::CONDITIONS as $value => $label)
                            <p class="flex items-center gap-2">
                                <input type="checkbox" wire:model="conditions" value="{{ $value }}" class="ml-5 scale-125">
                                <span class="text-sm">{{ $label }}</span>
                            </p>
                        @endforeach
                    </div>
                    
                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-bold px-2 py-1">処分方針</label>
                        @foreach(ItemConstants::DISPOSAL_PLANS as $value => $label)
                            <p class="flex items-center gap-2">
                                <input type="checkbox" wire:model="disposal_plans" value="{{ $value }}" class="ml-5 scale-125">
                                <span 
                                    class="w-4 h-4 rounded-2xl border border-gray-600 inline-block"
                                    style="background-color: {{ ItemConstants::DISPOSAL_COLOR_CODES[$value] }}"
                                >
                                </span>
                                <span class="text-sm">{{ $label }}</span>
                            </p>
                        @endforeach
                    </div>
                    
                    <div class="flex flex-col gap-1">
                        <p class="text-sm font-bold px-2 py-1">処分ステータス</p>
                        @foreach(ItemConstants::DISPOSAL_STATUSES as $value => $label)
                            <p class="flex items-center gap-2">
                                <input type="checkbox" wire:model="disposal_statuses" value="{{ $value }}" class="ml-5 scale-125">
                                <span class="text-sm">{{ $label }}</span>
                            </p>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </aside>

    {{-- 検索結果 --}}
    <main id="list-items" class="flex flex-col w-full p-2">

        {{-- 検索統計情報 --}}
        <div id="result-statistic" class="mx-4 my-2">
            <h2>家財検索結果</h2>
            <div>
                <dl class="grid grid-cols-1 md:grid-cols-3 mt-2 mb-2">
                    <div class="flex">
                        <dt>家財件数：</dt>
                        <dd>{{ $itemCount }}件</dd>
                    </div>
                    <div class="flex">
                        <dt>合計廃棄費用：</dt>
                        <dd class="text-[#FF0000]">ー{{ number_format($totalDiscardCost) }}円</dd>
                    </div>
                    <div class="flex">
                        <dt>合計売却価格：</dt>
                        <dd class="text-[#0000FF]">＋{{ number_format($totalSalePrice) }}円</dd>
                    </div>
                </dl>
            </div>
        </div>

        {{-- 検索家財一覧 --}}
        <div class="grid gird-cols-1 md:grid-cols-2 gap-6 m-4">
            @foreach ( $items as $item)
                <article 
                    class="flex p-4 shadow-lg rounded-xl hover:scale-105 transition duration-200" 
                    style="background-color: {{ ItemConstants::DISPOSAL_COLOR_CODES[$item->disposal_plan] }}"
                >
                    <a href="/items/{{ $item->id }}" class="flex gap-4 w-full">
                        <div class="flex-shrink-0">
                            <img
                                src="{{ $item->image_path
                                    ? route('image.show', basename($item->image_path))
                                    : asset('images/no-image.png')
                                 }}" 
                                alt="{{ $item->item_name }}"
                                class="w-[120px] h-[160px] object-contain border border-gray-400"
                            >
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="font-bold text-lg md:text-xl">{{ Str::limit($item->item_name, 20) }}</p>
                            <p class="mt-1 text-sm md:text-base">{{ $item->category->category_name ?? '未分類' }}</p>
                            
                            <p class="mt-5 md:mt-3 text-sm md:text-base">{{ ItemConstants::CONDITIONS[$item->condition] }}</p>
                            <p class="text-lg md:text-xl font-semibold">
                                {{ ItemConstants::DISPOSAL_PLANS[$item->disposal_plan] }}
                                @if( ($item->disposal_plan == ItemConstants::DISPOSAL_PLAN_DISCARD) && (!empty($item->discard_cost)) ) 
                                    &#40;<span class="text-[#FF0000]">{{ number_format($item->discard_cost) }} 円</span>&#41;
                                @elseif( ($item->disposal_plan == ItemConstants::DISPOSAL_PLAN_SALE) && (!empty($item->sale_price)) )
                                    &#40;<span class="text-[#0000FF]">{{ number_format($item->sale_price) }} 円</span>&#41;
                                @elseif( ($item->disposal_plan == ItemConstants::DISPOSAL_PLAN_TRANSFER) && (!empty($item->transfer_target)) )
                                    &#40;{{ Str::limit($item->transfer_target, 20) }}&#41;
                                @elseif( ($item->disposal_plan == ItemConstants::DISPOSAL_PLAN_STORAGE) && (!empty($item->storage_deadline)) )
                                    &#40;{{ $item->storage_deadline->format('Y年m月d日') }}まで&#41;
                                @endif
                            </p>
                            <p class="text-sm md:text-base">{{ ItemConstants::DISPOSAL_STATUSES[$item->disposal_status] }}</p>
                        </div>
                    </a>
                </article>
            @endforeach
        </div>
    </main>
</div>
