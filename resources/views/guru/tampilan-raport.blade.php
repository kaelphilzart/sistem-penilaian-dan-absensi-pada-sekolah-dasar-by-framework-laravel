<!DOCTYPE html>
<html>

<head>
    <style>
        .page-break {
            page-break-after: always;
        }

        .invoice-box {
            padding: 10px;
            font-size: 14px;
            line-height: 17px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #333;
        }

        /* Identitas */
        .invoice-box div.header {
            position: fixed;
            border-bottom: 1px solid #333;
            top: 0;
            right: 0;
            left: 0;
        }

        .invoice-box div.header table td {
            padding: 0px;
            vertical-align: top;
            right: 0;
            left: 0;
        }

        /* End Identitas  */

        /* Footer  */
        .invoice-box div.footer {
            position: fixed;
            font-size: smaller;
            padding-top: 5px;
            border-top: 1px solid #333;
            bottom: 0;
            right: 0;
            left: 0;
        }

        /* End Footer  */

        /* Conten */
        .invoice-box div.content {
            padding-top: 10px;
            right: 0;
            left: 0;
        }

        .invoice-box div.content h3 {
            text-align: center;
        }

        .invoice-box div.content h1 {
            text-align: center;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        /* Heading */
        .invoice-box table tr.heading td {
            background: #eee;
            border: 1px solid #333;
            font-weight: bold;
            text-align: center;
            height: 25px;
        }

        /* Sikap */
        .invoice-box table tr.sikap td {
            border: 1px solid #333;
            padding: 6px;
            height: 150px;
        }

        .invoice-box table tr.sikap td.predikat {
            text-align: center;
            vertical-align: top;
        }

        .invoice-box table tr.sikap td.description {
            vertical-align: top;

            line-height: 20px;
            height: 150px;
        }

        /* End Sikap  */

        /* Nilai */
        .invoice-box table tr.nilai td {
            border: 1px solid #333;
            padding: 3px;
        }

        .invoice-box table tr.nilai td.center {
            text-align: center;
        }

        .invoice-box table tr.nilai td.description {

            font-size: 12px;
            line-height: 14px;
        }

        /* .invoice-box table tr.nilai td.value {
  border-left: 0;
} */
        .invoice-box table tr.nilai td.false {
            border-top: 0;
            border-bottom: 0;
            border-right: 0;
        }

        /* End Nilai */



        @media only screen and (max-width: 650px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .invoice-box.rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .invoice-box.rtl table {
            text-align: right;
        }

        .invoice-box.rtl table tr td:nth-child(2) {
            text-align: left;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .col-md-6 {
            flex: 0 0 50%;
            max-width: 50%;
            padding: 15px;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <div style="text-align: center;">
            <h2>LAPORAN HASIL BELAJAR<br>(RAPOR)</h2>
        </div>
        <div style="padding-bottom: 10px;">
        <table>
                <tr>
                    <td style="width: 30%;">Nama Peserta Didik</td>
                    <td style="width: 52%;">: {{ $siswa->nama_siswa }}</td>
                    <td style="width: 16%;">Kelas</td>
                    <td style="width: 13%;">: {{ $kelas->nama_kelas }}</td>
                </tr>
                <tr>
                    <td style="width: 19%;">NISN</td>
                    <td style="width: 52%;">: {{ $siswa->NISN }}</td>
                    <td style="width: 16%;">Bagian</td>
                    <td style="width: 13%;">: {{ $kelas->bagian }}</td>
                </tr>
                <tr>
                    <td style="width: 19%;">Sekolah</td>
                    <td style="width: 52%;">: SD Negeri Watudakon </td>
                    <td style="width: 16%;">Semester</td>
                    <td style="width: 13%;">: {{ $semester % 2 == 1 ? 'Ganjil' : 'Genap' }}</td>
                </tr>
                <tr>
                    <td style="width: 19%;">Alamat</td>
                    <td style="width: 52%;">: Jl. Raya Watudakon </td>
                    <td style="width: 52%;">Tahun Pelajaran</td>
                    <td style="width: 20%;">:{{ $kelas->tahunAjar->tahunAjar }} </td>
                </tr>
            </table>
        </div>
        <div class="content">
            <table style="width: 100%; border-collapse: collapse; margin-top: 10px; border: 1px solid black;">
                <thead>
                    <tr class="heading">
                        <th style="width: 5%; border: 1px solid black; text-align: center;">No</th>
                        <th style="width: 50%; border: 1px solid black; text-align: center;">Muatan Pelajaran</th>
                        <th style="width: 15%; border: 1px solid black; text-align: center;">Hasil Akhir</th>
                        <th style="width: 30%; border: 1px solid black; text-align: center;" class="text-wrap">Capaian Kompetensi</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $totalRataRata = 0;
                    $jumlahMapel = $nilaiMapel->count();
                    @endphp

                    @foreach($nilaiMapel as $dataMapel)
                    @php
                    $rataRata = $dataMapel->rata_rata ?? '-';
                    if ($rataRata !== '-') {
                        $totalRataRata += $rataRata;
                    }
                    @endphp
                    <tr>
                        <td style="width: 5%; border: 1px solid black; text-align: center;">{{ $loop->iteration }}</td>
                        <td style="width: 50%; border: 1px solid black;">{{ $dataMapel->nama_mapel }}</td>
                        <td style="width: 15%; border: 1px solid black; text-align: center;">{{ $rataRata }}</td>
                        <td style="width: 15%; border: 1px solid black; text-align: center;">{{ $dataMapel->kompetensi }}</td>
                    </tr>
                    @endforeach

                    @php
                    $nilaiRataRataKeseluruhan = $jumlahMapel > 0 ? $totalRataRata / $jumlahMapel : 0;
                    @endphp
                    <tr>
                        <td colspan="2" style="border: 1px solid black; text-align: center; font-weight: bold;">Nilai
                            Rata-Rata Keseluruhan</td>
                        <td  colspan="2" style="border: 1px solid black; text-align: center;">{{
                            number_format($nilaiRataRataKeseluruhan, 2) }}</td>
                    </tr>
                </tbody>
            </table>
            <table style="width: 100%; margin-top: 20px; border: 1px solid black; border-collapse: collapse;">
                <thead>
                    <tr class="heading">
                        <th style="width: 5%; border: 1px solid black; text-align: center;">No</th>
                        <th style="width: 50%; border: 1px solid black; text-align: center;">Estrakulikuler</th>
                        <th style="width: 15%; border: 1px solid black; text-align: center;">Predikat</th>
                        <th style="width: 30%; border: 1px solid black; text-align: center;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($eskul as $mapel => $dataEskul)
                    <tr>
                        <td style="width: 5%; border: 1px solid black; text-align: center;">{{ $loop->iteration }}</td>
                        <td style="width: 50%; border: 1px solid black; ">{{ $dataEskul->nama_eskul }}</td>
                        <td style="width: 15%; border: 1px solid black; text-align: center;">{{ $dataEskul->predikat }}
                        </td>
                        <td style="width: 30%; border: 1px solid black;">{{ $dataEskul->keterangan }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <h4 style="text-align: center;">SKRINING</h4>
            <table style="width: 100%; margin-top: 10px; border: 1px solid black; border-collapse: collapse;">
                <thead>
                    <tr class="heading">
                        <th style="width: 20%; border: 1px solid black; text-align: center;">Tinggi Badan</th>
                        <th style="width: 20%; border: 1px solid black; text-align: center;">Berat Badan</th>
                        <th style="width: 20%; border: 1px solid black; text-align: center;">Pendengaran</th>
                        <th style="width: 20%; border: 1px solid black; text-align: center;">Penglihatan</th>
                        <th style="width: 20%; border: 1px solid black; text-align: center;">Gigi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($skrining as $key => $dataSkrining)
                    <tr>
                        <td style="width: 20%; border: 1px solid black; text-align: center;">{{
                            $dataSkrining->tinggi_badan }}</td>
                        <td style="width: 20%; border: 1px solid black; text-align: center;">{{
                            $dataSkrining->berat_badan }}</td>
                        <td style="width: 20%; border: 1px solid black; text-align: center;">{{
                            $dataSkrining->pendengaran }}</td>
                        <td style="width: 20%; border: 1px solid black; text-align: center;">{{
                            $dataSkrining->penglihatan }}</td>
                        <td style="width: 20%; border: 1px solid black; text-align: center;">{{ $dataSkrining->gigi }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-6">
                    <table style="width: 100%; margin-top: 10px; border: 1px solid black; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style="width: 70%; border: 1px solid black; text-align: center;">Ketidakhadiran</th>
                                <th style="width: 30%; border: 1px solid black; text-align: center;">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($absenData as $status => $total)
                            <tr>
                                <td style="width: 70%; border: 1px solid black; ">{{ ucfirst($status) }}</td>
                                <td style="width: 30%; border: 1px solid black; text-align: center;">{{ $total }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
           
            <p style="text-align: right; padding-top: 20px;">Jombang, {{ \Carbon\Carbon::now()->translatedFormat('d F
                Y') }}</p>
        </div>
        <div style="padding-bottom: 10px;">
            <table>
                <tr>
                    <td style="width: 20%; text-align: center;">Orang Tua/Wali</td>
                    <td style="width: 30%;"></td>
                    <td style="width: 50%; text-align: center; margin-left: 30%;"><!-- Adjust this value as needed -->
                        Wali Kelas
                    </td>
                </tr>
            </table>
            <div style="padding-top: 80px;">
                <table>
                    <tr>
                        <td style="width: 20%; text-align: center;">..............................................</td>
                        <td style="width: 30%;"></td>
                        <td style="width: 50%; text-align: center; "><!-- Adjust this value as needed -->
                            <span style="font-weight: bold;">{{$siswa->nama_lengkap}}</span><br>NIP. {{$siswa->nip}}
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>

    </div>
</body>