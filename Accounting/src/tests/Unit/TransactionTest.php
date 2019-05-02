<?php

namespace Tests\Unit;

use Anacreation\Accounting\Models\Account;
use Anacreation\Accounting\Models\Transaction;
use Anacreation\Accounting\Test\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function has_from_account() {

        $account = factory(Account::class)->create([
            'owner_type' => "DummyObject",
            'owner_id'   => 1,
        ]);

        $transaction = factory(Transaction::class)->create([
            'from_account_id' => $account->id
        ]);

        $this->assertTrue($transaction->from->is($account));
    }

    /**
     * @test
     */
    public function has_to_account() {

        $account = factory(Account::class)->create([
            'owner_type' => "DummyObject",
            'owner_id'   => 1,
        ]);

        $transaction = factory(Transaction::class)->create([
            'to_account_id' => $account->id
        ]);

        $this->assertTrue($transaction->to->is($account));
    }
}
