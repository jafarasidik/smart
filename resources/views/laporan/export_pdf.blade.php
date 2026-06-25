<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Agenda Rapat</title>
    <style>
        body {
            background: #fff;
            color: #000;
            font-size: 11pt;
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 0;
        }

        .table-cetak {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
            font-family: 'Times New Roman', Times, serif;
            margin-top: 8px;
            border: 1px solid #000;
        }

        .table-cetak thead tr th {
            background-color: #BFBFBF;
            border: 1px solid #000;
            padding: 5px 5px;
            font-weight: bold;
            font-size: 10pt;
            text-align: center;
            vertical-align: middle;
            color: #000;
        }

        .table-cetak tbody td {
            border: 1px solid #000;
            padding: 4px 5px;
            vertical-align: top;
            font-size: 10pt;
            line-height: 1.4;
            color: #000;
            background-color: #fff;
        }

        .table-cetak tbody tr:nth-child(even) td {
            background-color: #EDEDED;
        }

        tr {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>

    {{-- Kop Surat --}}
    <div style="text-align:center; margin-bottom:16px; border-bottom:2px solid #000; padding-bottom:10px;">
        <p style="margin:0; font-size:11pt; font-weight:normal; font-family:'Times New Roman',serif; color:#000;">
            SISTEM MANAJEMEN AGENDA RAPAT TERPADU
        </p>
        <h2 style="margin:4px 0 2px; font-size:16pt; font-weight:bold; font-family:'Times New Roman',serif; text-transform:uppercase; letter-spacing:1px; color:#000;">
            Laporan Agenda Rapat
        </h2>
        @if(request('start_date') || request('end_date'))
            <p style="margin:0; font-size:10pt; font-family:'Times New Roman',serif; color:#000;">
                Periode:
                {{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->translatedFormat('j F Y') : '—' }}
                s/d
                {{ request('end_date') ? \Carbon\Carbon::parse(request('end_date'))->translatedFormat('j F Y') : '—' }}
            </p>
        @endif
        <p style="margin:2px 0 0; font-size:9pt; font-family:'Times New Roman',serif; color:#000;">
            Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('j F Y') }}
        </p>
    </div>

    {{-- Tabel Cetak --}}
    <table class="table-cetak">
        <thead>
            <tr>
                <th style="width:4%;">No</th>
                <th style="width:20%; text-align:left;">Nama Agenda</th>
                <th style="width:13%; text-align:left;">Tanggal</th>
                <th style="width:9%;">Waktu Mulai</th>
                <th style="width:9%;">Waktu Selesai</th>
                <th style="width:10%; text-align:left;">Tempat</th>
                <th style="width:13%; text-align:left;">Hadir</th>
                <th style="width:11%; text-align:left;">Izin / Tidak Hadir</th>
                <th style="width:11%; text-align:left;">Belum Absen</th>
                <th style="width:7%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($laporanRapat as $idx => $rapat)
                @php
                    $h=[]; $iz=[]; $th=[]; $ba=[];
                    foreach($rapat->peserta as $p) {
                        $ab = $rapat->kehadiran->where('id_peserta', $p->id)->first();
                        if (!$ab)                           $ba[] = $p->nama;
                        elseif ($ab->status=='Hadir')       $h[]  = $p->nama;
                        elseif ($ab->status=='Izin')        $iz[] = $p->nama;
                        elseif ($ab->status=='Tidak Hadir') $th[] = $p->nama;
                    }
                    $izTh = array_merge($iz, $th);
                @endphp
                <tr>
                    <td style="text-align:center;">{{ $idx + 1 }}</td>
                    <td>{{ $rapat->nama }}</td>
                    <td>{{ \Carbon\Carbon::parse($rapat->tanggal)->translatedFormat('d F Y') }}</td>
                    <td style="text-align:center;">{{ $rapat->waktu_mulai }}</td>
                    <td style="text-align:center;">{{ $rapat->waktu_selesai }}</td>
                    <td>{{ $rapat->ruangan->nama ?? '-' }}</td>
                    <td>{{ count($h) > 0 ? implode(', ', $h) : '-' }}</td>
                    <td>{{ count($izTh) > 0 ? implode(', ', $izTh) : '-' }}</td>
                    <td>{{ count($ba) > 0 ? implode(', ', $ba) : '-' }}</td>
                    <td style="text-align:center;">{{ $rapat->status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" style="text-align:center; padding:12px;">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Tanda Tangan --}}
    {{-- DOMPDF does not support display:flex, we use float right --}}
    <div style="margin-top:28px; width: 100%; clear: both; color:#000;">
        <div style="float: right; text-align:center; width:300px;">
            <p style="margin:0; color:#000;">{{ \Carbon\Carbon::now()->translatedFormat('j F Y') }}</p>
            <p style="margin:2px 0 0; color:#000;">Mengetahui,</p>
            <div style="margin-top:100px; border-top:1px solid #000; padding-top:4px; color:#000;">
                ( Dr. Hj. Betty Suprapti, S.Kp., M.Kes. )
            </div>
            <p style="margin:2px 0 0; font-size:9pt; color:#000;">Ketua Yayasan Bakti Tunas Husada</p>
        </div>
    </div>

</body>
</html>