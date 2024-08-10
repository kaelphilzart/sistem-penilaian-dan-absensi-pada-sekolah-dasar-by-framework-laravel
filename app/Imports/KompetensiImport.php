<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Raport;

class KompetensiImport implements ToCollection
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
                $data['kode_mapel']       = !empty($row[1]) ? $row[1] : '';
                $data['semester']       =  $this->semester;
                $data['kompetensi']       = !empty($row[2]) ? $row[2] : '';

                Raport::create($data);
            }

            $indexKe++;
        }
    }
}
