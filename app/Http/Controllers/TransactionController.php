<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Wallet $wallet)
    {
        $outgoingTransactions = $wallet->outgoingTransactions;
        $outgoingTransactionsSum = 0;
        foreach ($outgoingTransactions as $outgoingTransaction)
        {
            $outgoingTransactionsSum += $outgoingTransaction->amount;
        }

        $incomingTransactions = $wallet->incomingTransactions;
        $incomingTransactionsSum = 0;
        foreach ($incomingTransactions as $incomingTransaction)
        {
            $incomingTransactionsSum += $incomingTransaction->amount;
        }
        return view('transactions.index', [
            'outgoingTransactions' => $wallet->outgoingTransactions,
            'incomingTransactions' => $wallet->incomingTransactions,
            'outgoingTransactionsSum' => $outgoingTransactionsSum,
            'incomingTransactionsSum' => $incomingTransactionsSum,
            'walletId' => $wallet->id
        ]);
    }

    public function create(Wallet $wallet)
    {
        return view('transactions.create', ['walletId' => $wallet->id]);
    }

    public function store(Request $request, Wallet $wallet)
    {
        $request->validate([
            'walletId' => ['required', 'numeric', 'min:0', 'exists:wallets,id'],
            'amount' => ['required', 'numeric', 'min:0.01']
        ]);
        $transaction = Transaction::make();
        $transaction->from = $wallet->id;
        $transaction->to = Wallet::find($request->walletId)->id;
        $transaction->amount = $request->amount;
        $transaction->save();
        return redirect('/wallets/' . $wallet->id . '/transactions');
    }

    public function update(Request $request, Wallet $wallet, Transaction $transaction)
    {
        $transaction->fraudulent = $transaction->fraudulent === 0 ? 1 : 0;
        $transaction->save();
        return redirect('/wallets/' . $wallet->id . '/transactions');
    }

    public function destroy(Wallet $wallet, Transaction $transaction)
    {
        $transaction->delete();
        return redirect('/wallets/' . $wallet->id . '/transactions');
    }
}
