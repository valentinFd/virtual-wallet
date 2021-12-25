@extends('layouts.app')

@section('title', 'Edit Wallet')

@section('heading', 'Edit Wallet')

@section('content')
    <form method="post" action="/wallets/{{ $wallet->id }}">
        @csrf
        @method('patch')
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control w-50" id="name" name="name"
                   value="{{ old('name') == "" ? $wallet->name : old('name') }}">
        </div>
        @error('name')
        <p class="text-danger">{{ $message }}</p>
        @enderror
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
    <form action="/wallets/{{ $wallet->id }}" method="post">
        @csrf
        @method('delete')
        <div class="mb-3">
            <button type="submit" class="btn btn-danger" onclick="return confirm('Delete wallet?')">Delete</button>
        </div>
    </form>
    <div class="mb-3">
        <a href="/wallets/{{ $wallet->id }}" class="btn btn-primary" role="button">Back</a>
    </div>
@endsection
