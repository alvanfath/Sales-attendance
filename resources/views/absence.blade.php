@extends('_layouts.app')
@section('css')
@endsection
@section('content')
    <div class="row">
        @if ($exist == false)
            <div class="col-sm-12 mb-3">
                <div class="card text-center">
                    <h5>Silakan isi laporan</h5>
                </div>
            </div>
            <div class="col-sm-12">
                <form action="{{ route('store-attendance') }}" class="card" method="post">
                    @csrf
                    <input type="hidden" name="image" id="image_id">
                    <div class="d-flex justify-content-center mb-1">
                        <div id="camera"></div>
                        <div id="image_snap" class="d-none d-flex justify-content-center"></div>
                    </div>
                    <div class="text-center mb-1" id="message-image">
                        @error('image')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="text-center mb-3">
                        <button type="button" class="btn btn-dark rounded-pill w-25" id="btn-take"><i
                                class="fa fa-camera"></i></button>
                        <button type="button" class="btn btn-dark rounded-pill w-25 d-none" id="btn-retake"><i
                                class="fa fa-refresh"></i></button>
                    </div>
                    <input type="hidden" name="lat" id="lat">
                    <input type="hidden" name="long" id="long">
                    <div class="form-group mb-3">
                        <label for="place_name">Nama Tempat:</label>
                        <input type="text" id="place_name"
                            class="form-control @error('place_name')
                        is-invalid
                    @enderror"
                            name="place_name" placeholder="Nama Tempat yang dikunjungi">
                        @error('place_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button class="btn btn-dark w-100">Submit</button>
                </form>
            </div>
        @else
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-title" style="margin-bottom:-20px;">
                        <h3>Absensi</h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-center  mb-3">
                            <img src="{{ asset('storage/absence/' . $attendance->image) }}" width="100%" height="auto"
                                class="rounded" alt="">
                        </div>
                        <div class="row">
                            <div class="mb-2 col-sm-12 row">
                                <div class="col-2"><i class="fa fa-map-marker fa-2x"></i></div>
                                <div class="col-10 d-flex align-items-center"><b><a target="blank" href="{{ $attendance->location }}"
                                            class="text-dark">{{ $attendance->place_name }}</a></b></div>
                            </div>
                            <div class="mb-2 col-sm-12 row">
                                <div class="col-2"><i class="fa fa-clock fa-2x"></i></div>
                                <div class="col-10 d-flex align-items-center">
                                    <b>{{ date('d F Y H:i:s', strtotime($attendance->in_time)) }}</b></div>
                            </div>
                            <div class="mb-2 col-sm-12 text-center">
                                @php
                                    $timeInput = \Carbon\Carbon::parse($attendance->in_time)->addHours(1);
                                @endphp
                                <button type="button" {{\Carbon\Carbon::now()->greaterThan($timeInput) ? '' : 'disabled'}} id="btn-out" class="btn btn-dark">Input Absen Keluar</button>
                                <br>
                                @if (!now()->greaterThan($timeInput))
                                    <small>kamu bisa isi absen keluar pada jam {{date('H:i:s', strtotime($timeInput))}}</small>
                                @endif
                            </div>
                            <form action="{{ route('update-att', $attendance->id) }}" id="form-update" method="post"
                                hidden>
                                @csrf
                                @method('put')
                                <input type="hidden" name="lat" id="lat">
                                <input type="hidden" name="long" id="long">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/vendor/webcam/webcamjs.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtxCgKPzjlgFnUeGZXdQ08_9ExcHV8dCQ"></script>
    <script>
        $(document).ready(function() {
            @if ($exist == false)
                initiateWebcam();
            @endif
            @error('lat')
                alert('{{ $message }}')
            @enderror
            $('#btn-take').click(function() {
                $("#camera").show();
                Webcam.snap(function(data_uri) {
                    $('#image_snap').html(
                        '<img width="74%" height="200px" border-radius: 4px 4px 0px 0px;" src="' +
                        data_uri +
                        '"/>');
                    $('#image_id').val(data_uri);
                });
                $('#image_snap').removeClass('d-none');
                $('#message-image').fadeOut('slow', function() {
                    $(this).empty()
                })
                $("#camera").hide();
                $('#btn-retake').removeClass('d-none');
                $('#btn-take').hide();
            });

            $('#btn-retake').click(function() {
                $('#image_id').val('')
                $("#camera").show();
                $('#image_snap').empty();
                $('#camera').show();
                $('#btn-retake').addClass('d-none');
                $('#btn-take').show();
            })

            $('#btn-out').click(function() {
                $('#form-update').submit();
            })
        })

        function initiateWebcam() {
            Webcam.set({
                width: 360,
                height: 200,
                image_format: 'jpeg',
                jpeg_quality: 100
            });
            Webcam.attach('#camera');
        }
    </script>
    <script>
        x = navigator.geolocation;
        x.getCurrentPosition(success, fail, {
            enableHighAccuracy: true,
            maximumAge: 0,
            timeout: 10000
        });

        function success(position) {
            let myLat = position.coords.latitude;
            let myLong = position.coords.longitude;
            let accuracy = position.coords.accuracy;
            console.log('accuracy : ' + accuracy + ' meters')
            document.getElementById('lat').value = myLat;
            document.getElementById('long').value = myLong;
            // Create a new instance of Geocoder
            const geocoder = new google.maps.Geocoder();

            // Create a LatLng object
            const latLng = new google.maps.LatLng(myLat, myLong);

            // Perform reverse geocoding
            geocoder.geocode({
                location: latLng
            }, function(results, status) {
                if (status === "OK") {
                    if (results[0]) {
                        const placeName = results[0].formatted_address;
                        $('#place_name').val(placeName)
                    } else {
                        console.log("No results found");
                    }
                } else {
                    console.log("Geocoder failed due to:", status);
                }
            });
        }

        function fail() {
            console.log('waduch gabisa dek geolocationnya error')
        }
    </script>
@endsection
