@extends('layouts.app')

@section('title', 'Wallets')

@section('heading', 'Wallets')

@section('welcome')
    <div class="col">
        Hello, {{ auth()->user()->username }}!
    </div>
    <div class="col">
        <form method="post" action="/logout">
            @csrf
            <button type="submit" class="btn btn-primary">Log Out</button>
        </form>
    </div>
@endsection

@section('content')
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
        <tr>
            <th scope="col" class="col-md-4">Name</th>
        </tr>
        </thead>
        <tbody>
        @foreach($wallets as $wallet)
            <tr>
                <td>
                    <a
                        class="link-dark"
                        style="text-decoration: none"
                        href="/wallets/{{ $wallet->id }}"
                        onmouseover="this.style.textDecoration='underline'"
                        onmouseout="this.style.textDecoration='none'"
                    >
                        {{ $wallet->name }}
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="mb-3">
        <a href="/wallets/create" class="btn btn-primary" role="button">Create</a>
    </div>
@endsection
