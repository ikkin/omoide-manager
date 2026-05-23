<?php

namespace App\Livewire\Concerns;

use App\Constants\ItemConstants;
use App\Models\Category;
use Illuminate\Support\Collection;
use Livewire\Attributes\Validate;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

trait ItemFormProperties 
{
    #[Validate('nullable')]
    #[Validate('image', message:'画像ファイルを選択してください')]
    #[Validate('max:5120', message:'5MB以下の画像ファイルを選択してください')]
    public ?TemporaryUploadedFile $image = null;

    #[Validate('required', message:'名称は必須です')]
    #[Validate('max:30', message:'30文字以内で入力してください')]
    public string $item_name ="";

    #[Validate('required', message:'カテゴリは必須です')]
    #[Validate('exists:categories,id', message:'カテゴリが不正です')]
    public ?int $category_id = null;

    #[Validate('nullable')]
    #[Validate('max:30', message:'30文字以内で入力してください')]
    public ?string $model_no = null;

    #[Validate('required', message:'状態は必須です')]
    #[Validate('integer', message:'状態が不正です')]
    #[Validate('in:'
        .ItemConstants::CONDITION_GOOD . ','
        .ItemConstants::CONDITION_NORMAL . ','
        .ItemConstants::CONDITION_BAD
        , message:'状態が不正です'
        )
    ]
    public int $condition = ItemConstants::CONDITION_GOOD;

    #[Validate('nullable')]
    #[Validate('max:30', message:'30文字以内で入力してください')]
    public ?string $condition_detail = null;

    #[Validate('required', message:'処分方針は必須です')]
    #[Validate('integer', message:'処分方針が不正です')]
    #[Validate('in:'
        .ItemConstants::DISPOSAL_PLAN_DISCARD . ','
        .ItemConstants::DISPOSAL_PLAN_SALE . ','
        .ItemConstants::DISPOSAL_PLAN_TRANSFER . ','
        .ItemConstants::DISPOSAL_PLAN_STORAGE . ','
        .ItemConstants::DISPOSAL_PLAN_NONE
        , message:'処分方針が不正です'
        )
    ]
    public int $disposal_plan = ItemConstants::DISPOSAL_PLAN_NONE;

    #[Validate('nullable')]
    #[Validate('integer', message:'正しい金額を入力してください')]
    #[Validate('min:0', message:'正しい金額を入力してください')]
    public ?int $discard_cost = null;

    #[Validate('nullable')]
    #[Validate('integer', message:'正しい金額を入力してください')]
    #[Validate('min:0', message:'正しい金額を入力してください')]
    public ?int $sale_price = null;

    #[Validate('nullable')]
    #[Validate('max:20', message:'20文字以内で入力してください')]
    public ?string $transfer_target = null;

    #[Validate('nullable')]
    #[Validate('date', message:'正しい日付を入力してください')]
    public ?string $storage_deadline = null;

    #[Validate('required', message:'処分ステータスは必須です')]
    #[Validate('integer', message:'処分ステータスが不正です')]
    #[Validate('in:'
        .ItemConstants::DISPOSAL_STATUS_YET . ','
        .ItemConstants::DISPOSAL_STATUS_PLANNED . ','
        .ItemConstants::DISPOSAL_STATUS_COMPLETED
        , message:'処分ステータスが不正です'
        )
    ]
    public int $disposal_status = ItemConstants::DISPOSAL_STATUS_YET;

    public ?array $ai_text = null;

    #[Validate('nullable')]
    #[Validate('max:120', message:'120文字以内で入力してください')]
    public ?string $remark = null;
}