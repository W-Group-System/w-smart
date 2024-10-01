<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Your Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <meta name="user-role-id" content="{{ Auth::user()->role }}">

</head>

<body>
    @include('layouts.dashboard_header')

    <div class="container-fluid page-body-wrapper d-flex" style="padding-top: 70px; margin-right: 500px;">
        @include('layouts.dashboard_sidebar')

        <div class="main-content flex-grow-1">
            @yield('dashboard_content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Include the main.js script -->
    <script src="{{ asset('js/main.js') }}"></script>
    @stack('scripts')
</body>

</html>