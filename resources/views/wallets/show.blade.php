@extends('layouts.app')

@section('title', 'Show Wallet')

@section('heading', 'Show Wallet')

@section('content')
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
        <tr>
            <th scope="col" class="col-md-2">Id</th>
            <th scope="col" class="col-md-2">Name</th>
            <th scope="col" class="col-md-2">Created At</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="col-md-2">{{ $wallet->id }}</td>
            <td class="col-md-2">{{ $wallet->name }}</td>
            <td class="col-md-2">{{ $wallet->created_at }}</td>
        </tr>
        </tbody>
    </table>
    <div class="mb-3">
        <a href="/wallets/{{ $wallet->id }}/edit" class="btn btn-primary" role="button">Edit</a>
    </div>
    <div class="mb-3">
        <a href="/wallets/{{ $wallet->id }}/transactions" class="btn btn-primary" role="button">Transactions</a>
    </div>
    <div class="mb-3">
        <a href="/wallets" class="btn btn-primary" role="button">Back</a>
    </div>
@endsection
