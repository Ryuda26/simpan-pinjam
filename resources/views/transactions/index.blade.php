@extends('layouts.app')
@section('title', 'Transaksi Simpan Pinjam')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <h4 class="mb-0">Transaksi Simpan Pinjam</h4>
    <div>
        <a href="{{ route('laporan.transaksi') }}" target="_blank" class="btn btn-danger">Cetak PDF</a>
        <a href="{{ route('transactions.create') }}" class="btn btn-success">+ Tambah Transaksi</a>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-sm-6"><div class="card shadow-sm"><div class="card-body">
        <div class="text-muted small">Total Simpanan</div>
        <div class="fs-5 fw-bold text-success">Rp {{ number_format($totalSimpanan, 0, ',', '.') }}</div>
    </div></div></div>
    <div class="col-sm-6"><div class="card shadow-sm"><div class="card-body">
        <div class="text-muted small">Total Pinjaman</div>
        <div class="fs-5 fw-bold text-danger">Rp {{ number_format($totalPinjaman, 0, ',', '.') }}</div>
    </div></div></div>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-sm-4">
        <select name="jenis" class="form-select">
            <option value="">Semua jenis</option>
            <option value="simpanan" @selected(request('jenis') === 'simpanan')>Simpanan</option>
            <option value="pinjaman" @selected(request('jenis') === 'pinjaman')>Pinjaman</option>
        </select>
    </div>
    <div class="col-sm-4">
        <select name="member_id" class="form-select">
            <option value="">Semua anggota</option>
            @foreach ($members as $m)
                <option value="{{ $m->id }}" @selected(request('member_id') == $m->id)>{{ $m->nama }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-auto"><button class="btn btn-outline-secondary">Filter</button></div>
</form>

<div class="card shadow-sm"><div class="table-responsive">
    <table class="table table-striped table-hover mb-0 align-middle">
        <thead class="table-light">
            <tr><th>No</th><th>Tanggal</th><th>Anggota</th><th>Jenis</th><th class="text-end">Jumlah</th><th>Keterangan</th><th class="text-end">Aksi</th></tr>
        </thead>
        <tbody>
        @forelse ($transactions as $t)
            <tr>
                <td>{{ $transactions->firstItem() + $loop->index }}</td>
                <td>{{ $t->tanggal->format('d-m-Y') }}</td>
                <td>{{ $t->member->nama ?? '-' }}</td>
                <td><span class="badge {{ $t->jenis === 'simpanan' ? 'bg-success' : 'bg-danger' }}">{{ ucfirst($t->jenis) }}</span></td>
                <td class="text-end">Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                <td>{{ $t->keterangan ?? '-' }}</td>
                <td class="text-end text-nowrap">
                    <a href="{{ route('transactions.edit', $t) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('transactions.destroy', $t) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Hapus transaksi ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center text-muted py-4">Belum ada transaksi.</td></tr>
        @endforelse
        </tbody>
    </table>
</div></div>
<div class="mt-3">{{ $transactions->links() }}</div>
@endsection
