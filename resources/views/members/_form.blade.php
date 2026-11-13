<div class="mb-3">
    <label class="form-label">Nomor Anggota</label>
    <input type="text" name="nomor_anggota" value="{{ old('nomor_anggota', $member->nomor_anggota ?? '') }}"
           class="form-control @error('nomor_anggota') is-invalid @enderror">
    @error('nomor_anggota') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label class="form-label">Nama</label>
    <input type="text" name="nama" value="{{ old('nama', $member->nama ?? '') }}"
           class="form-control @error('nama') is-invalid @enderror">
    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label class="form-label">Alamat</label>
    <textarea name="alamat" rows="3" class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $member->alamat ?? '') }}</textarea>
    @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label class="form-label">Telepon</label>
    <input type="text" name="telepon" value="{{ old('telepon', $member->telepon ?? '') }}"
           class="form-control @error('telepon') is-invalid @enderror">
    @error('telepon') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<button class="btn btn-success">Simpan</button>
<a href="{{ route('members.index') }}" class="btn btn-secondary">Batal</a>
