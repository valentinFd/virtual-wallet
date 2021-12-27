<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WalletControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_a_virtual_wallet()
    {
        $this->actingAs(User::factory()->create());
        $response = $this->post('/wallets', ['name' => 'test']);
        $response->assertStatus(302);
        $this->assertDatabaseHas('wallets', [
            'user_id' => auth()->id(),
            'name' => 'test'
        ]);
    }

    public function test_user_can_view_a_list_of_their_virtual_wallets()
    {
        $this->actingAs(User::factory()->create());
        $response = $this->get('/wallets');
        $response->assertStatus(200);
    }

    public function test_user_can_rename_a_virtual_wallet()
    {
        $wallet = Wallet::factory()->create(['user_id' => User::factory()]);
        $this->actingAs($wallet->user);
        $response = $this->patch('/wallets/' . $wallet->id, ['name' => 'rename']);
        $response->assertStatus(302);
        $this->assertDatabaseHas('wallets', [
            'id' => $wallet->id,
            'name' => 'rename'
        ]);
    }

    public function test_user_can_delete_a_virtual_wallet()
    {
        $wallet = Wallet::factory()->create(['user_id' => User::factory()]);
        $this->actingAs($wallet->user);
        $response = $this->delete('/wallets/' . $wallet->id);
        $response->assertStatus(302);
        $this->assertDeleted($wallet);
    }

    public function test_user_can_add_a_transaction_to_a_virtual_wallet()
    {
        $wallet = Wallet::factory()->create(['user_id' => User::factory()]);
        $wallet2 = Wallet::factory()->create(['user_id' => User::factory()]);
        $this->actingAs($wallet->user);
        $response = $this->post('/wallets/' . $wallet->id . '/transactions', ['walletId' => $wallet2->id, 'amount' => 20]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('transactions', [
            'from' => $wallet->id,
            'to' => $wallet2->id,
            'amount' => 20
        ]);
    }

    public function test_user_can_view_all_the_transactions_in_their_virtual_wallet()
    {
        $wallet = Wallet::factory()->create(['user_id' => User::factory()]);
        $this->actingAs($wallet->user);
        $response = $this->get('/wallets/' . $wallet->id . '/transactions');
        $response->assertStatus(200);
    }

    public function test_user_can_delete_a_transaction()
    {
        $wallet = Wallet::factory()->create(['user_id' => User::factory()]);
        $wallet2 = Wallet::factory()->create(['user_id' => User::factory()]);
        $this->actingAs($wallet->user);
        $transaction = Transaction::factory()->create(['from' => $wallet->id, 'to' => $wallet2->id]);
        $response = $this->delete('/wallets/' . $wallet->id . '/transactions/' . $transaction->id);
        $response->assertStatus(302);
        $this->assertDeleted($transaction);
    }

    public function test_user_can_mark_a_transaction_as_fraudulent()
    {
        $wallet = Wallet::factory()->create(['user_id' => User::factory()]);
        $wallet2 = Wallet::factory()->create(['user_id' => User::factory()]);
        $this->actingAs($wallet->user);
        $transaction = Transaction::factory()->create(['from' => $wallet->id, 'to' => $wallet2->id]);
        $response = $this->patch('/wallets/' . $wallet->id . '/transactions/' . $transaction->id);
        $response->assertStatus(302);
        $this->assertDatabaseHas('transactions', [
            'from' => $wallet->id,
            'to' => $wallet2->id,
            'fraudulent' => 1
        ]);
    }
}
