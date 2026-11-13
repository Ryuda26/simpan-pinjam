@extends('layouts.app')
@section('title', 'Detail Anggota')
@section('content')
<div class="card shadow-sm mb-4"><div class="card-body">
    <h4>{{ $member->nama }}</h4>
    <dl class="row mb-0">
        <dt class="col-sm-3">No. Anggota</dt><dd class="col-sm-9">{{ $member->nomor_anggota }}</dd>
        <dt class="col-sm-3">Alamat</dt><dd class="col-sm-9">{{ $member->alamat }}</dd>
        <dt class="col-sm-3">Telepon</dt><dd class="col-sm-9">{{ $member->telepon }}</dd>
        <dt class="col-sm-3">Dicatat oleh</dt><dd class="col-sm-9">{{ $member->user->name ?? '-' }}</dd>
    </dl>
</div></div>

<h5>Riwayat Transaksi</h5>
<div class="card shadow-sm"><div class="table-responsive">
    <table class="table table-striped mb-0">
        <thead class="table-light"><tr><th>Tanggal</th><th>Jenis</th><th class="text-end">Jumlah</th><th>Keterangan</th></tr></thead>
        <tbody>
        @forelse ($member->transactions as $t)
            <tr>
                <td>{{ $t->tanggal->format('d-m-Y') }}</td>
                <td><span class="badge {{ $t->jenis === 'simpanan' ? 'bg-success' : 'bg-danger' }}">{{ ucfirst($t->jenis) }}</span></td>
                <td class="text-end">Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                <td>{{ $t->keterangan ?? '-' }}</td>
            </tr>
        @empty
            <tr><td colspan="4" class="text-center text-muted py-3">Belum ada transaksi.</td></tr>
        @endforelse
        </tbody>
    </table>
</div></div>
<a href="{{ route('members.index') }}" class="btn btn-secondary mt-3">Kembali</a>
@endsection
