<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
</script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>

{{-- plugin --}}
<script src="{{ asset('assets/modules/notflix/notiflix-notify-aio-3.2.5.min.js') }}"></script>
<script src="{{ asset('assets/modules/notflix/notiflix-report-aio-3.2.5.min.js') }}"></script>
<script src="{{ asset('assets/modules/notflix/notiflix-3.2.5.min.js') }}"></script>
<script src="{{ asset('assets/modules/notflix/notiflix-aio-3.2.5.min.js') }}"></script>

<script>
    var maxHeight = $('#v1').height();

    $("#content").each(function() {
        if ($(this).height() > maxHeight) {
            maxHeight = $(this).height();
        }
    });

    $("#v1").height(maxHeight);
    $("#v2").height(maxHeight);
    $('#logout').click(function() {
        $('#logout-form').submit()
    })
</script>
<script>
    @if (Session::has('success'))
        Notiflix.Report.success(
            '',
            '{{ Session::get('success') }}',
            'Tutup',
        );
    @endif

    @if (Session::has('error'))
        Notiflix.Report.failure(
            '',
            '{{ Session::get('error') }}',
            'Tutup',
        );
    @endif
</script>
