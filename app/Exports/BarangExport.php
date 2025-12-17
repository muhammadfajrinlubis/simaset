<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class BarangExport implements FromArray, WithHeadings, ShouldAutoSize, WithDrawings, WithStyles
{
    protected $barangs;

    public function __construct()
    {
        $this->barangs = Barang::all();
    }

    // ======================== DATA ========================
    public function array(): array
    {
        $rows = [];

        foreach ($this->barangs as $item) {
            $rows[] = [
                $item->id,
                $item->namaBarang,
                $item->tahun,
                $item->jenisBarang,
                $item->nomorNUP,
                $item->kondisi,
                $item->lokasi,
                $item->latitude,
                $item->longitude,
                $item->keterangan,
                'Foto 1',
                'Foto 2',
                'Foto 3',
                'Foto 4'
            ];
        }

        return $rows;
    }

    // ======================== HEADER ========================
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
            'Keterangan',
            'Foto 1',
            'Foto 2',
            'Foto 3',
            'Foto 4'
        ];
    }

    // ======================== GAMBAR ========================
    public function drawings()
    {
        $drawings = [];

        foreach ($this->barangs as $index => $item) {

            $fotoArray = json_decode($item->fotoBarang, true);

            if (!$fotoArray || count($fotoArray) == 0) continue;

            // Loop 4 foto
            foreach ($fotoArray as $i => $fotoPath) {

                if (!$fotoPath) continue;

                $fullPath = storage_path("app/public/" . $fotoPath);

                if (!file_exists($fullPath)) continue;

                $drawing = new Drawing();
                $drawing->setName("Foto Barang " . ($i + 1));
                $drawing->setDescription("Foto Barang");
                $drawing->setPath($fullPath);
                $drawing->setHeight(80);

                // Kolom: K, L, M, N = ASCII 75+
                $colLetter = chr(75 + $i);

                $drawing->setCoordinates($colLetter . ($index + 2));

                $drawings[] = $drawing;
            }
        }

        return $drawings;
    }

    // ======================== STYLE TABEL ========================
    public function styles(Worksheet $sheet)
    {
        // Header A1:N1 warna hijau + bold + center
        $sheet->getStyle('A1:N1')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center'
            ],
            'fill' => [
                'fillType' => 'solid',
                'color' => ['rgb' => 'C6EFCE'] // Hijau soft
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => 'thin']
            ]
        ]);

        // Border semua cell
        $lastRow = $sheet->getHighestRow();

        $sheet->getStyle("A1:N{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => ['borderStyle' => 'thin']
            ]
        ]);

        return [];
    }
}
