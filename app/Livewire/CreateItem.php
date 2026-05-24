<?php

namespace App\Livewire;

use App\Constants\ItemConstants;
use App\Livewire\Concerns\HandlesDisposalPlan;
use App\Livewire\Concerns\ItemFormProperties;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Ramsey\Uuid\Type\Integer;

class CreateItem extends Component
{
    use WithFileUploads;
    use ItemFormProperties;
    use HandlesDisposalPlan;

    public function mount()
    {
        $this->initializeCategories();
    }

    public function deleteImage ()
    {
        $this->image = null;
    }

    public function register()
    {
        //AI提案の取得中は登録不可
        if ($this->isLoadingAi) {
            $this->addError('ai_loading', 'AI提案の取得中は登録できません。取得完了後に登録してください。');
            return;
        }

        $this->validate();

        //家財件数チェック
        $itemCount = Item::where('user_id', Auth::id())->count();
        if ($itemCount >= ItemConstants::LIMIT_ITEM_COUNT) {
            //エラーメッセージをセッションに追加
            $this->addError('item_limit', '家財の最大登録件数に達しているため登録できません');
            return;
        }

        // 画像が選択されている場合は保存
        if ($this->image) {
            $imagePath = $this->image->store('images');
        } else {
            $imagePath = null;
        }

        Item::create([
            'user_id'           => Auth::id(),
            'category_id'       => $this->category_id,
            'item_name'         => $this->item_name,
            'model_no'          => $this->model_no,
            'condition'         => $this->condition,
            'condition_detail'  => $this->condition_detail,
            'disposal_plan'     => $this->disposal_plan,
            'discard_cost'      => $this->discard_cost,
            'sale_price'        => $this->sale_price,
            'transfer_target'   => $this->transfer_target,
            'storage_deadline'  => $this->storage_deadline,
            'disposal_status'   => $this->disposal_status,
            'remark'            => $this->remark,
            'ai_text'           => $this->ai_text,
            'image_path'        => $imagePath,
        ]);

        return $this->redirect('/search-items?autoSearch=true', navigate: true);
    }

    public function render()
    {
        return view('livewire.create-item');
    }
}
