@extends('_layouts.desktop')
@section('css')
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        .my-custom-scrollbar {
            position: relative;
            height: 200px;
            overflow: auto;
        }

        .table-wrapper-scroll-y {
            display: block;
        }
    </style>
@endsection
@section('heading', 'Halaman Sales')
@section('content')
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header">
                    <h5>Form Tambah Sales</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.desktop.sales.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Sales</label>
                            <input type="text" name="name" placeholder="Ujang"
                                class="form-control @error('name')
                            is-invalid
                            @enderror">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Email</label>
                            <input type="email" name="email" placeholder="ujang@yahoo.com"
                                class="form-control @error('email')
                            is-invalid
                            @enderror">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Username</label>
                            <input type="text" name="username" placeholder="ujangmaman"
                                class="form-control @error('username')
                            is-invalid
                            @enderror">
                            @error('username')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">No Telepon</label>
                            <input type="number" name="phone_number" placeholder="0823******"
                                class="form-control @error('phone_number')
                            is-invalid
                            @enderror">
                            @error('phone_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Password</label>
                            <input type="password" name="password" placeholder="******"
                                class="form-control @error('password')
                            is-invalid
                            @enderror">
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button class="btn btn-dark" type="submit">Simpan</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-sm-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>Data Sales</h5>
                    <h5>Total Sales : {{ $total }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive mb-3">
                        <table class="table">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>No telepon</th>
                                    <th>Total Laporan</th>
                                    <th>Aksi</th>
                                    <th>Laporan Bulanan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $item)
                                    @php
                                        $laporan = \App\Models\Absensi::where('sales_id', $item->id)->count();
                                    @endphp
                                    <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->username }}</td>
                                        <td>{{ $item->phone_number }}</td>
                                        <td>{{ $laporan }}</td>
                                        <td>
                                            <form action="{{ route('admin.desktop.sales.destroy', $item->id) }}"
                                                method="post" class="form-delete"
                                                onsubmit="return confirm('Apakah anda yakin?')">
                                                @csrf
                                                @method('delete')
                                                <button type="button" data-id="{{ $item->id }}"
                                                    class="btn btn-sm btn-dark btn-detail" title="Lihat Laporan"><i
                                                        class="fa fa-eye"></i></button>
                                                <button type="submit" class="btn btn-sm btn-danger"><i
                                                        class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                        <td><a class="btn btn-dark btn-sm" href="{{route('admin.desktop.sales.absence-monthly', $item->id)}}">Lihat</a></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data sales</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end">
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modal')
    <div class="modal fade text-left" id="absence-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="title-absence-modal"></h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Foto</th>
                                    <th>Nama Tempat</th>
                                    <th>Lokasi Awal</th>
                                    <th>Jam Masuk</th>
                                    <th>Lokasi Akhir</th>
                                    <th>Jam Keluar</th>
                                    <th>Status</th>
                                    <th>Range Waktu</th>
                                </tr>
                            </thead>
                            <tbody id="data-loop">

                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <span id="total-report"></span>
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('js')
    <script>
        $('.btn-detail').click(function() {
            var url = '{{ route('admin.desktop.sales.absence', ':id') }}';
            url = url.replace(':id', $(this).attr('data-id'))
            $.ajax({
                type: 'get',
                url: url,
                cache: false,
                success: function(response) {
                    var name = response.name;
                    var data = response.data;
                    var htmlView = ''
                    var noResponse = '<tr><td colspan="8" class="text-center">Tidak ada data</td></tr>'
                    $('#absence-modal').modal('show')
                    $('#title-absence-modal').text('Laporan ' + name)
                    $('#total-report').text('Total laporan : ' + data.length)
                    if (data.length == 0) {
                        $('#data-loop').html(noResponse)
                    } else {
                        for (let i = 0; i < data.length; i++) {
                            var lastLoc = '';
                            var outTime = '';
                            var dateIn = new Date(Date.parse(data[i].in_time));
                            var dateOut = new Date(Date.parse(data[i].out_time));

                            var dateInResult = dateIn.toLocaleString("id-Id", {
                                day: "numeric",
                                month: "long",
                                year: "numeric",
                                hour: "numeric",
                                minute: "numeric",
                                second: "numeric",
                                hour12: false,
                            });
                            var dateOutResult = dateOut.toLocaleString("id-Id", {
                                day: "numeric",
                                month: "long",
                                year: "numeric",
                                hour: "numeric",
                                minute: "numeric",
                                second: "numeric",
                                hour12: false,
                            });


                            var timeDiff = Math.abs(dateOut - dateIn);

                            var hours = Math.floor(timeDiff / (1000 * 60 * 60));
                            var minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));

                            console.log("Time Range:", );
                            var image = '{{ asset('storage/absence') }}' + '/' + data[i].image;
                            if (data[i].last_location == null) {
                                lastLoc = 'Belum input absen keluar';
                                outTime = 'Belum input absen keluar';
                            } else {
                                lastLoc = '<a href="' + data[i].last_location +
                                    '" target="blank">Lihat lokasi terakhir</a>';
                                outTime = dateOutResult;
                            }
                            var status = 'Selesai';
                            var rangeTime = hours + " jam, " + minutes + " menit";
                            if (data[i].out_time == null) {
                                status = 'Ongoing';
                                rangeTime = 'Ongoing';
                            }
                            var place = data[i].place_name
                            const maxLength = 20;
                            if (place.length > maxLength) {
                                place = place.substring(0, maxLength) + "...";
                            }
                            htmlView += `<tr>
                                <td><img src="` + image + `" width="200px" height="100px"></td>
                                <td>` + place + `</td>
                                <td><a href="` + data[i].location + `" target="blank">Lihat lokasi awal</a></td>
                                <td>` + dateInResult + `</td>
                                <td>` + lastLoc + `</td>
                                <td>` + outTime + `</td>
                                <td>` + status + `</td>
                                <td>` + rangeTime + `</td>
                                </tr>`
                            $('#data-loop').html(htmlView)
                        }
                    }

                }
            })
        })
    </script>
@endsection
