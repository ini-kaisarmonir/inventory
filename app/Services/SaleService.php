<?php

namespace App\Services;

use App\Models\Sale;
use App\Enums\AccountCode;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Customer;
use App\Models\Account;
use App\Models\JournalVoucher;
use App\Models\JournalEntry;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class SaleService
{
    public function store($data)
    {
        DB::transaction(function () use ($data) {

            $customer = Customer::findOrFail($data['customer_id']);

            $subtotal = 0;
            $items = [];

            // --------- calculate subtotal & check stock ----------
            foreach ($data['products'] as $productId => $row) {

                if (!isset($row['selected'])) continue;
                if ($row['qty'] <= 0) continue;

                $product = Product::with('stock')->findOrFail($productId);

                if ($product->stock->quantity < $row['qty']) {
                    throw new Exception("Insufficient stock for ".$product->name);
                }

                $lineTotal = $row['qty'] * $row['price'];

                $subtotal += $lineTotal;

                $items[] = [
                    'product' => $product,
                    'qty' => $row['qty'],
                    'price' => $row['price'],
                    'cost' => $product->purchase_price,
                    'line_total' => $lineTotal,
                ];
            }

            // -------- financial calculations --------
            $discount = $data['discount'] ?? 0;
            $afterDiscount = $subtotal - $discount;

            $vatPercent = $data['vat_percent'] ?? 0;
            $vatAmount = ($afterDiscount * $vatPercent) / 100;

            $total = $afterDiscount + $vatAmount;
            $paid  = $data['paid'] ?? 0;
            $due   = $total - $paid;

            // -------- create sale --------
            $sale = Sale::create([
                'invoice_no' => 'INV-'.time(),
                'customer_id' => $customer->id,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'vat_percent' => $vatPercent,
                'vat_amount' => $vatAmount,
                'total' => $total,
                'paid' => $paid,
                'due' => max($due,0),
                'sale_date' => Carbon::today(),
                'created_by' => auth()->guard('web')->id(),
            ]);

            // -------- items & stock reduction --------
            $totalCost = 0;

            foreach ($items as $item) {

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product']->id,
                    'quantity' => $item['qty'],
                    'unit_price' => $item['price'],
                    'unit_cost' => $item['cost'],
                    'line_total' => $item['line_total'],
                ]);

                $item['product']->stock->decrement('quantity', $item['qty']);

                $totalCost += $item['cost'] * $item['qty'];
            }

            // -------- accounts --------
            $ar   = Account::where('code',AccountCode::ACCOUNTS_RECEIVABLE)->first(); // receivable
            $cash = Account::where('code',AccountCode::CASH)->first();
            $sales= Account::where('code',AccountCode::SALES_REVENUE)->first();
            $vat  = Account::where('code',AccountCode::VAT_PAYABLE)->first();
            $cogs = Account::where('code',AccountCode::COST_OF_GOODS_SOLD)->first();
            $inventory = Account::where('code',AccountCode::INVENTORY)->first();

            // -------- SALE VOUCHER --------
            $voucher = JournalVoucher::create([
                'reference' => $sale->invoice_no,
                'voucher_date' => Carbon::today(),
                'description' => 'Sale Invoice',
                'created_by' => auth()->guard('web')->id(),
            ]);

            // debit Accounts Receivable
            JournalEntry::create([
                'journal_voucher_id'=>$voucher->id,
                'account_id'=>$ar->id,
                'customer_id'=>$customer->id,
                'debit'=>$total,
                'credit'=>0,
            ]);

            // credit Sales
            JournalEntry::create([
                'journal_voucher_id'=>$voucher->id,
                'account_id'=>$sales->id,
                'debit'=>0,
                'credit'=>$afterDiscount,
            ]);

            // credit VAT
            if($vatAmount>0){
                JournalEntry::create([
                    'journal_voucher_id'=>$voucher->id,
                    'account_id'=>$vat->id,
                    'debit'=>0,
                    'credit'=>$vatAmount,
                ]);
            }

            // -------- PAYMENT VOUCHER --------
            if($paid>0){

                $pv = JournalVoucher::create([
                    'reference'=>$sale->invoice_no.'-PAY',
                    'voucher_date'=>Carbon::today(),
                    'description'=>'Customer payment',
                    'created_by'=>auth()->guard('web')->id(),
                ]);

                // cash debit
                JournalEntry::create([
                    'journal_voucher_id'=>$pv->id,
                    'account_id'=>$cash->id,
                    'debit'=>$paid,
                    'credit'=>0,
                ]);

                // reduce receivable
                JournalEntry::create([
                    'journal_voucher_id'=>$pv->id,
                    'account_id'=>$ar->id,
                    'customer_id'=>$customer->id,
                    'debit'=>0,
                    'credit'=>$paid,
                ]);
            }

            // -------- COGS VOUCHER --------
            $cv = JournalVoucher::create([
                'reference'=>$sale->invoice_no.'-COGS',
                'voucher_date'=>Carbon::today(),
                'description'=>'Cost of goods sold',
                'created_by'=>auth()->guard('web')->id(),
            ]);

            // debit COGS
            JournalEntry::create([
                'journal_voucher_id'=>$cv->id,
                'account_id'=>$cogs->id,
                'debit'=>$totalCost,
                'credit'=>0,
            ]);

            // credit inventory
            JournalEntry::create([
                'journal_voucher_id'=>$cv->id,
                'account_id'=>$inventory->id,
                'debit'=>0,
                'credit'=>$totalCost,
            ]);

            // -------- update customer balance --------
            $customer->balance += max($due,0);
            $customer->balance -= min($paid,$total);
            $customer->save();

        });
    }
}