@extends('layouts.app')
@section('title', 'Tambah Transaksi')
@section('content')
<div class="row justify-content-center"><div class="col-lg-6">
    <div class="card shadow-sm"><div class="card-body">
        <h4 class="mb-3">Tambah Transaksi</h4>
        <form method="POST" action="{{ route('transactions.store') }}">
            @csrf
            @include('transactions._form')
        </form>
    </div></div>
</div></div>
@endsection
