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
                    class="px-4 py-2 !bg-[#C4C598] rounded cursor-pointer hover:bg-gray-500!" 
                    onclick="document.getElementById('fileInput').click()"
                >
                    画像変更
                </flux:button>
                <flux:button 
                    type="button"
                    icon="trash"
                    class="px-4 py-2 !bg-[#C4C598] rounded cursor-pointer hover:bg-gray-500!" 
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
                <x-form-label label='名称' required />
                <input type="text" wire:model="item_name" class="border border-gray-300 rounded px-2 py-1">
                <x-error-message field="item_name" />
            </div>

            <div class="flex flex-col gap-1">
                <x-form-label label='カテゴリ' required />
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
                <x-form-label label='型番' />
                <input type="text" wire:model="model_no" class="border border-gray-300 rounded px-2 py-1">
                <x-error-message field="model_no" />
            </div>

            <div class="flex flex-col gap-1">
                <x-form-label label='状態' required />
                <select wire:model="condition" class="border border-gray-300 rounded px-2 py-1">
                    @foreach(ItemConstants::CONDITIONS as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
                <x-error-message field="condition" />
            </div>

            <div class="flex flex-col gap-1">
                <x-form-label label='状態詳細' />
                <input type="text" wire:model="condition_detail" class="border border-gray-300 rounded px-2 py-1">
                <x-error-message field="condition_detail" />
            </div>

            {{-- 処分方針 --}}
            <div class="flex flex-col gap-2">
                <x-form-label label='処分方針' required />

                <p class="flex items-center gap-2">
                    <input type="radio" wire:model.live="disposal_plan" value="1" class="scale-125 ml-2">
                    <span class="flex items-center rounded gap-2 flex-1 min-w-0 px-2"
                            style="background-color: {{ ItemConstants::DISPOSAL_COLOR_CODES[ItemConstants::DISPOSAL_PLAN_DISCARD] }}"
                    >
                        <span class="font-semibold whitespace-nowrap">廃棄</span>
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
                        <span class="font-semibold whitespace-nowrap">売却</span>
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
                        <span class="font-semibold whitespace-nowrap">譲渡</span>
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
                        <span class="font-semibold whitespace-nowrap">保管</span>
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
                    <span class="font-semibold rounded flex-1 my-1 px-2 py-2"
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
                <x-form-label label='処分ステータス' required />
                <select wire:model="disposal_status" class="border border-gray-300 rounded px-2 py-1">
                    @foreach(ItemConstants::DISPOSAL_STATUSES as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
                <x-error-message field="disposal_status" />
            </div>

            <div class="flex flex-col gap-1">
                <x-form-label label='AIによる廃棄の提案（参考情報）' />
                {{-- 状態に応じて表示を切り替え --}}
                @if($isLoadingAi)
                    <p class="pl-2 text-gray-500">取得中...</p>
                @elseif($ai_text === null)
                    <p class="pl-2">未取得</p>
                @else
                    {{-- モーダルを開くリンク --}}
                    <flux:modal.trigger name="ai-suggestion">
                        <span class="pl-2 text-blue-500 cursor-pointer underline">表示する</span>
                    </flux:modal.trigger>
                @endif

                <x-error-message field='ai_loading' />
                <x-error-message field='ai_error' />

                <flux:button 
                    type="button"
                    icon="arrow-down-tray"
                    wire:click="getAiText"
                    wire:confirm="取得が完了するまで家財情報の登録ができませんがよろしいですか？"
                    size="sm" 
                    class="self-end px-4 py-2 !bg-[#C4C598] rounded cursor-pointer hover:bg-gray-500!"
                    wire:loading.attr="disabled"
                    wire:target="getAiText"
                >
                    <span wire:loading.remove wire:target="getAiText">取得</span>
                    <span wire:loading wire:target="getAiText">取得中...</span>
                </flux:button>
            </div>

            {{-- AIの提案内容モーダル --}}
            <flux:modal name="ai-suggestion" class="md:w-[600px]">
                <div class="space-y-4">
                    <flux:heading size="lg">AIによる廃棄の提案</flux:heading>
                    <p class="text-xs text-gray-500">※あくまで参考情報です。実際の廃棄方法は各自治体の規則に従ってください。</p>

                    @if($ai_text)
                        @foreach($ai_text as $suggestion)
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
                <textarea wire:model="remark" class="border border-gray-300 rounded px-2 py-1 h-32"></textarea>
                <x-error-message field="remark" />
            </div>

        </div>
    </div>

    {{-- 登録・戻るボタン --}}
    <div class="flex flex-col mt-2">
        @error('item_limit')
            <p class="text-red-500 text-sm text-end">{{ $message }}</p>
        @enderror
        <div class="flex justify-end gap-4 mt-2">
            <flux:button 
                type="submit"
                icon="plus-circle" 
                wire:click="register" 
                wire:confirm="登録してよろしいですか？" 
                class="px-6 py-2 !bg-[#C4C598] rounded cursor-pointer hover:bg-gray-500!"
                wire:loading.attr="disabled"
                wire:target="getAiText"
            >
                登録
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
    </div>
    

</main>