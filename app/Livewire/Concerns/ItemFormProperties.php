<?php

namespace App\Livewire\Concerns;

use App\Constants\ItemConstants;
use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Validate;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Psy\Readline\Hoa\Console;

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

    public Collection $categories;

    //AIによる情報取得中のフラグ
    public bool $isLoadingAi = false;

    public function initializeCategories(): void
    {
        $this->categories = Category::all();
    }

    public function getAiText(): void
    {
        //AIに必要な必須入力項目の確認
        if(empty($this->item_name)) {
            $this->addError('ai_error', '名称が未入力のため取得できません');
            return;
        } elseif($this->category_id === null) {
            $this->addError('ai_error', 'カテゴリが未選択のため取得できません');
            return;
        }

        //取得中にする
        $this->isLoadingAi = true;

        //カテゴリ名を取得
        $categoryName = $this->categories
            ->firstWhere('id', $this->category_id)
            ?->category_name ?? '不明';

        //状態名を取得
        $conditionName = ItemConstants::CONDITIONS[$this->condition] ?? '不明';

        //プロンプトを作成
        $prompt = <<<EOT
あなたは日本における家財廃棄のエキスパートです。
以下の家財の廃棄方法を最大5つ提案してください。

家財情報：
- 名称：{$this->item_name}
- カテゴリ：{$categoryName}
- 型番：{$this->model_no}（参考程度で必ずしもあてにならない）
- 状態：{$conditionName}
- 状態詳細：{$this->condition_detail}

以下のJSON形式で返してください。廃棄方法が提案できない場合は方法名を「不明」にして残りの項目を空文字にしてください。
日本国内での廃棄方法のみ提案してください。

[
    {
        "method": "方法名",
        "overview": "概要",
        "cost": "費用感",
        "effort": "手間（低／中／高）",
        "notes": "注意点"
    }
]

JSONのみ返してください。説明文もコードブロック（```json や ```）も不要です。
EOT;

        try {
            $response = Http::withHeaders([
                'x-api-key' => config('services.anthropic.key'),
                'anthropic-version' => '2023-06-01',
                'content-type' => 'application/json',
            ])
            ->timeout(60)
            ->post('https://api.anthropic.com/v1/messages', [
                'model' => 'claude-sonnet-4-5',
                'max_tokens' => 1024,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $prompt,
                    ]
                ],
            ]);

            $content = $response->json('content.0.text');
            $content = preg_replace('/```json\s*|\s*```/', '', $content);
            $content = trim($content);
            $this->ai_text = json_decode($content, true);

        } catch (\Exception $e) {
            $this->ai_text = null;
        } finally {
            $this->isLoadingAi = false;
        }
    }
}