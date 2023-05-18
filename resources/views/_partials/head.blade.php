<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

<!-- Primary Meta Tags -->
<title>Sales Attendance</title>
<!-- Favicon-->
<link rel="icon" type="image/x-icon" href="{{ asset('assets/img/fingerprint.png') }}" />

<!-- General CSS Files -->
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/all.min.css') }}">

<!-- Custom CSS  -->
<link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">

<link rel="stylesheet" href="{{ asset('assets/modules/notflix/notiflix-3.2.5.min.css') }}" />
<style>
    .content-body {
        margin-bottom: 100px;
    }

    .overlay {
        height: 100%;
        width: 100%;
        display: none;
        position: relative;
        z-index: 1;
        top: 0;
        left: 0;
        opacity: 1;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.9);
    }

    .overlay-content {
        width: 90%;
    }

    .overlay .closebtn {
        font-size: 2rem;
        cursor: pointer;
        color: white;
    }

    .overlay .closebtn:hover {
        color: #ccc;
    }

    .overlay input[type=search]:focus {
        border-color: transparent;
        box-shadow: none;
    }

    .ui-autocomplete {
        max-height: 400px;
        width: 320px;
        overflow-y: auto;
        /* prevent horizontal scrollbar */
        overflow-x: hidden;
        /* add padding to account for vertical scrollbar */
        margin-top: 10px;
        border-radius: 10px;
        margin-top: 20px !important;
    }

    .ui-menu .ui-menu-item {
        font-size: 18px;
    }

    .vl {
        position: absolute;
        left: 0;
        margin-left: 15px;
        border-left: 1px solid #ededed;
        height: 100%;
    }

    .v2 {
        position: absolute;
        right: 0;
        margin-right: 15px;
        border-left: 1px solid #ededed;
        height: 100%;
    }
</style>
