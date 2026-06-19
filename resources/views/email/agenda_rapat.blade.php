<p>Salam <strong>{{ $namaPeserta }}</strong>,</p>

<p>Anda diundang untuk menghadiri rapat berikut:</p>
<table border="0" cellpadding="5">
    <tr>
        <td><strong>Nama Rapat</strong></td>
        <td>: {{ $rapat->nama }}</td>
    </tr>
    <tr>
        <td><strong>Tanggal</strong></td>
        <td>: {{ $rapat->tanggal->translatedFormat('j F Y') }}</td>
    </tr>
    <tr>
        <td><strong>Waktu</strong></td>
        <td>: {{ $rapat->waktu_mulai }} - {{ $rapat->waktu_selesai }} WIB</td>
    </tr>
</table>

<p>Untuk mengonfirmasi kehadiran Anda dan mengisi tanda tangan absensi, silakan klik tautan khusus Anda di bawah ini:</p>

<p>
    <a href="{{ $linkAbsen }}" style="background-color: #0d6efd; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">
        Isi Kehadiran (Absen)
    </a>
</p>

<p class="text-muted" style="font-size: 11px; color: red;">
    *Perhatian: Jangan bagikan tautan ini kepada siapapun karena tautan ini bersifat unik untuk akun Anda demi mencegah kecurangan absensi.
</p>