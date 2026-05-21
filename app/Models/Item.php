<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'item_name',
        'model_no',
        'condition',
        'condition_detail',
        'disposal_plan',
        'discard_cost',
        'sale_price',
        'transfer_target',
        'storage_deadline',
        'disposal_status',
        'remark',
        'ai_text',
        'image_path',
    ];

    protected $casts = [
        'storage_deadline' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
