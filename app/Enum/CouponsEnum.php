<?php

namespace App\Enum;


enum CouponTypeEnum:string{
    case PERCENT = 'percent',
    case FIXED = 'fixed'
};