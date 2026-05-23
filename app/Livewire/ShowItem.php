<?php

namespace App\Livewire;

use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowItem extends Component
{
    public Item $item;

    public function mount(Item $item)
    {
        //他ユーザーのアイテムへのアクセスを防ぐチェック
        if ($item->user_id !== Auth::id())
        {
            abort(404);
        }

        $this->item = $item->load('category');
    }

    public function delete($id)
    {
        $deleteItem = Item::findOrFail($id);

        if($deleteItem->user_id !== Auth::id()){
            abort(403);
        }

        $deleteItem->delete();

        return $this->redirect('/search-items?autoSearch=true', navigate: true);
    }

    public function render()
    {
        return view('livewire.show-item');
    }
}
