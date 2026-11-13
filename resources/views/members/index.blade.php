@extends('layouts.app')
@section('title', 'Data Anggota')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <h4 class="mb-0">Data Anggota</h4>
    <div>
        <a href="{{ route('laporan.anggota') }}" target="_blank" class="btn btn-danger">Cetak PDF</a>
        <a href="{{ route('members.create') }}" class="btn btn-success">+ Tambah Anggota</a>
    </div>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-sm-6 col-md-4">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama / nomor anggota">
    </div>
    <div class="col-auto"><button class="btn btn-outline-secondary">Cari</button></div>
</form>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-striped table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th><th>No. Anggota</th><th>Nama</th><th>Alamat</th><th>Telepon</th><th>Petugas</th><th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($members as $m)
                <tr>
                    <td>{{ $members->firstItem() + $loop->index }}</td>
                    <td>{{ $m->nomor_anggota }}</td>
                    <td>{{ $m->nama }}</td>
                    <td>{{ $m->alamat }}</td>
                    <td>{{ $m->telepon }}</td>
                    <td>{{ $m->user->name ?? '-' }}</td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('members.show', $m) }}" class="btn btn-sm btn-info">Detail</a>
                        <a href="{{ route('members.edit', $m) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('members.destroy', $m) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus anggota ini beserta transaksinya?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data anggota.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $members->links() }}</div>
@endsection
