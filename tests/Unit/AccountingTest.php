<?php

namespace Tests\Unit;

use App\Account;
use App\Accounting;
use App\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function transfer_money_from_a_account_to_another_account() {
        $accounting = new Accounting();
        $account1OriginBalance = 500;
        $account2OriginBalance = 100;
        $account1 = factory(Account::class)->create([
            'balance' => $account1OriginBalance
        ]);
        $account2 = factory(Account::class)->create([
            'balance' => $account2OriginBalance
        ]);

        $amount = 100;

        $transaction = $accounting->transfer($account1, $account2, $amount);


        $this->assertEquals($account1OriginBalance - $amount,
            $account1->getBalance());
        $this->assertEquals($account2OriginBalance + $amount,
            $account2->getBalance());
        $this->assertInstanceOf(Transaction::class, $transaction);

        $this->assertDatabaseHas('transactions', [
            'from_account_id' => $account1->id,
            'to_account_id'   => $account2->id,
            'amount'          => $amount * 100
        ]);

        $this->assertEquals($amount, $transaction->amount);
    }
}