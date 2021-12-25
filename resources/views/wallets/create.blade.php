@extends('layouts.app')

@section('title', 'Create Wallet')

@section('heading', 'Create Wallet')

@section('content')
    <form method="post" action="/wallets">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control w-50" id="name" name="name"
                   value="{{ old('name') }}" required>
        </div>
        @error('name')
        <p class="text-danger">{{ $message }}</p>
        @enderror
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </form>
    <div class="mb-3">
        <a href="/wallets" class="btn btn-primary" role="button">Back</a>
    </div>
@endsection
