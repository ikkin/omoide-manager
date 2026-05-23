@php
    use App\Constants\ItemConstants;
@endphp

<main class="p-4">
    <flux:heading size="lg" class="mb-2">家財登録</flux:heading>

    {{-- 3カラムコンテナ --}}
    <div class="flex flex-col md:flex-row gap-4">

        {{-- 左カラム：画像エリア --}}
        <div class="flex flex-col items-center gap-4 md:w-1/3">
            <div class="w-full flex items-center justify-center">
                @if($image)
                    <img src="{{ $image->temporaryUrl() }}" alt="画像"
                        class="w-full h-auto border object-contain">
                @else
                    <img src="{{ asset('images/no-image.png') }}" alt="画像"
                        class="w-full h-auto border object-contain">
                @endif
            </div>
            
            {{-- 非表示のファイル入力 --}}
            <input type="file" wire:model="image" accept="image/*"
                class="hidden" id="fileInput">

            <div class="flex w-full justify-end gap-2">
                <flux:button 
                    type="button"
                    icon="photo"
                    class="px-4 py-2 !bg-[#C4C598] rounded cursor-pointer" 
                    onclick="document.getElementById('fileInput').click()"
                >
                    画像変更
                </flux:button>
                <flux:button 
                    type="button"
                    icon="trash"
                    class="px-4 py-2 !bg-[#C4C598] rounded cursor-pointer" 
                    wire:click="deleteImage"
                    wire:confirm="画像を削除してよろしいですか？"
                >
                    画像削除
                </flux:button>
            </div>
            <div>
                <x-error-message field="image" />
            </div>
        </div>

        {{-- 中央カラム：基本情報フォーム --}}
        <div class="flex flex-col gap-4 md:w-1/3">

            <div class="flex flex-col gap-1">
                <p class="text-sm font-bold bg-[#E2EBB7] px-2 py-1">
                    名称
                    <x-required-label />
                </p>
                <input type="text" wire:model="item_name" class="border border-gray-300 rounded px-2 py-1">
                <x-error-message field="item_name" />
            </div>

            <div class="flex flex-col gap-1">
                <p class="text-sm font-bold bg-[#E2EBB7] px-2 py-1">
                    カテゴリ
                    <x-required-label />
                </p>
                <select wire:model="category_id" class="border border-gray-300 rounded px-2 py-1">
                    <option value="">選択してください</option>
                     @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
                <x-error-message field="category_id" />
            </div>

            <div class="flex flex-col gap-1">
                <p class="text-sm font-bold bg-[#E2EBB7] px-2 py-1">型番</p>
                <input type="text" wire:model="model_no" class="border border-gray-300 rounded px-2 py-1">
                <x-error-message field="model_no" />
            </div>

            <div class="flex flex-col gap-1">
                <p class="text-sm font-bold bg-[#E2EBB7] px-2 py-1">
                    状態
                    <x-required-label />
                </p>
                <select wire:model="condition" class="border border-gray-300 rounded px-2 py-1">
                    @foreach(ItemConstants::CONDITIONS as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
                <x-error-message field="condition" />
            </div>

            <div class="flex flex-col gap-1">
                <p class="text-sm font-bold bg-[#E2EBB7] px-2 py-1">状態詳細</p>
                <input type="text" wire:model="condition_detail" class="border border-gray-300 rounded px-2 py-1">
                <x-error-message field="condition_detail" />
            </div>

            {{-- 処分方針 --}}
            <div class="flex flex-col gap-2">
                <p class="text-sm font-bold bg-[#E2EBB7] px-2 py-1">
                    処分方針
                    <x-required-label />
                </p>

                <p class="flex items-center gap-2">
                    <input type="radio" wire:model.live="disposal_plan" value="1" class="scale-125 ml-2">
                    <span class="flex items-center rounded gap-2 flex-1 min-w-0 px-2"
                            style="background-color: {{ ItemConstants::DISPOSAL_COLOR_CODES[ItemConstants::DISPOSAL_PLAN_DISCARD] }}"
                    >
                        <span class="font-bold whitespace-nowrap">廃棄</span>
                        <span class="text-sm whitespace-nowrap">廃棄費用</span>
                        <input type="number" wire:model="discard_cost"
                            @if($disposal_plan != ItemConstants::DISPOSAL_PLAN_DISCARD) disabled @endif
                            class="border border-gray-300 rounded my-2 px-2 py-1 flex-1 min-w-0 text-end
                                @if($disposal_plan != ItemConstants::DISPOSAL_PLAN_DISCARD)
                                    bg-gray-200
                                @else
                                    bg-white
                                @endif"
                            >
                        <span>円</span>
                    </span>
                </p>

                <p class="flex items-center gap-2">
                    <input type="radio" wire:model.live="disposal_plan" value="2" class="scale-125 ml-2">
                    <span class="flex items-center rounded gap-2 flex-1 min-w-0 px-2"
                            style="background-color: {{ ItemConstants::DISPOSAL_COLOR_CODES[ItemConstants::DISPOSAL_PLAN_SALE] }}"
                    >
                        <span class="font-bold whitespace-nowrap">売却</span>
                        <span class="text-sm whitespace-nowrap">売却価格</span>
                        <input type="number" wire:model="sale_price"
                            @if($disposal_plan != ItemConstants::DISPOSAL_PLAN_SALE) disabled @endif
                            class="border border-gray-300 rounded my-2 px-2 py-1 flex-1 min-w-0 text-end
                                @if($disposal_plan != ItemConstants::DISPOSAL_PLAN_SALE)
                                    bg-gray-200
                                @else
                                    bg-white
                                @endif"
                            >
                        <span>円</span>
                    </span>
                </p>

                <p class="flex items-center gap-2">
                    <input type="radio" wire:model.live="disposal_plan" value="3" class="scale-125 ml-2">
                    <span class="flex items-center rounded gap-2 flex-1 min-w-0 px-2"
                            style="background-color: {{ ItemConstants::DISPOSAL_COLOR_CODES[ItemConstants::DISPOSAL_PLAN_TRANSFER] }}"
                    >
                        <span class="font-bold whitespace-nowrap">譲渡</span>
                        <span class="text-sm whitespace-nowrap">譲渡先</span>
                        <input type="text" wire:model="transfer_target"
                            @if($disposal_plan != ItemConstants::DISPOSAL_PLAN_TRANSFER) disabled @endif
                            class="border border-gray-300 rounded my-2 px-2 py-1 flex-1 min-w-0
                                @if($disposal_plan != ItemConstants::DISPOSAL_PLAN_TRANSFER)
                                    bg-gray-200
                                @else
                                    bg-white
                                @endif"
                        >
                    </span>
                </p>

                <p class="flex items-center gap-2">
                    <input type="radio" wire:model.live="disposal_plan" value="4" class="scale-125 ml-2">
                    <span class="flex items-center rounded gap-2 flex-1 min-w-0 px-2"
                            style="background-color: {{ ItemConstants::DISPOSAL_COLOR_CODES[ItemConstants::DISPOSAL_PLAN_STORAGE] }}"
                    >
                        <span class="font-bold whitespace-nowrap">保管</span>
                        <span class="text-sm whitespace-nowrap">保管期限</span>
                        <input type="date" wire:model="storage_deadline"
                            @if($disposal_plan != ItemConstants::DISPOSAL_PLAN_STORAGE) disabled @endif
                            class="border border-gray-300 rounded my-2 px-2 py-1 flex-1 min-w-0
                                @if($disposal_plan != ItemConstants::DISPOSAL_PLAN_STORAGE)
                                    bg-gray-200
                                @else
                                    bg-white
                                @endif"
                        >
                        <span class="whitespace-nowrap">まで</span>
                    </span>
                </p>

                <p class="flex items-center gap-2">
                    <input type="radio" wire:model.live="disposal_plan" value="5" class="scale-125 ml-2">
                    <span class="font-bold rounded flex-1 my-1 px-2 py-2"
                            style="background-color: {{ ItemConstants::DISPOSAL_COLOR_CODES[ItemConstants::DISPOSAL_PLAN_NONE] }}"
                    >
                        未指定
                    </span>
                </p>
                
                <x-error-message field="disposal_plan" />
                <x-error-message field="discard_cost" />
                <x-error-message field="sale_price" />
                <x-error-message field="transfer_target" />
                <x-error-message field="storage_deadline" />
            </div>
        </div>

        {{-- 右カラム：ステータス・AI・備考 --}}
        <div class="flex flex-col gap-4 md:w-1/3">

            <div class="flex flex-col gap-1">
                <p class="text-sm font-bold bg-[#E2EBB7] px-2 py-1">
                    処分ステータス
                    <x-required-label />
                </p>
                <select wire:model="disposal_status" class="border border-gray-300 rounded px-2 py-1">
                    @foreach(ItemConstants::DISPOSAL_STATUSES as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
                <x-error-message field="disposal_status" />
            </div>

            <div class="flex flex-col gap-1">
                <p class="text-sm font-bold bg-[#E2EBB7] px-2 py-1">
                    AIによる廃棄の提案（参考情報）
                </p>
                <p>{{ $ai_text ?? '未取得' }}</p>
                <flux:button 
                    type="button"
                    icon="arrow-down-tray"
                    wire:click="getAiText"
                    size="sm" 
                    class="self-end px-4 py-2 !bg-[#C4C598] rounded cursor-pointer"
                    disabled
                >
                    取得
                </flux:button>
            </div>

            <div class="flex flex-col gap-1">
                <p class="text-sm font-bold bg-[#E2EBB7] px-2 py-1">
                    備考
                </p>
                <textarea wire:model="remark" class="border border-gray-300 rounded px-2 py-1 h-32"></textarea>
                <x-error-message field="remark" />
            </div>

        </div>
    </div>

    {{-- 登録・戻るボタン --}}
    <div class="flex justify-end gap-4 mt-8">
        <flux:button 
            type="submit"
            icon="plus-circle" 
            wire:click="register" 
            wire:confirm="登録してよろしいですか？" 
            class="px-6 py-2 !bg-[#C4C598] rounded cursor-pointer"
        >
            登録
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