<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Enums\AccountType;
use App\Enums\AccountCode;
use App\Models\Account;

class AccountSeeder extends Seeder
{
    public function run()
    {
        $accounts = [

            ['name' => 'Cash', 'type' => AccountType::ASSET, 'code' => AccountCode::CASH],
            ['name' => 'Accounts Receivable', 'type' => AccountType::ASSET, 'code' => AccountCode::ACCOUNTS_RECEIVABLE],
            ['name' => 'Inventory', 'type' => AccountType::ASSET, 'code' => AccountCode::INVENTORY],

            ['name' => 'VAT Payable', 'type' => AccountType::LIABILITY, 'code' => AccountCode::VAT_PAYABLE],

            ['name' => 'Sales Revenue', 'type' => AccountType::INCOME, 'code' => AccountCode::SALES_REVENUE],

            ['name' => 'Discount Expense', 'type' => AccountType::EXPENSE, 'code' => AccountCode::DISCOUNT_EXPENSE],
            ['name' => 'Cost of Goods Sold', 'type' => AccountType::EXPENSE, 'code' => AccountCode::COST_OF_GOODS_SOLD],

        ];

        foreach ($accounts as $account) {
            Account::updateOrCreate(
                ['code' => $account['code']],
                $account
            );
        }
    }
}