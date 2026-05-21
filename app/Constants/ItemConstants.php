<?php

namespace App\Constants;

class ItemConstants
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    //状態
    const CONDITIONS = [
        1 => '良好',
        2 => '使用感あり',
        3 => '破損・故障あり',
    ];

    //処分方針
    const DISPOSAL_PLANS = [
        1 => '廃棄',
        2 => '売却',
        3 => '譲渡',
        4 => '保管',
        5 => '未指定',
    ];

    //処分ステータス
    const DISPOSAL_STATUSES = [
        1 => '未処分',
        2 => '処分予定',
        3 => '処分済み',
    ];

    //処分方針カラー
    const DISPOSAL_COLOR_CODES = [
        1 => '#F4CCCC', //廃棄
        2 => '#C9DAF8', //売却
        3 => '#D9EAD3', //譲渡
        4 => '#FFF2CC', //保管
        5 => '#CFCFCF', //未指定
    ];
}
