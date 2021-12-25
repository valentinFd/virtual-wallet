@extends('layouts.app')

@section('title', 'Transactions')

@section('heading', 'Transactions')

@section('content')
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
        <tr>
            <th scope="col" class="col-md-4">To</th>
            <th scope="col" class="col-md-4">Amount</th>
            <th scope="col" class="col-md-4">Fraudulent</th>
            <th scope="col" class="col-md-4">At</th>
            <th scope="col" class="col-md-4"></th>
        </thead>
        <tbody>
        @foreach($outgoingTransactions as $outgoingTransaction)
            <tr>
                <td style="font-weight: {{ $outgoingTransaction->fraudulent === 1 ? 'bold' : 'normal' }}">
                    {{ $outgoingTransaction->receiver->name }} (id: {{ $outgoingTransaction->receiver->id }})
                </td>
                <td>
                    EUR {{ number_format($outgoingTransaction->amount, 2) }}
                </td>
                <td>
                    <form method="post"
                          action="/wallets/{{ $walletId }}/transactions/{{ $outgoingTransaction->id }}">
                        @csrf
                        @method('patch')
                        <input type="checkbox"
                               onchange="this.form.submit()" {{ $outgoingTransaction->fraudulent === 0 ?: 'checked' }}>
                    </form>
                </td>
                <td>
                    {{ $outgoingTransaction->created_at }}
                </td>
                <td>
                    <form action="/wallets/{{ $walletId }}/transactions/{{ $outgoingTransaction->id }}" method="post">
                        @csrf
                        @method('delete')
                        <div class="mb-3">
                            <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Delete Transaction?')">Delete
                            </button>
                        </div>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    Total sum of outgoing transactions: EUR {{ number_format($outgoingTransactionsSum, 2) }}
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
        <tr>
            <th scope="col" class="col-md-4">From</th>
            <th scope="col" class="col-md-4">Amount</th>
            <th scope="col" class="col-md-4">At</th>
        </thead>
        <tbody>
        @foreach($incomingTransactions as $incomingTransaction)
            <tr>
                <td>
                    {{ $incomingTransaction->sender->name }} (id: {{ $incomingTransaction->sender->id }})
                </td>
                <td>
                    EUR {{ number_format($incomingTransaction->amount, 2) }}
                </td>
                <td>
                    {{ $incomingTransaction->created_at }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    Total sum of incoming transactions: EUR {{ number_format($incomingTransactionsSum, 2) }}
    <div class="mb-3">
        <a href="/wallets/{{ $walletId }}/transactions/create" class="btn btn-primary" role="button">Create</a>
    </div>
    <div class="mb-3">
        <a href="/wallets/{{ $walletId }}" class="btn btn-primary" role="button">Back</a>
    </div>
@endsection
