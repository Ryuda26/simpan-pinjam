@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<h4 class="mb-3">Dashboard</h4>
<div class="row g-3">
    <div class="col-6 col-lg-3">
        <div class="card shadow-sm"><div class="card-body">
            <div class="text-muted small">Jumlah Anggota</div>
            <div class="fs-3 fw-bold">{{ $jumlahAnggota }}</div>
        </div></div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card shadow-sm"><div class="card-body">
            <div class="text-muted small">Jumlah Transaksi</div>
            <div class="fs-3 fw-bold">{{ $jumlahTransaksi }}</div>
        </div></div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card shadow-sm"><div class="card-body">
            <div class="text-muted small">Total Simpanan</div>
            <div class="fs-5 fw-bold text-success">Rp {{ number_format($totalSimpanan, 0, ',', '.') }}</div>
        </div></div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card shadow-sm"><div class="card-body">
            <div class="text-muted small">Total Pinjaman</div>
            <div class="fs-5 fw-bold text-danger">Rp {{ number_format($totalPinjaman, 0, ',', '.') }}</div>
        </div></div>
    </div>
</div>
<div class="mt-4">
    <a href="{{ route('laporan.lengkap') }}" target="_blank" class="btn btn-danger">Cetak PDF Laporan Lengkap</a>
</div>
@endsection
