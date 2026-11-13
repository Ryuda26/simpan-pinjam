<?php

namespace App\Pdf;

use FPDF;

/**
 * Turunan FPDF dengan kop (header) dan nomor halaman (footer).
 */
class ReportPdf extends FPDF
{
    public function Header(): void
    {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 7, 'KOPERASI SIMPAN PINJAM', 0, 1, 'C');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, 'Universitas Pamulang - Program Studi Sistem Informasi', 0, 1, 'C');
        $this->Ln(2);
        $this->Line(10, $this->GetY(), $this->GetPageWidth() - 10, $this->GetY());
        $this->Ln(5);
    }

    public function Footer(): void
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo() . ' / {nb}', 0, 0, 'C');
    }

    /** Judul + tanggal cetak */
    public function title(string $judul): void
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 7, $judul, 0, 1, 'C');
        $this->SetFont('Arial', '', 9);
        $this->Cell(0, 5, 'Tanggal cetak: ' . now()->format('d-m-Y H:i'), 0, 1, 'C');
        $this->Ln(4);
    }

    /** Baris header tabel */
    public function tableHeader(array $kolom, array $lebar): void
    {
        $this->SetFont('Arial', 'B', 9);
        $this->SetFillColor(220, 220, 220);
        foreach ($kolom as $i => $nama) {
            $this->Cell($lebar[$i], 8, $nama, 1, 0, 'C', true);
        }
        $this->Ln();
        $this->SetFont('Arial', '', 9);
    }

    /** Potong teks supaya tidak keluar dari sel */
    public function fit(string $teks, int $max): string
    {
        $teks = iconv('UTF-8', 'windows-1252//TRANSLIT//IGNORE', $teks) ?: $teks;
        return strlen($teks) > $max ? substr($teks, 0, $max - 2) . '..' : $teks;
    }
}
