<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class EditItem extends Component
{
    use WithFileUploads;

    public Item $item;

    public ?TemporaryUploadedFile $image = null;

    public Collection $categories;

    #[Validate("required", message:"名称は必須です")]
    public string $item_name ="";

    #[Validate("required", message:"カテゴリは必須です")]
    public ?int $category_id = null;

    public ?string $model_no = null;
    public int $condition = 1;
    public ?string $condition_detail = null;
    public int $disposal_plan = 5;
    public ?int $discard_cost = null;
    public ?int $sale_price = null;
    public ?string $transfer_target = null;
    public ?string $storage_deadline = null;
    public int $disposal_status = 1;
    
    public ?array $ai_text = null;
    public ?string $remark = null;
    public ?string $image_path = null;

    public function mount(Item $item)
    {
        if ($item->user_id !== Auth::id()) {
            abort(404);
        }

        $this->item = $item;
        $this->categories = Category::all();

        //プロパティにitemの値をセット
        $this->item_name = $item->item_name;
        $this->category_id = $item->category_id;
        $this->model_no = $item->model_no;
        $this->condition = $item->condition;
        $this->condition_detail = $item->condition_detail;
        $this->disposal_plan = $item->disposal_plan;
        $this->discard_cost = $item->discard_cost;
        $this->sale_price = $item->sale_price;
        $this->transfer_target = $item->transfer_target;
        $this->storage_deadline = $item->storage_deadline?->format('Y-m-d');
        $this->disposal_status = $item->disposal_status;
        $this->ai_text = $item->ai_text;
        $this->remark = $item->remark;
        $this->image_path = $item->image_path;
    }

    public function deleteImage()
    {
        $this->image = null;
        $this->image_path = null;
        $this->item->image_path = null;
    }

    public function updatedDisposalPlan()
    {
        if ($this->disposal_plan != 1) {
            $this->discard_cost = null;
        }
        if ($this->disposal_plan != 2) {
            $this->sale_price = null;
        }
        if ($this->disposal_plan != 3) {
            $this->transfer_target = null;
        }
        if ($this->disposal_plan != 4) {
            $this->storage_deadline = null;
        }
    }

    public function update()
    {
        //画像が新しく選択された場合は保存
        if ($this->image) {
            $imagePath = $this->image->store('images');
        } else {
            $imagePath = $this->image_path;
        }

        $this->item->update([
            'item_name'        => $this->item_name,
            'category_id'      => $this->category_id,
            'model_no'         => $this->model_no,
            'condition'        => $this->condition,
            'condition_detail' => $this->condition_detail,
            'disposal_plan'    => $this->disposal_plan,
            'discard_cost'     => $this->discard_cost,
            'sale_price'       => $this->sale_price,
            'transfer_target'  => $this->transfer_target,
            'storage_deadline' => $this->storage_deadline,
            'disposal_status'  => $this->disposal_status,
            'ai_text'          => $this->ai_text,
            'remark'           => $this->remark,
            'image_path'       => $imagePath,
        ]);

        return $this->redirect(route('item', $this->item->id), navigate: true);
    }

    public function render()
    {
        return view('livewire.edit-item');
    }
}
