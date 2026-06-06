@extends('layout.layout')
@section('title', 'SMART - DATA ADMIN')
@section('page_header', 'Data Admin')
@section('konten')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="d-grip gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('data.admin.create') }}" class="btn btn-primary btn-sm m-1">+ Tambah Admin</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama Admin</th>
                                <th class="text-center">Email</th>
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
                                    <td>{{ $d->email }}</td>
                                    @if (auth()->user()->id == $d->id)
                                        <td>Tidak bisa mengubah akun sendiri</td>
                                    @else    
                                        <td>
                                            <a href="{{ route('data.admin.edit', $d->id) }}"
                                                class="btn btn-sm btn-success m-1" title="Edit Data"><i
                                                    class="bi bi-pencil-square"></i></a>
                                            <form action="{{ route('data.admin.delete', $d->id) }}" method="POST"
                                                class="form-delete" data-nama="{{ $d->nama }}">
                                                @method('DELETE')
                                                @csrf

                                                <button type="submit" class="btn btn-sm btn-danger m-1">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <td colspan="6" class="text-center py-4">
                                    <i class="bi bi-person"></i><br>
                                    <span class="text-muted">Belum ada admin</span>
                                </td>
                            @endforelse
                        </tbody>
                    </table>
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
                title: 'Hapus data admin?',
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
