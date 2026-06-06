@extends('layout.layout')
@section('title', 'SMART - DATA INSTANSI DAN JABATAN')
@section('page_header', 'Data Instansi dan Jabatan')
@section('konten')
    <div class="section">
        <div class="card">
            <div class="card-header">
                <div class="d-grip gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('data.ixj.create') }}" class="btn btn-primary btn-sm m-1">+ Tambah Instansi dan
                        Jabatan</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table1" class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama Instansi</th>
                                <th class="text-center">Nama Jabatan</th>
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
                                    <td>{{ $d->nama_instansi }}</td>
                                    <td>{{ $d->nama_jabatan }}</td>
                                    <td>
                                        <a href="{{ route('data.ixj.edit', $d->id) }}" class="btn btn-sm btn-success m-1"
                                            title="Edit Data"><i class="bi bi-pencil-square"></i></a>
                                        <form action="{{ route('data.ixj.delete', $d->id) }}" method="POST"
                                            class="form-delete" data-nama="{{ $d->nama_instansi }} - {{ $d->nama_jabatan }}">
                                            @method('DELETE')
                                            @csrf

                                            <button type="submit" class="btn btn-sm btn-danger m-1">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <td colspan="4" class="text-center py-4">
                                    <i class="bi bi-person-workspace"></i><br>
                                    <span class="text-muted">Belum ada Instansi dan Jabatan</span>
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
                title: 'Hapus data instansi dan jabatan?',
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