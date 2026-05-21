<main class="p-4">
    <flux:heading size="lg" class="mb-2">家財照会</flux:heading>

    {{-- 3カラムコンテナ --}}
    <div class="flex flex-col md:flex-row gap-4">

        {{-- 左カラム：画像エリア --}}
        <div class="flex flex-col items-center gap-4 md:w-1/3">
            <div class="w-full flex items-center justify-center">
                <img
                    src="{{ $item->image_path
                            ? route('image.show', basename($item->image_path))
                            : asset('images/no-image.png')
                        }}" 
                    alt="画像"
                    class="w-full h-auto border object-contain"
                >
            </div>
        </div>

        {{-- 中央カラム：基本情報フォーム --}}
        <div class="flex flex-col gap-4 md:w-1/3">

            <div class="flex flex-col gap-1">
                <p class="text-sm font-bold bg-[#E2EBB7] px-2 py-1">名称</p>
                <p>{{ $item->item_name }}</p>
            </div>

            <div class="flex flex-col gap-1">
                <p class="text-sm font-bold bg-[#E2EBB7] px-2 py-1">カテゴリ</p>
                <p>{{ $item->category->category_name }}</p>
            </div>

            <div class="flex flex-col gap-1">
                <p class="text-sm font-bold bg-[#E2EBB7] px-2 py-1">型番</p>
                <p>{{ $item->model_no }}</p>
            </div>

            <div class="flex flex-col gap-1">
                <p class="text-sm font-bold bg-[#E2EBB7] px-2 py-1">状態</p>
                <p>{{ \App\Constants\ItemConstants::CONDITIONS[$item->condition] }}</p>
            </div>

            <div class="flex flex-col gap-1">
                <p class="text-sm font-bold bg-[#E2EBB7] px-2 py-1">状態詳細</p>
                <p>{{ $item->condition_detail }}</p>
            </div>

            {{-- 処分方針 --}}
            <div class="flex flex-col gap-2">
                <p class="text-sm font-bold bg-[#E2EBB7] px-2 py-1">処分方針</p>

                <p class="flex items-center gap-2 pointer-events-none">
                    <input 
                        type="radio"
                        class="scale-125 ml-2"
                        @if($item->disposal_plan == 1) checked @endif
                    >
                    <span class="flex items-center rounded gap-2 flex-1 min-w-0 px-2"
                            style="background-color: {{ \App\Constants\ItemConstants::DISPOSAL_COLOR_CODES[1] }}"
                    >
                        <span class="font-bold whitespace-nowrap my-1 py-2">廃棄</span>
                        <span class="text-sm whitespace-nowrap">廃棄費用</span>
                        <span class="my-2 px-2 py-1 flex-1 min-w-0 text-end">{{ $item->discard_cost }}</span>
                        <span>円</span>
                    </span>
                </p>

                <p class="flex items-center gap-2 pointer-events-none">
                    <input
                        type="radio"
                        class="scale-125 ml-2"
                        @if($item->disposal_plan == 2) checked @endif
                    >
                    <span class="flex items-center rounded gap-2 flex-1 min-w-0 px-2"
                            style="background-color: {{ \App\Constants\ItemConstants::DISPOSAL_COLOR_CODES[2] }}"
                    >
                        <span class="font-bold whitespace-nowrap my-1 py-2">売却</span>
                        <span class="text-sm whitespace-nowrap">売却価格</span>
                        <span class="my-2 px-2 py-1 flex-1 min-w-0 text-end">{{ $item->sale_price }}</span>
                        <span>円</span>
                    </span>
                </p>

                <p class="flex items-center gap-2 pointer-events-none">
                    <input
                        type="radio"
                        class="scale-125 ml-2"
                        @if($item->disposal_plan == 3) checked @endif
                    >
                    <span class="flex items-center rounded gap-2 flex-1 min-w-0 px-2"
                            style="background-color: {{ \App\Constants\ItemConstants::DISPOSAL_COLOR_CODES[3] }}"
                    >
                        <span class="font-bold whitespace-nowrap my-1 py-2">譲渡</span>
                        <span class="text-sm whitespace-nowrap">譲渡先</span>
                        <span class="my-2 px-2 py-1 flex-1 min-w-0 text-end">{{ $item->transfer_target }}</span>
                    </span>
                </p>

                <p class="flex items-center gap-2 pointer-events-none">
                    <input
                        type="radio"
                        class="scale-125 ml-2"
                        @if($item->disposal_plan == 4) checked @endif
                    >
                    <span class="flex items-center rounded gap-2 flex-1 min-w-0 px-2"
                            style="background-color: {{ \App\Constants\ItemConstants::DISPOSAL_COLOR_CODES[4] }}"
                    >
                        <span class="font-bold whitespace-nowrap my-1 py-2">保管</span>
                        <span class="text-sm whitespace-nowrap">保管期限</span>
                        <span class="my-2 px-2 py-1 flex-1 min-w-0 text-end">{{ $item->storage_deadline?->format('Y年m月d日') }}</span>
                        <span class="whitespace-nowrap">まで</span>
                    </span>
                </p>

                <p class="flex items-center gap-2 pointer-events-none">
                    <input 
                        type="radio"
                        class="scale-125 ml-2"
                        @if($item->disposal_plan == 5) checked @endif
                    >
                    <span class="font-bold rounded flex-1 my-1 px-2 py-2"
                            style="background-color: {{ \App\Constants\ItemConstants::DISPOSAL_COLOR_CODES[5] }}"
                    >
                        未指定
                    </span>
                </p>

            </div>
        </div>

        {{-- 右カラム：ステータス・AI・備考 --}}
        <div class="flex flex-col gap-4 md:w-1/3">

            <div class="flex flex-col gap-1">
                <p class="text-sm font-bold bg-[#E2EBB7] px-2 py-1">処分ステータス</p>
                <p>{{ \App\Constants\ItemConstants::DISPOSAL_STATUSES[$item->disposal_status] }}</p>
            </div>

            <div class="flex flex-col gap-1">
                <p class="text-sm font-bold bg-[#E2EBB7] px-2 py-1">
                    AIによる廃棄の提案（参考情報）
                </p>
                <p>{{ $item->ai_text ?? '未取得' }}</p>
                @if(!empty($item->ai_text))
                    <a href="">表示する</a>
                @endif
            </div>

            <div class="flex flex-col gap-1">
                <p class="text-sm font-bold bg-[#E2EBB7] px-2 py-1">
                    備考
                </p>
                <textarea class="border border-gray-300 rounded p-1 h-24" readonly>{{ $item->remark }}</textarea>
            </div>

        </div>
    </div>

    {{-- 編集・削除・戻るボタン --}}
    <div class="flex justify-end gap-4 mt-8">
        <flux:button 
            type="button"
            icon="pencil" 
            href="{{ route('items.edit', $item->id) }}"
            wire:navigate
            class="px-6 py-2 !bg-[#C4C598] rounded"
        >
            編集
        </flux:button>

        <flux:button 
            type="button"
            icon="trash" 
            wire:click="delete({{ $item->id }})" 
            wire:confirm="本当に削除しますか? "
            class="px-6 py-2 !bg-[#C4C598] rounded"
        >
            削除
        </flux:button>
        <flux:button
            type="button"
            icon="arrow-uturn-left"
            wire:navigate
            href="{{ route('search-items') }}?autoSearch=true"
            class="px-6 py-2 !bg-[#C4C598] rounded"
        >
            戻る
        </flux:button>
    </div>

</main>