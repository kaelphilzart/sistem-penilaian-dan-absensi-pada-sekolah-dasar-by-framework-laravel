<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Nilai;

class NilaiSiswaImport implements ToCollection
{
    /**
    * @param Collection $collection
    */


    protected $id_kelas;
    protected $semester;

    public function __construct($id_kelas, $semester)
    {
        $this->id_kelas = $id_kelas;
        $this->semester = $semester;
    }

    public function collection(Collection $collection)
    {
        //
        $indexKe = 1;


        foreach($collection as $row){
            if($indexKe > 1){

                $data['nisn']      = !empty($row[0]) ? $row[0] : '';
                $data['id_kelas']       =  $this->id_kelas;
                $data['kode_mapel']       = !empty($row[3]) ? $row[3] : '';
                $data['semester']       =  $this->semester;
                $data['tugas_1']       = !empty($row[4]) ? $row[4] : '';
                $data['tugas_2']       = !empty($row[5]) ? $row[5] : '';
                $data['uts']       = !empty($row[6]) ? $row[6] : '';
                $data['tugas_3']       = !empty($row[7]) ? $row[7] : '';
                $data['tugas_4']       = !empty($row[8]) ? $row[8] : '';
                $data['uas']       = !empty($row[9]) ? $row[9] : '';
                $data['kompetensi']       = !empty($row[10]) ? $row[10] : '';

                Nilai::create($data);
            }

            $indexKe++;
        }
    }
}
