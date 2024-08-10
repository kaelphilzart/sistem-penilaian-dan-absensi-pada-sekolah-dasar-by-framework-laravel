<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Skrining;

class SkriningImport implements ToCollection
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
                $data['tinggi_badan']       = !empty($row[1]) ? $row[1] : '';
                $data['semester']       =  $this->semester;
                $data['berat_badan']       = !empty($row[2]) ? $row[2] : '';
                $data['pendengaran']       = !empty($row[3]) ? $row[3] : '';
                $data['penglihatan']       = !empty($row[4]) ? $row[4] : '';
                $data['gigi']       = !empty($row[5]) ? $row[5] : '';

                Skrining::create($data);
            }

            $indexKe++;
        }
    }
}
