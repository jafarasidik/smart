@extends("layout.layout")
@section("title", "SMART - DATA RUANGAN")
@section("page_header", "Data Ruangan")
@section("konten")
    <div class="section">
        <div class="card">
            <div class="card-header">
                <div class="d-grip gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('data.ruangan.create') }}" class="btn btn-primary btn-sm m-1">+ Tambah Ruangan</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama Ruangan</th>
                                <th class="text-center">Lokasi</th>
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
                                    <td>{{ $d->lokasi }}</td>
                                    <td>
                                        <a href="{{ route('data.ruangan.edit', $d->id) }}" class="btn btn-sm btn-success m-1" title="Edit Data"><i class="bi bi-pencil-square"></i></a>
                                        <form action="{{ route('data.ruangan.delete', $d->id) }}" method="POST"
                                            class="form-delete" data-nama="{{ $d->nama }} - {{ $d->lokasi }}">
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
                                    <i class="bi bi-door-open"></i><br>
                                    <span class="text-muted">Belum ada ruangan</span>
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
                title: 'Hapus data ruangan?',
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