<?php

namespace App\Enums;

enum TransactionType: int
{
    case payment     = 0;
    case refund      = 1;
    case withdrawal  = 2;
    case refill      = 3;
}
