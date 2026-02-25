<?php

namespace App\Enums;

enum AccountType: int {
    case ASSET = 1;
    case LIABILITY = 2;
    case INCOME = 3;
    case EXPENSE = 4;
}