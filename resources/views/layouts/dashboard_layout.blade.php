<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoYzg6Fx34nB5EYfBbBrPbYjZ6aGmGNkGKMnN5f2Xv1wQ" crossorigin="anonymous">

    <!-- Your Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>

<body>
    @include('layouts.dashboard_header')

    <div class="container-fluid page-body-wrapper d-flex" style="padding-top: 70px; margin-right: 500px;">
        @include('layouts.dashboard_sidebar')

        <div class="main-content flex-grow-1">
            @yield('dashboard_content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+JUM8G3E5VvZ5qZPZKL13hZ63mJo0" crossorigin="anonymous">
        </script>

    <script src="{{ asset('js/main.js') }}"></script>
    @stack('scripts')
</body>

</html>