<?php

namespace Tests\Unit;

use Anacreation\Accounting\Models\Account;
use Anacreation\Accounting\Test\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function account_show_current_balance() {

        $amount = 500;
        $account = factory(Account::class)->create([
            'balance'    => $amount,
            'owner_type' => "DummyObject",
            'owner_id'   => 1,
        ]);

        $this->assertDatabaseHas('accounts', [
            'id'      => $account->id,
            'balance' => $amount * 100
        ]);
        $this->assertEquals($amount, $account->getBalance());
    }
}
