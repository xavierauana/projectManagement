<?php
/**
 * Author: Xavier Au
 * Date: 2019-04-01
 * Time: 01:36
 */

namespace Anacreation\Accounting\Models;


use Illuminate\Support\Facades\DB;

class Accounting
{

    public function transfer(
        Account $fromAccount, Account $toAccount, float $amount
    ): Transaction {
        DB::beginTransaction();

        try {

            $transaction = new Transaction;
            $transaction->from_account_id = $fromAccount->id;
            $transaction->to_account_id = $toAccount->id;
            $transaction->amount = $amount;
            $transaction->save();

            $fromAccount->balance = $fromAccount->getBalance() - $amount;
            $fromAccount->save();
            $toAccount->balance = $toAccount->getBalance() + $amount;
            $toAccount->save();


            DB::commit();

            return $transaction;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}