@extends('layouts.app')
@section('title', 'Edit Anggota')
@section('content')
<div class="row justify-content-center"><div class="col-lg-6">
    <div class="card shadow-sm"><div class="card-body">
        <h4 class="mb-3">Edit Anggota</h4>
        <form method="POST" action="{{ route('members.update', $member) }}">
            @csrf @method('PUT')
            @include('members._form')
        </form>
    </div></div>
</div></div>
@endsection
