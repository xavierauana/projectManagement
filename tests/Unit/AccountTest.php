<?php

namespace Tests\Unit;

use App\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function account_show_current_balance() {

        $amount = 500;
        $account = factory(Account::class)->create([
            'balance' => $amount
        ]);

        $this->assertDatabaseHas('accounts', [
            'id'=>$account->id,
            'balance'=>$amount*100
        ]);

        $this->assertEquals($amount, $account->getBalance());

    }
}
