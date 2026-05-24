@php
    use App\Constants\ItemConstants;
@endphp

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
                <x-form-label label='名称' />
                <p class="pl-2">{{ $item->item_name }}</p>
            </div>

            <div class="flex flex-col gap-1">
                <x-form-label label='カテゴリ' />
                <p class="pl-2">{{ $item->category->category_name }}</p>
            </div>

            <div class="flex flex-col gap-1">
                <x-form-label label='型番' />
                <p class="pl-2">{{ $item->model_no ?? '　' }}</p>
            </div>

            <div class="flex flex-col gap-1">
                <x-form-label label='状態' />
                <p class="pl-2">{{ ItemConstants::CONDITIONS[$item->condition] }}</p>
            </div>

            <div class="flex flex-col gap-1">
                <x-form-label label='状態詳細' />
                <p class="pl-2">{{ $item->condition_detail ?? '　' }}</p>
            </div>

            {{-- 処分方針 --}}
            <div class="flex flex-col gap-2">
                <x-form-label label='処分方針' />

                <p class="flex items-center gap-2 pointer-events-none">
                    <input 
                        type="radio"
                        class="scale-125 ml-2"
                        @if($item->disposal_plan == ItemConstants::DISPOSAL_PLAN_DISCARD) checked @endif
                    >
                    <span class="flex items-center rounded gap-2 flex-1 min-w-0 px-2"
                            style="background-color: {{ ItemConstants::DISPOSAL_COLOR_CODES[ItemConstants::DISPOSAL_PLAN_DISCARD] }}"
                    >
                        <span class="font-semibold whitespace-nowrap my-1 py-2">廃棄</span>
                        <span class="text-sm whitespace-nowrap">廃棄費用</span>
                        <span class="my-2 px-2 py-1 flex-1 min-w-0 text-end">{{ $item->discard_cost }}</span>
                        <span>円</span>
                    </span>
                </p>

                <p class="flex items-center gap-2 pointer-events-none">
                    <input
                        type="radio"
                        class="scale-125 ml-2"
                        @if($item->disposal_plan == ItemConstants::DISPOSAL_PLAN_SALE) checked @endif
                    >
                    <span class="flex items-center rounded gap-2 flex-1 min-w-0 px-2"
                            style="background-color: {{ ItemConstants::DISPOSAL_COLOR_CODES[ItemConstants::DISPOSAL_PLAN_SALE] }}"
                    >
                        <span class="font-semibold whitespace-nowrap my-1 py-2">売却</span>
                        <span class="text-sm whitespace-nowrap">売却価格</span>
                        <span class="my-2 px-2 py-1 flex-1 min-w-0 text-end">{{ $item->sale_price }}</span>
                        <span>円</span>
                    </span>
                </p>

                <p class="flex items-center gap-2 pointer-events-none">
                    <input
                        type="radio"
                        class="scale-125 ml-2"
                        @if($item->disposal_plan == ItemConstants::DISPOSAL_PLAN_TRANSFER) checked @endif
                    >
                    <span class="flex items-center rounded gap-2 flex-1 min-w-0 px-2"
                            style="background-color: {{ ItemConstants::DISPOSAL_COLOR_CODES[ItemConstants::DISPOSAL_PLAN_TRANSFER] }}"
                    >
                        <span class="font-semibold whitespace-nowrap my-1 py-2">譲渡</span>
                        <span class="text-sm whitespace-nowrap">譲渡先</span>
                        <span class="my-2 px-2 py-1 flex-1 min-w-0 text-start">{{ $item->transfer_target }}</span>
                    </span>
                </p>

                <p class="flex items-center gap-2 pointer-events-none">
                    <input
                        type="radio"
                        class="scale-125 ml-2"
                        @if($item->disposal_plan == ItemConstants::DISPOSAL_PLAN_STORAGE) checked @endif
                    >
                    <span class="flex items-center rounded gap-2 flex-1 min-w-0 px-2"
                            style="background-color: {{ ItemConstants::DISPOSAL_COLOR_CODES[ItemConstants::DISPOSAL_PLAN_STORAGE] }}"
                    >
                        <span class="font-semibold whitespace-nowrap my-1 py-2">保管</span>
                        <span class="text-sm whitespace-nowrap">保管期限</span>
                        <span class="my-2 px-2 py-1 flex-1 min-w-0 text-end">{{ $item->storage_deadline?->format('Y年m月d日') }}</span>
                        <span class="whitespace-nowrap">まで</span>
                    </span>
                </p>

                <p class="flex items-center gap-2 pointer-events-none">
                    <input 
                        type="radio"
                        class="scale-125 ml-2"
                        @if($item->disposal_plan == ItemConstants::DISPOSAL_PLAN_NONE) checked @endif
                    >
                    <span class="font-semibold rounded flex-1 my-1 px-2 py-2"
                            style="background-color: {{ ItemConstants::DISPOSAL_COLOR_CODES[ItemConstants::DISPOSAL_PLAN_NONE] }}"
                    >
                        未指定
                    </span>
                </p>

            </div>
        </div>

        {{-- 右カラム：ステータス・AI・備考 --}}
        <div class="flex flex-col gap-4 md:w-1/3">

            <div class="flex flex-col gap-1">
                <x-form-label label='処分ステータス' />
                <p class="pl-2">{{ ItemConstants::DISPOSAL_STATUSES[$item->disposal_status] }}</p>
            </div>

            <div class="flex flex-col gap-1">
                <x-form-label label='AIによる廃棄の提案（参考情報）' />
                @if($item->ai_text === null)
                    <p class="pl-2">未取得</p>
                @else
                    {{-- モーダルを開くリンク --}}
                    <flux:modal.trigger name="ai-suggestion">
                        <span class="pl-2 text-blue-500 cursor-pointer underline">表示する</span>
                    </flux:modal.trigger>
                @endif
            </div>

            {{-- AIの提案内容モーダル --}}
            <flux:modal name="ai-suggestion" class="md:w-[600px]">
                <div class="space-y-4">
                    <flux:heading size="lg">AIによる廃棄の提案</flux:heading>
                    <p class="text-xs text-gray-500">※あくまで参考情報です。実際の廃棄方法は各自治体の規則に従ってください。</p>

                    @if($item->ai_text)
                        @foreach($item->ai_text as $suggestion)
                            <div class="border rounded p-3 flex flex-col gap-1">
                                <p class="font-bold">{{ $suggestion['method'] }}</p>
                                <p class="text-sm">概要：{{ $suggestion['overview'] }}</p>
                                <p class="text-sm">費用感：{{ $suggestion['cost'] }}</p>
                                <p class="text-sm">手間：{{ $suggestion['effort'] }}</p>
                                <p class="text-sm">注意点：{{ $suggestion['notes'] }}</p>
                            </div>
                        @endforeach
                    @endif

                    <div class="flex justify-end">
                        <flux:modal.close>
                            <flux:button variant="ghost">閉じる</flux:button>
                        </flux:modal.close>
                    </div>
                </div>
            </flux:modal>

            <div class="flex flex-col gap-1">
                <x-form-label label='備考' />
                <textarea class="border border-gray-300 rounded p-1 h-32" readonly>{{ $item->remark }}</textarea>
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
            class="px-6 py-2 !bg-[#C4C598] rounded hover:bg-gray-500!"
        >
            編集
        </flux:button>

        <flux:button 
            type="button"
            icon="trash" 
            wire:click="delete({{ $item->id }})" 
            wire:confirm="本当に削除しますか? "
            class="px-6 py-2 !bg-[#C4C598] rounded cursor-pointer hover:bg-gray-500!"
        >
            削除
        </flux:button>
        <flux:button
            type="button"
            icon="arrow-uturn-left"
            wire:navigate
            href="{{ route('search-items') }}?autoSearch=true"
            class="px-6 py-2 !bg-[#C4C598] rounded hover:bg-gray-500!"
        >
            戻る
        </flux:button>
    </div>

</main>