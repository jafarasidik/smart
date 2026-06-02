@extends('layout.layout')
@section('title', 'SMART - DATA PESERTA')
@section('page_header', 'Data Peserta')
@section('konten')
    <div class="section">
        <div class="card">
            <div class="card-header">
                <div class="d-grip gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('data.peserta.create') }}" class="btn btn-primary btn-sm m-1">+ Tambah Peserta</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama Peserta</th>
                                <th class="text-center">Jabatan</th>
                                <th class="text-center">Asal Instansi</th>
                                <th class="text-center">No Whatsapp</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @forelse ($data as $d)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $d->nama }}</td>
                                    <td>{{ $d->jxi->nama_jabatan }}</td>
                                    <td>{{ $d->jxi->nama_instansi }}</td>
                                    <td>{{ $d->whatsapp }}</td>
                                    <td>
                                        <a href="{{ route('data.peserta.edit', $d->id) }}"
                                            class="btn btn-sm btn-success m-1" title="Edit Data"><i
                                                class="bi bi-pencil-square"></i></a>
                                        <form action="{{ route('data.peserta.delete', $d->id) }}" method="POST"
                                            class="form-delete" data-nama="{{ $d->nama }}">
                                            @method('DELETE')
                                            @csrf

                                            <button type="submit" class="btn btn-sm btn-danger m-1">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <td colspan="6" class="text-center py-4">
                                    <i class="bi bi-person"></i><br>
                                    <span class="text-muted">Belum ada peserta</span>
                                </td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
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
                title: 'Hapus data peserta?',
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
@endpush
