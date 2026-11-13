<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'jumlahAnggota'  => Member::count(),
            'jumlahTransaksi' => Transaction::count(),
            'totalSimpanan'  => Transaction::where('jenis', 'simpanan')->sum('jumlah'),
            'totalPinjaman'  => Transaction::where('jenis', 'pinjaman')->sum('jumlah'),
        ]);
    }
}
