<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BarangExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return Barang::with('admin')->get()->map(function ($item) {

            $fotoUrl = $item->fotoBarang
                ? asset('storage/' . $item->fotoBarang)
                : '-';

            return [
                'id'            => $item->id,
                'namaBarang'    => $item->namaBarang,
                'tahun'         => $item->tahun,
                'jenisBarang'   => $item->jenisBarang,
                'nomorNUP'      => $item->nomorNUP,
                'kondisi'       => $item->kondisi,
                'lokasi'        => $item->lokasi,
                'latitude'      => $item->latitude,
                'longitude'     => $item->longitude,
                'namaAdmin'     => $item->admin ? $item->admin->nama : '-',
                'fotoBarang'    => $fotoUrl,
                'keterangan'    => $item->keterangan,
                'created_at'    => $item->created_at,
                'updated_at'    => $item->updated_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Barang',
            'Tahun',
            'Jenis Barang',
            'Nomor NUP',
            'Kondisi',
            'Lokasi',
            'Latitude',
            'Longitude',
            'Nama Admin',
            'Foto Barang (URL)',
            'Keterangan',
            'Created At',
            'Updated At'
        ];
    }

    public function styles(Worksheet $sheet)
{
    // Header bold, tengah, dan background hijau
    $sheet->getStyle('A1:N1')->applyFromArray([
        'font' => ['bold' => true],
        'alignment' => [
            'horizontal' => 'center',
            'vertical'   => 'center'
        ],
        'fill' => [
            'fillType' => 'solid',
            'color' => ['rgb' => 'C6EFCE'] // warna hijau soft
        ],
        'borders' => [
            'allBorders' => ['borderStyle' => 'thin']
        ]
    ]);

    // Border semua cell data
    $lastRow = $sheet->getHighestRow();

    $sheet->getStyle("A1:N{$lastRow}")->applyFromArray([
        'borders' => [
            'allBorders' => ['borderStyle' => 'thin']
        ]
    ]);

    return [];
}

}
