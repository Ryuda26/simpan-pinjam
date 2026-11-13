@extends('layouts.app')
@section('title', 'Edit Transaksi')
@section('content')
<div class="row justify-content-center"><div class="col-lg-6">
    <div class="card shadow-sm"><div class="card-body">
        <h4 class="mb-3">Edit Transaksi</h4>
        <form method="POST" action="{{ route('transactions.update', $transaction) }}">
            @csrf @method('PUT')
            @include('transactions._form')
        </form>
    </div></div>
</div></div>
@endsection
