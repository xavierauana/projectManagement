<?php

namespace Tests\Unit;

use App\Account;
use App\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function has_from_account() {

        $account = factory(Account::class)->create();

        $transaction = factory(Transaction::class)->create([
            'from_account_id' => $account->id
        ]);

        $this->assertTrue($transaction->from->is($account));
    }

    /**
     * @test
     */
    public function has_to_account() {

        $account = factory(Account::class)->create();

        $transaction = factory(Transaction::class)->create([
            'to_account_id' => $account->id
        ]);

        $this->assertTrue($transaction->to->is($account));
    }

}
