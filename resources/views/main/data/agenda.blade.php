@extends('layout.layout')
@section('title', 'SMART - DATA AGENDA RAPAT')
@section('page_header', 'Data Agenda Rapat')
@section('konten')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="d-grip gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('data.agenda.create') }}" class="btn btn-primary btn-sm m-1">+ Buat Rapat</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table1" class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama Rapat</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Waktu Mulai</th>
                                <th class="text-center">Waktu Selesai</th>
                                <th class="text-center">Tempat</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $d)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $d->nama }}</td>
                                    <td>{{ $d->tanggal->translatedFormat('j F Y') }}</td>
                                    <td>{{ $d->waktu_mulai }}</td>
                                    <td>{{ $d->waktu_selesai }}</td>
                                    <td>{{ $d->ruangan->nama }} - {{ $d->ruangan->lokasi }}</td>
                                    <td>{{ $d->status ? 'Aktif' : 'Tidak Aktif' }}</td>
                                    <td>
                                        <a href="{{ route('data.agenda.show', $d->id) }}" class="btn btn-sm btn-info m-1"
                                            title="Detail Data"><i class="bi bi-eye"></i></a>
                                        <a href="{{ route('data.agenda.edit', $d->id) }}"
                                            class="btn btn-sm btn-success m-1" title="Edit Data"><i
                                                class="bi bi-pencil-square"></i></a>
                                        <button type="button" class="btn btn-light btn-sm m-1 btn-share"
                                            data-id="{{ $d->id }}" title="Bagikan Agenda">
                                            <i class="bi bi-share-fill"></i>
                                        </button>
                                        <form action="{{ route('data.agenda.delete', $d->id) }}" method="POST"
                                            class="form-delete"
                                            data-nama="{{ $d->nama }} - {{ $d->tanggal->translatedFormat('j F Y') }}">
                                            @method('DELETE')
                                            @csrf

                                            <button type="submit" class="btn btn-sm btn-danger m-1">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <td colspan="8" class="text-center py-4">
                                    <i class="bi bi-calendar-x"></i><br>
                                    <span class="text-muted">Belum ada jadwal rapat</span>
                                </td>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="modal fade" id="modalBagikanAgenda" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Bagikan & Kirim Undangan Rapat</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="loading-share" class="text-center my-3">
                                        <div class="spinner-border text-primary" role="status"></div>
                                        <p class="text-muted small mt-1">Memuat daftar peserta...</p>
                                    </div>

                                    <div id="content-share" style="display: none;">
                                        <h5 id="share-nama-agenda" class="fw-bold mb-1">-</h5>
                                        <p class="text-muted small mb-3" id="share-tanggal-agenda">-</p>

                                        <div class="card mb-3">
                                            <div
                                                class="card-header d-flex justify-content-between align-items-center bg-light">
                                                <span class="fw-bold text-secondary small">PILIH PESERTA YANG AKAN
                                                    DIKIRIMKAN EMAIL</span>
                                                <div>
                                                    <button type="button" class="btn btn-xs btn-outline-secondary py-0"
                                                        id="btn-select-all" style="font-size: 11px;">Pilih Semua</button>
                                                </div>
                                            </div>
                                            <div class="card-body p-0" style="max-height: 250px; overflow-y: auto;">
                                                <ul class="list-group list-group-flush" id="share-daftar-peserta"></ul>
                                            </div>
                                        </div>

                                        <div class="d-grid gap-2">
                                            <button class="btn btn-primary" id="btn-kirim-email" disabled>
                                                <i class="bi bi-envelope-fill"></i> Kirim Undangan ke Peserta Terpilih
                                                (<span id="count-terpilih">0</span>)
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script>
        document.addEventListener('submit', function(e) {

            const form = e.target;

            if (!form.classList.contains('form-delete')) {
                return;
            }

            e.preventDefault();
            const nama = form.dataset.nama;
            Swal.fire({
                title: 'Hapus data agenda rapat?',
                html: `Yakin ingin menghapus <b>${nama}</b>? Data tidak dapat dikembalikan`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {

                if (result.isConfirmed) {
                    form.submit();
                }

            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $('.btn-share').on('click', function() {
                const agendaId = $(this).data('id');

                $('#modalBagikanAgenda').modal('show');
                $('#loading-share').show();
                $('#content-share').hide();
                $('#share-daftar-peserta').empty();
                $('#btn-kirim-email').prop('disabled', true);
                $('#count-terpilih').text('0');

                $.ajax({
                    url: `/main/data/agenda/${agendaId}/json`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#share-nama-agenda').text(response.nama);
                        $('#share-tanggal-agenda').text(
                            `${response.tanggal} ${response.waktu_mulai} - ${response.waktu_selesai} - ${response.ruangan}`);

                        if (response.peserta.length > 0) {
                            $.each(response.peserta, function(index, p) {
                                // Pasang UUID di atribut checkbox
                                $('#share-daftar-peserta').append(`
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <div>
                                    <h6 class="mb-0 small fw-bold">${p.nama}</h6>
                                    <span class="text-muted" style="font-size: 11px;">${p.email}</span>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input cb-peserta" type="checkbox" value="${p.uuid}">
                                </div>
                            </li>
                        `);
                            });
                        } else {
                            $('#share-daftar-peserta').append(
                                '<li class="list-group-item text-center text-muted py-3 small">Tidak ada peserta yang terdaftar di agenda ini.</li>'
                                );
                        }

                        // --- LOGIC INTERAKSI CHECKBOX ---

                        // Event saat checkbox individu berubah status
                        $(document).off('change', '.cb-peserta').on('change', '.cb-peserta',
                            function() {
                                const countChecked = $('.cb-peserta:checked').length;
                                $('#count-terpilih').text(countChecked);
                                $('#btn-kirim-email').prop('disabled', countChecked === 0);
                            });

                        // Tombol Pilih Semua / Batalkan Semua
                        $('#btn-select-all').off('click').on('click', function() {
                            const totalPeserta = $('.cb-peserta').length;
                            if (totalPeserta === 0) return;

                            const isAllChecked = $('.cb-peserta:checked').length ===
                                totalPeserta;
                            $('.cb-peserta').prop('checked', !isAllChecked).trigger(
                                'change');
                            $(this).text(!isAllChecked ? 'Batalkan Semua' :
                                'Pilih Semua');
                        });

                        // --- PROSES KIRIM POST EMAIL ---
                        $('#btn-kirim-email').off('click').on('click', function() {
                            const $btn = $(this);

                            // Kumpulkan semua UUID yang di-check
                            let selectedUuids = [];
                            $('.cb-peserta:checked').each(function() {
                                selectedUuids.push($(this).val());
                            });

                            $btn.prop('disabled', true).html(
                                '<span class="spinner-border spinner-border-sm"></span> Mengirim Undangan Unik...'
                                );

                            $.ajax({
                                url: `/main/data/agenda/${agendaId}/kirim-email`,
                                type: 'POST',
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr(
                                        'content'),
                                    uuids: selectedUuids // Kirim data UUID berupa array ke backend
                                },
                                dataType: 'json',
                                success: function(res) {
                                    alert(res.message);
                                    $('#modalBagikanAgenda').modal('hide');
                                },
                                error: function(xhr) {
                                    alert(xhr.responseJSON ? xhr
                                        .responseJSON.message :
                                        'Terjadi kegagalan sistem.');
                                },
                                complete: function() {
                                    $btn.html(
                                        '<i class="bi bi-envelope-fill"></i> Kirim Undangan ke Peserta Terpilih (<span id="count-terpilih">0</span>)'
                                        );
                                    $('.cb-peserta').trigger('change');
                                }
                            });
                        });

                        $('#loading-share').hide();
                        $('#content-share').fadeIn();
                    }
                });
            });
        });
    </script>
@endpush
