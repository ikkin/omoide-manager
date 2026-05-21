<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function show (string $filename)
    {
        //このファイルがログインユーザーの家財に紐づくか確認する
        $item = Item::where('user_id', Auth::id())
                    ->where('image_path', 'images/'.$filename)
                    ->firstOrFail();

        //ファイルの存在確認
        if (!Storage::exists('images/'.$filename))
        {
            abort(404);
        }

        //ファイルを返す
        return response()->file(Storage::path('images/'.$filename));
    }
}
