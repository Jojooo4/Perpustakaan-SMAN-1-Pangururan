<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings, WithMapping};

class FineExport implements FromCollection, WithHeadings, WithMapping
{
    protected $denda;

    public function __construct($denda)
    {
        $this->denda = $denda;
    }

    public function collection()
    {
        return $this->denda;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Peminjam',
            'Judul Buku',
            'Nomor Inventaris',
            'Tanggal Pinjam',
            'Tanggal Jatuh Tempo',
            'Tanggal Kembali',
            'Hari Terlambat',
            'Denda (Rp)',
            'Status'
        ];
    }

    public function map($peminjaman): array
    {
        $jatuhTempo = \Carbon\Carbon::parse($peminjaman->tanggal_jatuh_tempo);
        $kembali = $peminjaman->tanggal_kembali 
            ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)
            : now();
        
        $hariTerlambat = max(0, $kembali->diffInDays($jatuhTempo, false) * -1);
        
        return [
            $peminjaman->id_peminjaman,
            $peminjaman->user->nama ?? '-',
            $peminjaman->asetBuku->buku->judul ?? '-',
            $peminjaman->asetBuku->nomor_inventaris ?? '-',
            $peminjaman->tanggal_pinjam->format('d-m-Y'),
            $jatuhTempo->format('d-m-Y'),
            $peminjaman->tanggal_kembali ? $kembali->format('d-m-Y') : '-',
            $hariTerlambat,
            number_format($peminjaman->denda, 0, ',', '.'),
            $peminjaman->denda_lunas ? 'Lunas' : 'Belum Lunas'
        ];
    }
}
