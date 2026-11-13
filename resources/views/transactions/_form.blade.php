<div class="mb-3">
    <label class="form-label">Anggota</label>
    <select name="member_id" class="form-select @error('member_id') is-invalid @enderror">
        <option value="">-- Pilih anggota --</option>
        @foreach ($members as $m)
            <option value="{{ $m->id }}" @selected(old('member_id', $transaction->member_id ?? '') == $m->id)>
                {{ $m->nomor_anggota }} - {{ $m->nama }}
            </option>
        @endforeach
    </select>
    @error('member_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label class="form-label">Jenis Transaksi</label>
    <select name="jenis" class="form-select @error('jenis') is-invalid @enderror">
        <option value="">-- Pilih jenis --</option>
        @foreach (['simpanan' => 'Simpanan', 'pinjaman' => 'Pinjaman'] as $val => $label)
            <option value="{{ $val }}" @selected(old('jenis', $transaction->jenis ?? '') === $val)>{{ $label }}</option>
        @endforeach
    </select>
    @error('jenis') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label class="form-label">Jumlah (Rp)</label>
    <input type="number" step="0.01" name="jumlah" value="{{ old('jumlah', isset($transaction) ? (float) $transaction->jumlah : '') }}"
           class="form-control @error('jumlah') is-invalid @enderror">
    @error('jumlah') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label class="form-label">Tanggal</label>
    <input type="date" name="tanggal" value="{{ old('tanggal', isset($transaction) ? $transaction->tanggal->format('Y-m-d') : now()->format('Y-m-d')) }}"
           class="form-control @error('tanggal') is-invalid @enderror">
    @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label class="form-label">Keterangan</label>
    <input type="text" name="keterangan" value="{{ old('keterangan', $transaction->keterangan ?? '') }}"
           class="form-control @error('keterangan') is-invalid @enderror">
    @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<button class="btn btn-success">Simpan</button>
<a href="{{ route('transactions.index') }}" class="btn btn-secondary">Batal</a>
