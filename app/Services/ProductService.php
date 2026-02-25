<?php
namespace App\Services;

use App\Models\Product;
use App\Models\Stock;
use App\Enums\AccountCode;
use App\Models\Account;
use App\Enums\ActiveStatus;
use App\Models\JournalVoucher;
use App\Models\JournalEntry;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductService
{
    public function getAll()
    {
        return Product::where('active_status', ActiveStatus::ACTIVE)->with('stock')->paginate(10);
    }
    public function store(array $data)
    {
        DB::transaction(function () use ($data) {

            $product = Product::create([
                'name' => $data['name'],
                'sku' => $data['sku'] ?? null,
                'purchase_price' => $data['purchase_price'],
                'sell_price' => $data['sell_price'],
            ]);

            Stock::create([
                'product_id' => $product->id,
                'quantity' => $data['opening_stock'],
            ]);

            // Calculate inventory value
            $amount = $data['purchase_price'] * $data['opening_stock'];

            if ($amount <= 0) {
                return;
            }

            $inventory = Account::where('code', AccountCode::INVENTORY)->first();
            $capital   = Account::where('code', AccountCode::COST_OF_GOODS_SOLD)->first();

            $voucher = JournalVoucher::create([
                'reference' => 'OPEN-PROD-'.$product->id,
                'voucher_date' => Carbon::today(),
                'description' => 'Opening stock for '.$product->name,
                'created_by' => auth()->guard('web')->id(),
            ]);

            // Debit Inventory
            JournalEntry::create([
                'journal_voucher_id' => $voucher->id,
                'account_id' => $inventory->id,
                'debit' => $amount,
                'credit' => 0,
            ]);

            // Credit Owner Capital
            JournalEntry::create([
                'journal_voucher_id' => $voucher->id,
                'account_id' => $capital->id,
                'debit' => 0,
                'credit' => $amount,
            ]);

        });
    }
}