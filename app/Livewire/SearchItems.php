<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SearchItems extends Component
{
    public string $item_name = '';
    public ?int $category_id = null;
    public array $conditions = [];
    public array $disposal_plans = [];
    public array $disposal_statuses = [];

    public Collection $items;
    public Collection $categories;

    //統計情報用
    public int $itemCount = 0;
    public int $totalDiscardCost = 0;
    public int $totalSalePrice = 0;

    public function mount()
    {
        $this->items = collect();
        $this->categories = Category::all();

        if (request()->query('autoSearch')) 
        {
            $this->search();
        }
    }

    //検索ボタン
    public function search()
    {
        $query = Auth::user()->items()->with('category');
        
        //名称
        if(!empty($this->item_name)){
            $query->where('item_name', 'LIKE', '%' . $this->item_name . '%');
        }

        //カテゴリ
        if(!empty($this->category_id)){
            $query->where('category_id', $this->category_id);
        }

        //状態
        if(!empty($this->conditions)){
            $query->whereIn('condition', $this->conditions);
        }

        //処分方針
        if(!empty($this->disposal_plans)){
            $query->whereIn('disposal_plan', $this->disposal_plans);
        }

        //処分ステータス
        if(!empty($this->disposal_statuses)){
            $query->whereIn('disposal_status', $this->disposal_statuses);
        }

        $this->items = $query->get();

        // 統計情報を計算
        $this->itemCount = $this->items->count();
        $this->totalDiscardCost = $this->items->sum(fn($item) => $item->discard_cost ?? 0);
        $this->totalSalePrice = $this->items->sum(fn($item) => $item->sale_price ?? 0);
    }

    public function render()
    {
        return view('livewire.search-items');
    }
}
