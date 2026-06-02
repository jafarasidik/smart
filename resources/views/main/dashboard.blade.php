@extends('layout.layout')
@section('title', 'SMART - Dashboard')
@section('page_header', 'Dashboard')
@section('konten')
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon purple mb-2">
                                            <i class="iconly-boldActivity"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-mutted font-semibold">Total Rapat</h6>
                                        <h6 class="font-extrabold mb-0">{{ $tr }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon blue mb-2">
                                            <i class="iconly-boldUser1"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-mutted font-semibold">Peserta Rapat</h6>
                                        <h6 class="font-extrabold mb-0">{{ $tp }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon green mb-2">
                                            <i class="iconly-boldGraph"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-mutted font-semibold">Rata-rata Hadir</h6>
                                        <h6 class="font-extrabold mb-0">{{ $rh }}%</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon red mb-2">
                                            <i class="iconly-boldProfile"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-mutted font-semibold">User Admin</h6>
                                        <h6 class="font-extrabold mb-0">{{ $ua }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Rapat Mendatang</h4>
                                <a href="{{ route('data.agenda') }}" class="btn btn-sm btn-primary">+ Buat Rapat</a>
                            </div>
                            <div class="card-body">
                                <table class="table table-hover table-lg">
                                    <tbody>
                                        @forelse ($rapat_mendatang as $r)
                                            <tr>
                                                <td class="col-1">
                                                    <span
                                                        class="badge bg-light-info">{{ $r->tanggal->translatedFormat('j F Y') }}</span>
                                                </td>
                                                <td class="col-auto">
                                                    <h6>{{ $r->nama }}</h6>
                                                    <p class="text-muted">{{ $r->waktu_mulai }} - {{ $r->waktu_selesai }} -
                                                        {{ $r->peserta_count }} Peserta</p>
                                                    <div class="badges">
                                                        <span class="badge bg-light-danger">{{ $r->countdown }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <td colspan="2" class="text-center py-4">
                                                <i class="bi bi-calendar-x"></i><br>
                                                <span class="text-muted">Belum ada jadwal rapat</span>
                                            </td>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Kehadiran per bulan</h4>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label>Tanggal Awal</label>
                                        <input type="date" id="tanggal_awal" class="form-control"
                                            value="{{ now()->subMonths(5)->format('Y-m-d') }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label>Tanggal Akhir</label>
                                        <input type="date" id="tanggal_akhir" class="form-control"
                                            value="{{ now()->format('Y-m-d') }}">
                                    </div>

                                    <div class="col-md-12 d-flex justify-content-center align-items-center mt-2">
                                        <button id="btnFilter" class="btn btn-primary me-2">
                                            Filter
                                        </button>
                                        <button type="button" id="btnReset" class="btn btn-danger">
                                            Reset
                                        </button>
                                    </div>
                                </div>
                                <div id="chart-profile-visit">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('script')
    <script src="/assets/mazer/extensions/apexcharts/apexcharts.min.js"></script>
    <script>
        let chart;

        function loadChart() {

            $.ajax({
                url: "{{ route('dashboard.chart-kehadiran') }}",
                type: "GET",
                data: {
                    tanggal_awal: $('#tanggal_awal').val(),
                    tanggal_akhir: $('#tanggal_akhir').val()
                },
                success: function(result) {

                    if (!chart) {

                        chart = new ApexCharts(
                            document.querySelector("#chart-profile-visit"), {
                                chart: {
                                    type: 'bar',
                                    height: 300
                                },
                                series: [{
                                    name: 'Kehadiran (%)',
                                    data: result.series
                                }],
                                xaxis: {
                                    categories: result.categories
                                },
                                yaxis: {
                                    min: 0,
                                    max: 100
                                }
                            }
                        );

                        chart.render();

                    } else {

                        chart.updateOptions({
                            xaxis: {
                                categories: result.categories
                            }
                        });

                        chart.updateSeries([{
                            name: 'Kehadiran (%)',
                            data: result.series
                        }]);
                    }
                },
                error: function(xhr) {

                    let res = xhr.responseJSON;

                    let msg = '';

                    if (res.errors) {
                        msg = Object.values(res.errors)
                            .flat()
                            .join('\n');
                    } else {
                        msg = res.message;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Tanggal tidak valid',
                        text: msg
                    });
                }
            });
        }

        loadChart();

        $('#btnFilter').on('click', function() {
            loadChart();
        });

        function resetFilter() {

            let today = new Date();
            let sixMonthsAgo = new Date();
            sixMonthsAgo.setMonth(today.getMonth() - 5);

            $('#tanggal_awal').val(sixMonthsAgo.toISOString().split('T')[0]);
            $('#tanggal_akhir').val(today.toISOString().split('T')[0]);

            loadChart();
        }
        $('#btnReset').on('click', function() {
            resetFilter();
        });
    </script>
@endpush
