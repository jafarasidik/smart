<!DOCTYPE html>
<html>
<head>
    <title>Notulensi Rapat</title>
</head>
<body>
    <h2>NOTULENSI HASIL RAPAT</h2>
    <p>Halo Bapak/Ibu, berikut dikirimkan rincian hasil notulensi rapat yang telah selesai diselenggarakan:</p>
    
    <table border="0" cellpadding="5">
        <tr>
            <td><strong>Nama Rapat</strong></td>
            <td>: {{ $notulensi->rapat->nama }}</td>
        </tr>
        <tr>
            <td><strong>Tanggal</strong></td>
            <td>: {{ \Carbon\Carbon::parse($notulensi->rapat->tanggal)->translatedFormat('j F Y') }}</td>
        </tr>
    </table>

    <hr>
    <h3>Isi Notulensi:</h3>
    <div style="background: #f4f6f9; padding: 15px; border-left: 4px solid #007bff; white-space: pre-line;">
        {{ $notulensi->isi_notulensi }}
    </div>
    <hr>

    <p>Terlampir pula dokumen pendukung hasil rapat pada email ini (jika ada) yang dapat Anda unduh secara berkala.</p>
    <p>Terima kasih,<br><strong>Sekretariat SMART Application</strong></p>
</body>
</html>