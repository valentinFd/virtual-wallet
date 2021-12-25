@extends('layouts.app')

@section('title', 'Create Transaction')

@section('heading', 'Create Transaction')

@section('content')
    <form method="post" action="/wallets/{{ $walletId }}/transactions">
        @csrf
        <div class="mb-3">
            <label for="to" class="form-label">To (wallet id)</label>
            <input type="number" class="form-control w-50" id="walletId" name="walletId"
                   value="{{ old('walletId') }}" required>
        </div>
        @error('walletId')
        <p class="text-danger">{{ $message }}</p>
        @enderror
        <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" class="form-control w-50" id="amount" name="amount"
                   value="{{ old('amount') }}" required>
        </div>
        @error('amount')
        <p class="text-danger">{{ $message }}</p>
        @enderror
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </form>
    <div class="mb-3">
        <a href="/wallets/{{ $walletId }}/transactions" class="btn btn-primary" role="button">Back</a>
    </div>
@endsection
