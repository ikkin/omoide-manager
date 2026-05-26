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

    const LIMIT_ITEM_COUNT = 50; //1ユーザーあたりの家財登録件数上限値

    //状態
    const CONDITION_GOOD    = 1; //良好
    const CONDITION_NORMAL  = 2; //使用感あり
    const CONDITION_BAD     = 3; //破損・故障あり

    const CONDITIONS = [
        self::CONDITION_GOOD    => '良好',
        self::CONDITION_NORMAL  => '使用感あり',
        self::CONDITION_BAD     => '破損・故障あり',
    ];

    //処分方針
    const DISPOSAL_PLAN_DISCARD     = 1; //廃棄
    const DISPOSAL_PLAN_SALE        = 2; //売却
    const DISPOSAL_PLAN_TRANSFER    = 3; //譲渡
    const DISPOSAL_PLAN_STORAGE     = 4; //保管
    const DISPOSAL_PLAN_NONE        = 5; //未指定

    const DISPOSAL_PLANS = [
        self::DISPOSAL_PLAN_DISCARD     => '廃棄',
        self::DISPOSAL_PLAN_SALE        => '売却',
        self::DISPOSAL_PLAN_TRANSFER    => '譲渡',
        self::DISPOSAL_PLAN_STORAGE     => '保管',
        self::DISPOSAL_PLAN_NONE        => '未指定',
    ];

    //処分ステータス
    const DISPOSAL_STATUS_YET       = 1; //未処分
    const DISPOSAL_STATUS_PLANNED   = 2; //処分予定
    const DISPOSAL_STATUS_COMPLETED = 3; //処分済み

    const DISPOSAL_STATUSES = [
        self::DISPOSAL_STATUS_YET       => '未処分',
        self::DISPOSAL_STATUS_PLANNED   => '処分予定',
        self::DISPOSAL_STATUS_COMPLETED => '処分済み',
    ];

    //処分方針カラー
    const DISPOSAL_COLOR_CODES = [
        self::DISPOSAL_PLAN_DISCARD     => '#E8CCC5', //廃棄
        self::DISPOSAL_PLAN_SALE        => '#BDCED3', //売却
        self::DISPOSAL_PLAN_TRANSFER    => '#CFD4AE', //譲渡
        self::DISPOSAL_PLAN_STORAGE     => '#F6E7C6', //保管
        self::DISPOSAL_PLAN_NONE        => '#BBB9B2', //未指定
    ];
}
