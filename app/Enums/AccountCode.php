<?php

namespace App\Enums;

enum AccountCode: int {
    case CASH = 1;
    case ACCOUNTS_RECEIVABLE = 2;
    case INVENTORY = 3;
    case VAT_PAYABLE = 4;
    case SALES_REVENUE = 5;
    case DISCOUNT_EXPENSE = 6;
    case COST_OF_GOODS_SOLD = 7;
}