@extends('layout.layout')

@section('title', 'SMART - LAPORAN AGENDA RAPAT')
@section('page_header', 'Laporan Agenda Rapat')

@section('konten')
    <section class="section">
        <!-- FORM FILTER DATA (Tanpa Refresh) -->
        <div class="card mb-3">
            <div class="card-body">
                <form id="filterForm" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-filter"></i> Filter
                        </button>
                        <button type="button" id="btnReset" class="btn btn-secondary">
                            <i class="bi bi-arrow-clockwise"></i> Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- AREA KONTEN TABEL & EXPORT -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Data Agenda Rapat</h5>
                <!-- Tombol PDF akan muncul jika filter berhasil mendapatkan data -->
                <a href="#" id="btnPdf" class="btn btn-danger btn-sm d-none" target="_BLANK">
                    <i class="bi bi-file-earmark-pdf"></i> Export to PDF
                </a>
            </div>
            
            <!-- Menggunakan ID tableContainer untuk manipulasi AJAX DOM -->
            <div class="card-body" id="tableContainer">
                <div class="text-center py-5 border rounded bg-light">
                    <i class="bi bi-calendar-x text-secondary" style="font-size: 2.5rem;"></i><br>
                    <h6 class="text-muted mt-2">Silahkan filter data terlebih dahulu untuk menampilkan laporan.</h6>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterForm = document.getElementById('filterForm');
        const tableContainer = document.getElementById('tableContainer');
        const btnPdf = document.getElementById('btnPdf');
        const btnReset = document.getElementById('btnReset');
        
        let dataTable = null;

        filterForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah page reload
            
            const tglMulai = document.getElementById('tanggal_mulai').value;
            const tglSelesai = document.getElementById('tanggal_selesai').value;
            
            // Efek Loading Spinner
            tableContainer.innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="text-muted mt-2">Memuat data...</p>
                </div>`;
            
            // Ambil URL route internal Laravel Laporan
            fetch(`{{ route('laporan') }}?tanggal_mulai=${tglMulai}&tanggal_selesai=${tglSelesai}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(res => {
                if (res.success && res.data.length > 0) {
                    let tableHtml = `
                        <div class="table-responsive">
                            <table id="table1" class="table table-hover table-bordered w-100">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 5%">No</th>
                                        <th class="text-center">Nama Agenda</th>
                                        <th class="text-center">Tanggal & Waktu</th>
                                        <th class="text-center">Tempat</th>
                                        <th class="text-center" style="width: 30%">Kehadiran</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>`;
                    
                    res.data.forEach((d, index) => {
                        // Merubah format tanggal default Y-m-d ke format Indonesia
                        const opsi = { day: 'numeric', month: 'long', year: 'numeric' };
                        const tglFormat = new Date(d.tanggal).toLocaleDateString('id-ID', opsi);
                        
                        // LOGIKA PENGECEKAN STATUS KEHADIRAN PESERTA
                        let statusKehadiranHtml = '';
                        if (d.belum_absen_nama && d.belum_absen_nama.length > 0) {
                            // Gabungkan array nama-nama yang belum absen dengan pemisah koma
                            let daftarNama = d.belum_absen_nama.join(', ');
                            statusKehadiranHtml = `
                                <div class="text-start">
                                    <span class="badge bg-danger mb-1"><i class="bi bi-exclamation-circle"></i> Belum Absen:</span><br>
                                    <small class="text-danger fw-bold">${daftarNama}</small>
                                </div>`;
                        } else {
                            // Jika array kosong, berarti semua peserta di rapat tersebut sudah absen
                            statusKehadiranHtml = `
                                <div class="text-center">
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-all"></i> Lengkap (${d.peserta_count ?? 0} Orang)
                                    </span>
                                </div>`;
                        }
                        
                        tableHtml += `
                            <tr>
                                <td class="text-center">${index + 1}</td>
                                <td><strong>${d.nama}</strong></td>
                                <td>${tglFormat} <br><small class="text-muted"><i class="bi bi-clock"></i> ${d.waktu_mulai} - ${d.waktu_selesai}</small></td>
                                <td>${d.ruangan ? d.ruangan.nama : '-'}</td>
                                <td>${statusKehadiranHtml}</td>
                                <td class="text-center">
                                    <span class="badge ${d.status === 'Selesai' ? 'bg-success' : 'bg-warning'}">${d.status}</span>
                                </td>
                            </tr>`;
                    });
                    
                    tableHtml += `</tbody></table></div>`;
                    tableContainer.innerHTML = tableHtml;

                    // Re-inisialisasi DataTables agar fitur search & paging aktif kembali
                    if ($.fn.DataTable.isDataTable('#table1')) {
                        $('#table1').DataTable().destroy();
                    }
                    dataTable = $('#table1').DataTable();

                    // Pasang URL Download PDF dinamis bersama query tanggal filter
                    btnPdf.href = `{{ route('laporan.pdf') }}?tanggal_mulai=${tglMulai}&tanggal_selesai=${tglSelesai}`;
                    btnPdf.classList.remove('d-none');

                } else {
                    // Fallback jika response sukses tapi tidak ada data dalam jangkauan tanggal
                    btnPdf.classList.add('d-none');
                    tableContainer.innerHTML = `
                        <div class="text-center py-5 border rounded bg-light">
                            <i class="bi bi-exclamation-triangle text-warning" style="font-size: 2.5rem;"></i><br>
                            <h6 class="text-muted mt-2">Tidak ada data yang sesuai dengan pencarian Anda.</h6>
                        </div>`;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                tableContainer.innerHTML = `
                    <div class="text-center py-5 border rounded bg-light">
                        <i class="bi bi-x-circle text-danger" style="font-size: 2.5rem;"></i><br>
                        <h6 class="text-danger mt-2">Terjadi kesalahan sistem saat memuat data.</h6>
                    </div>`;
            });
        });

        // Handler Tombol Reset Form Filter
        btnReset.addEventListener('click', function() {
            filterForm.reset();
            btnPdf.classList.add('d-none');
            tableContainer.innerHTML = `
                <div class="text-center py-5 border rounded bg-light">
                    <i class="bi bi-calendar-x text-secondary" style="font-size: 2.5rem;"></i><br>
                    <h6 class="text-muted mt-2">Silahkan filter data terlebih dahulu untuk menampilkan laporan.</h6>
                </div>`;
        });
    });
</script>
@endpush