@extends('layout.layout')
@section('title', 'SMART - DATA NOTULENSI')
@section('page_header', 'Data Notulensi')
@section('konten')
    <div class="section">
        <div class="card">
            <div class="card-header">
                <div class="d-grip gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('data.notulensi.create') }}" class="btn btn-primary btn-sm m-1">+ Tambah Notulensi</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama Rapat</th>
                                <th class="text-center">Tanggal Rapat</th>
                                <th class="text-center">Isi Notulensi</th>
                                <th class="text-center">Dokumen</th>
                                <th class="text-center">Aktif Sampai</th>
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
                                    <td>{{ $d->rapat->nama }}</td>
                                    <td>{{ $d->rapat->tanggal->translatedFormat('j F Y') }}</td>
                                    <td>{{ $d->isi_notulensi }}</td>
                                    <td>
                                        @if($d->file)
                                            <a href="{{ asset('file/' . $d->file) }}" target="_blank">Lihat Dokumen</a>
                                        @else
                                            <span class="text-muted">Tidak ada file</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($d->sampai)
                                            {{ $d->sampai->translatedFormat('j F Y') }}
                                        @else
                                            Tidak di publish
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('data.notulensi.edit', $d->id) }}"
                                            class="btn btn-sm btn-success m-1" title="Edit Data"><i
                                                class="bi bi-pencil-square"></i></a>
                                        <form action="{{ route('data.notulensi.delete', $d->id) }}" method="POST"
                                            class="form-delete" data-nama="{{ $d->rapat->nama }} - {{ $d->rapat->tanggal->translatedFormat('j F Y') }}">
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
                                    <i class="bi bi-book-fill"></i><br>
                                    <span class="text-muted">Belum ada notulensi</span>
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
                title: 'Hapus data notulensi?',
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
