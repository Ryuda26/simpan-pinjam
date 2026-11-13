<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private function rules(): array
    {
        return [
            'member_id'  => ['required', 'exists:members,id'],
            'jenis'      => ['required', 'in:simpanan,pinjaman'],
            'jumlah'     => ['required', 'numeric', 'min:1', 'max:9999999999999'],
            'tanggal'    => ['required', 'date'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ];
    }

    // READ (daftar transaksi simpan pinjam + filter)
    public function index(Request $request)
    {
        $base = Transaction::query()
            ->when($request->jenis, fn ($q, $j) => $q->where('jenis', $j))
            ->when($request->member_id, fn ($q, $m) => $q->where('member_id', $m));

        $transactions = (clone $base)->with('member')->latest('tanggal')->latest('id')
            ->paginate(10)->withQueryString();

        $totalSimpanan = (clone $base)->where('jenis', 'simpanan')->sum('jumlah');
        $totalPinjaman = (clone $base)->where('jenis', 'pinjaman')->sum('jumlah');
        $members = Member::orderBy('nama')->get();

        return view('transactions.index', compact('transactions', 'totalSimpanan', 'totalPinjaman', 'members'));
    }

    public function create()
    {
        $members = Member::orderBy('nama')->get();
        return view('transactions.create', compact('members'));
    }

    public function store(Request $request)
    {
        Transaction::create($request->validate($this->rules()));

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function edit(Transaction $transaction)
    {
        $members = Member::orderBy('nama')->get();
        return view('transactions.edit', compact('transaction', 'members'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $transaction->update($request->validate($this->rules()));

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diubah.');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
