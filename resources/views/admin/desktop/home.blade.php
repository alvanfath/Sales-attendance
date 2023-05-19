@extends('_layouts.desktop')
@section('css')
    <style>
        .color {
            color: #6ccfcb
        }
    </style>
@endsection
@section('heading', 'Halaman dashboard')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h3>Halo {{ $user->name }}</h3>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header">
                    <h5>Total Sales <i class="fa fa-users"></i></h5>
                </div>
                <div class="card-body">
                    <h5>{{ $sales }}</h5>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header">
                    <h5>Total Laporan <i class="fa fa-book-open"></i></h5>
                </div>
                <div class="card-body">
                    <h5>{{ $absensi }}</h5>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header">
                    <h5>Sales Paling Aktif <i class="fa fa-trophy"></i></h5>
                </div>
                <div class="card-body">
                        @forelse ($topSales as $item)
                            <span>{{$loop->iteration}}. <b>{{$item->sales->name}}  ({{$item->total}} laporan)</b></span>
                            <br>
                        @empty
                            <span>Tidak ada sales paling aktif</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 mb-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>Grafik Laporan</h5>
                    <select class="form-select w-25" id="chart-option">
                        <option value="month">Bulan</option>
                        <option value="day">Hari</option>
                        <option value="year">Tahun</option>
                    </select>
                </div>
                <div class="card-body">
                    <canvas id="absence"></canvas>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Grafik Laporan Sales</h5>
                </div>
                <div class="card-body">
                    <canvas id="sales-graph"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('assets/vendor/chart/chart.min.js') }}"></script>
    <script>
        var label = [];
        var value = [];
        @foreach ($absensiGraph as $item)
            @php
                $label = $item['label'];
                $total = $item['total'];
            @endphp
            label.push('{{ $label }}')
            value.push('{{ $total }}')
        @endforeach

        var config1 = {
            type: "line",
            data: {
                labels: label,
                datasets: [{
                    label: 'Total laporan',
                    data: value,
                    borderColor: '#6ccfcb',
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    fill: false,
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 3,
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                }, ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                height: 400,
                interaction: {
                    intersect: false,
                },
                scales: {
                    x: {
                        ticks: {
                            beginAtZero: true
                        }
                    },
                    y: {
                        suggestedMax: 15,
                        stepSize: 5,
                        ticks: {
                            beginAtZero: true
                        }
                    }
                }
            }
        }
        var chartAbsensi = document.getElementById("absence").getContext("2d");
        var absensiChart = new Chart(chartAbsensi, config1);

        $('#chart-option').change(function() {
            var option = $(this).val();
            var url = '{{ route('admin.desktop.get-graph') }}';
            $.ajax({
                type: 'get',
                url: url,
                data: {
                    option: option
                },
                cache: false,
                success: function(response) {
                    var label = [];
                    var value = [];
                    response.forEach(res => {
                        label.push(res.label);
                        value.push(res.total);
                    });
                    config1.data.labels = label;
                    config1.data.datasets[0].data = value

                    absensiChart.update();
                }
            })
        })

        var labelSales = [];
        var totalReport = [];
        @foreach ($salesGraph as $item)
            labelSales.push('{{$item['name']}}');
            totalReport.push('{{$item['total']}}');
        @endforeach
        var config2 = {
            type: "bar",
            data: {
                labels: labelSales,
                datasets: [{
                    label: 'Total laporan',
                    data: totalReport,
                    borderColor: '#6ccfcb',
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    fill: false,
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 3,
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                }, ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                height: 400,
                interaction: {
                    intersect: false,
                },
                scales: {
                    x: {
                        ticks: {
                            beginAtZero: true
                        }
                    },
                    y: {
                        suggestedMax: 15,
                        stepSize: 5,
                        ticks: {
                            beginAtZero: true
                        }
                    }
                }
            }
        }
        var chartSales = document.getElementById("sales-graph").getContext("2d");
        var salesChart = new Chart(chartSales, config2);
    </script>
@endsection
