<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MapelTemplateExportMapel implements FromCollection, WithHeadings
{
    protected $siswa;
    protected $mapel;

    public function __construct($siswa, $mapel)
    {
        $this->siswa = $siswa;
        $this->mapel = $mapel;
    }

    public function collection()
    {
        $data = [];

        foreach ($this->siswa as $siswa) {
            foreach ($this->mapel as $mapel) {
                $data[] = [
                    'NISN' => $siswa->NISN,
                    'nama_siswa' => $siswa->nama_siswa,
                    'nama_mapel' => $mapel->nama_mapel,
                    'kode_mapel' => $mapel->kode,
                    'tugas_1' => '',
                    'tugas_2' => '',
                    'uts' => '',
                    'tugas_3' => '',
                    'tugas_4' => '',
                    'uas' => '',
                    'kompetensi' => '',
                ];
            }
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'NISN',
            'nama_siswa',
            'nama_mapel',
            'kode_mapel',
            'tugas_1',
            'tugas_2',
            'uts',
            'tugas_3',
            'tugas_4',
            'uas',
            'kompetensi'
        ];
    }
}
