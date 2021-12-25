<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index()
    {
        $wallets = auth()->user()->wallets;
        return view('wallets.index', ['wallets' => $wallets]);
    }

    public function create()
    {
        return view('wallets.create');
    }


    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => ['required', 'min:3', 'max:255']
        ]);
        $wallet = Wallet::make($attributes);
        $wallet->user()->associate(auth()->user());
        $wallet->save();
        return redirect('/wallets');
    }

    public function show(Wallet $wallet)
    {
        return view('wallets.show', ['wallet' => $wallet]);
    }

    public function edit(Wallet $wallet)
    {
        return view('wallets.edit', ['wallet' => $wallet]);
    }

    public function update(Request $request, Wallet $wallet)
    {
        $attributes = $request->validate([
            'name' => ['required', 'min:3', 'max:255']
        ]);
        $wallet->update($attributes);
        return redirect('/wallets/' . $wallet->id);
    }

    public function destroy(Wallet $wallet)
    {
        $wallet->delete();
        return redirect('/wallets');
    }
}
