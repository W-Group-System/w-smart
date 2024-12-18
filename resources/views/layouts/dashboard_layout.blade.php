<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    {{-- <link rel="stylesheet" href="{{asset('vendors/select2/select2.min.css')}}"> --}}

    {{-- Chosen --}}
    <link rel="stylesheet" href="{{asset('css/component-chosen.css')}}">
    <!-- Your Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <meta name="user-role-id" content="{{ Auth::user()->role }}">

</head>

<style>
    .pagination {
        margin-top: 10px;
        float: right !important;
    }
</style>

<body>
    @include('layouts.dashboard_header')

    <div class="container-fluid page-body-wrapper d-flex" style="padding-top: 70px; margin-right: 500px;">
        @include('layouts.dashboard_sidebar')

        <div class="main-content flex-grow-1">
            @yield('dashboard_content')
        </div>
    </div>

    @include('sweetalert::alert')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <script src="{{asset('vendors/select2/select2.min.js')}}"></script> --}}
    {{-- <script src="{{asset('js/select2.js')}}"></script> --}}
    {{-- Chosen --}}
    <script src="{{asset('js/chosen.jquery.js')}}"></script>
    <script>
        $('.chosen-select').chosen();
    </script>
    <!-- Include the main.js script -->
    <script src="{{ asset('js/main.js') }}"></script>
    @stack('scripts')
</body>

</html>