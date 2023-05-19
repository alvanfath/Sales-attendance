@extends('_layouts.app')
@section('css')
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12 mb-3">
            <div class="card">
                <div class="card-title">
                    <p>Halo {{ $user->name }}</p>
                </div>
                <div class="card-body">
                    <h5>Total Laporan Kamu : {{ $total }}</h5>
                </div>
            </div>
        </div>
        <div class="col-sm-12 d-flex flex-column">
            <span class="mb-3">Lihat Data Laporanmu</span>
            <div class="table-responsive bg-white mb-3 rounded">
                <table class="table">
                    <thead>
                        <tr class="table table-dark">
                            <th>Waktu Masuk</th>
                            <th>Tempat</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                            @php
                                $time = \Carbon\Carbon::parse($item->in_time);
                                $maxLength = 20; // Maximum length of the string

                                $str = $item->place_name;
                                if (strlen($str) > $maxLength) {
                                    $str = substr($str, 0, $maxLength) . '...';
                                }
                            @endphp
                            <tr>
                                <td>{{ $time->format('d F Y H:i:s') }}</td>
                                <td><a target="_blank" href="{{ $item->location }}">{{ $str }}</a></td>
                                <td><a href="#" class="detail" data-id="{{ $item->id }}">lihat Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="3">Tidak ada data</td>
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
@endsection
@section('modal')
    <div class="modal fade" id="popup-detail" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Laporan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center  mb-3">
                        <img src="#" width="100%" height="auto" id="image-modal" class="rounded" alt="">
                    </div>
                    <div class="row">
                        <div class="mb-2 col-sm-12 row">
                            <div class="col-2"><i class="fa fa-map-marker fa-2x"></i></div>
                            <div class="col-10 d-flex align-items-center"><b><a href="#" target="blank"
                                        class="text-dark" id="place_name"></a></b></div>
                        </div>
                        <div class="mb-2 col-sm-12 row">
                            <div class="col-2"><i class="fa fa-circle-arrow-right fa-2x"></i></div>
                            <div class="col-10 d-flex align-items-center"><span id="in_time"></span></div>
                        </div>
                        <div class="mb-2 col-sm-12 row">
                            <div class="col-2"><i class="fa fa-circle-arrow-left fa-2x"></i></div>
                            <div class="col-10 d-flex align-items-center"><span id="out_time"></span></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $('.detail').click(function() {
            var url = '{{ route('get-detail', ':id') }}';
            url = url.replace(':id', $(this).attr('data-id'));
            $.ajax({
                type: 'get',
                url: url,
                cache: false,
                success: function(response) {
                    const in_time = response.in_time;
                    const out_time = response.out_time;

                    const dateIn = new Date(Date.parse(in_time));
                    const dateOut = new Date(Date.parse(out_time));

                    const dateInResult = dateIn.toLocaleString("id-Id", {
                        day: "numeric",
                        month: "long",
                        year: "numeric",
                        hour: "numeric",
                        minute: "numeric",
                        second: "numeric",
                        hour12: false,
                    });
                    const dateOutResult = dateOut.toLocaleString("id-Id", {
                        day: "numeric",
                        month: "long",
                        year: "numeric",
                        hour: "numeric",
                        minute: "numeric",
                        second: "numeric",
                        hour12: false,
                    });
                    var image = '{{ asset('storage/absence/') }}' + '/' + response.image;

                    var place = response.place_name
                    const maxLength = 20;
                    if (place.length > maxLength) {
                        place = place.substring(0, maxLength) + "...";
                    }
                    $('#popup-detail').modal('show');
                    $('#image-modal').attr('src', image);
                    $('#place_name').text(place);
                    $('#place_name').attr('href', response.location);
                    $('#in_time').text(dateInResult);
                    if (response.out_time != null) {
                        $('#out_time').text(dateOutResult);
                    } else {
                        $('#out_time').text('Belum absen keluar')
                    }
                }
            })
        })
    </script>
@endsection
