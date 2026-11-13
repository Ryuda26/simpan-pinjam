<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    private function rules(?Member $member = null): array
    {
        return [
            'nomor_anggota' => ['required', 'string', 'max:20',
                Rule::unique('members', 'nomor_anggota')->ignore($member?->id)],
            'nama'    => ['required', 'string', 'max:100'],
            'alamat'  => ['required', 'string'],
            'telepon' => ['required', 'regex:/^[0-9+\-\s]{8,20}$/'],
        ];
    }

    private array $messages = [
        'nomor_anggota.unique' => 'Nomor anggota sudah dipakai.',
        'telepon.regex'        => 'Telepon hanya boleh angka (8-20 karakter).',
    ];

    // READ (daftar)
    public function index(Request $request)
    {
        $members = Member::with('user')
            ->when($request->q, fn ($q, $s) => $q->where('nama', 'like', "%$s%")
                ->orWhere('nomor_anggota', 'like', "%$s%"))
            ->latest()->paginate(10)->withQueryString();

        return view('members.index', compact('members'));
    }

    // CREATE (form)
    public function create()
    {
        return view('members.create');
    }

    // CREATE (simpan)
    public function store(Request $request)
    {
        $data = $request->validate($this->rules(), $this->messages);
        $data['user_id'] = $request->user()->id; // relasi ke tabel users

        Member::create($data);

        return redirect()->route('members.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    // READ (detail)
    public function show(Member $member)
    {
        $member->load('user', 'transactions');
        return view('members.show', compact('member'));
    }

    // UPDATE (form)
    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    // UPDATE (simpan)
    public function update(Request $request, Member $member)
    {
        $member->update($request->validate($this->rules($member), $this->messages));

        return redirect()->route('members.index')->with('success', 'Data anggota berhasil diubah.');
    }

    // DELETE
    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('members.index')->with('success', 'Anggota berhasil dihapus.');
    }
}
