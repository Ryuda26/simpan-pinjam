<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Transaction;
use App\Pdf\ReportPdf;

class ReportController extends Controller
{
    private function rupiah($angka): string
    {
        return 'Rp ' . number_format((float) $angka, 0, ',', '.');
    }

    private function newPdf(): ReportPdf
    {
        $pdf = new ReportPdf('P', 'mm', 'A4');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        return $pdf;
    }

    private function send(ReportPdf $pdf, string $nama)
    {
        return response($pdf->Output('S'), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $nama . '"',
        ]);
    }

    /** Tabel data anggota + jumlah data */
    private function tabelAnggota(ReportPdf $pdf): void
    {
        $data  = Member::with('user')->orderBy('nomor_anggota')->get();
        $lebar = [10, 28, 45, 55, 28, 24];
        $pdf->tableHeader(['No', 'No. Anggota', 'Nama', 'Alamat', 'Telepon', 'Petugas'], $lebar);

        foreach ($data as $i => $m) {
            $pdf->Cell($lebar[0], 7, $i + 1, 1, 0, 'C');
            $pdf->Cell($lebar[1], 7, $pdf->fit($m->nomor_anggota, 16), 1);
            $pdf->Cell($lebar[2], 7, $pdf->fit($m->nama, 26), 1);
            $pdf->Cell($lebar[3], 7, $pdf->fit($m->alamat, 32), 1);
            $pdf->Cell($lebar[4], 7, $pdf->fit($m->telepon, 16), 1);
            $pdf->Cell($lebar[5], 7, $pdf->fit($m->user->name ?? '-', 14), 1);
            $pdf->Ln();
        }

        $pdf->Ln(2);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(0, 6, 'Jumlah data anggota: ' . $data->count(), 0, 1);
    }

    /** Tabel transaksi + jumlah data + total */
    private function tabelTransaksi(ReportPdf $pdf): void
    {
        $data  = Transaction::with('member')->orderBy('tanggal')->orderBy('id')->get();
        $lebar = [10, 24, 50, 24, 36, 46];
        $pdf->tableHeader(['No', 'Tanggal', 'Anggota', 'Jenis', 'Jumlah', 'Keterangan'], $lebar);

        foreach ($data as $i => $t) {
            $pdf->Cell($lebar[0], 7, $i + 1, 1, 0, 'C');
            $pdf->Cell($lebar[1], 7, $t->tanggal->format('d-m-Y'), 1, 0, 'C');
            $pdf->Cell($lebar[2], 7, $pdf->fit(($t->member->nama ?? '-'), 28), 1);
            $pdf->Cell($lebar[3], 7, ucfirst($t->jenis), 1, 0, 'C');
            $pdf->Cell($lebar[4], 7, $this->rupiah($t->jumlah), 1, 0, 'R');
            $pdf->Cell($lebar[5], 7, $pdf->fit($t->keterangan ?? '-', 26), 1);
            $pdf->Ln();
        }

        $pdf->Ln(2);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(0, 6, 'Jumlah data transaksi: ' . $data->count(), 0, 1);
        $pdf->Cell(0, 6, 'Total simpanan: ' . $this->rupiah($data->where('jenis', 'simpanan')->sum('jumlah')), 0, 1);
        $pdf->Cell(0, 6, 'Total pinjaman: ' . $this->rupiah($data->where('jenis', 'pinjaman')->sum('jumlah')), 0, 1);
    }

    public function anggota()
    {
        $pdf = $this->newPdf();
        $pdf->title('LAPORAN DATA ANGGOTA');
        $this->tabelAnggota($pdf);
        return $this->send($pdf, 'laporan-anggota.pdf');
    }

    public function transaksi()
    {
        $pdf = $this->newPdf();
        $pdf->title('LAPORAN TRANSAKSI SIMPAN PINJAM');
        $this->tabelTransaksi($pdf);
        return $this->send($pdf, 'laporan-transaksi.pdf');
    }

    public function lengkap()
    {
        $pdf = $this->newPdf();
        $pdf->title('LAPORAN DATA ANGGOTA DAN TRANSAKSI SIMPAN PINJAM');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 7, 'A. Data Anggota', 0, 1);
        $this->tabelAnggota($pdf);

        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 7, 'B. Transaksi Simpan Pinjam', 0, 1);
        $this->tabelTransaksi($pdf);

        return $this->send($pdf, 'laporan-lengkap.pdf');
    }
}
