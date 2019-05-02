<?php

namespace Tests\Unit;

use Anacreation\Accounting\Models\Account;
use Anacreation\Accounting\Models\Accounting;
use Anacreation\Accounting\Models\Transaction;
use Anacreation\Accounting\Test\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
            'balance'    => $account1OriginBalance,
            'owner_type' => "DummyObject",
            'owner_id'   => 1,
        ]);
        $account2 = factory(Account::class)->create([
            'balance'    => $account2OriginBalance,
            'owner_type' => "DummyObject",
            'owner_id'   => 2,
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