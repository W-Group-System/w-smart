<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="shortcut icon" href="{{ asset('images/icons/icon-144x144.png') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vertical-layout-light/style.css') }}">

    <style>
        .nav-link.dropdown-toggle::after {
            content: none !important;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-light bg-white fixed-top shadow-sm"
        style="border-bottom: 3px solid #ccc; overflow: visible;">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <!-- Brand -->
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('images/logo.png') }}" alt="logo" style="max-width: 80px; height: auto;">
                <span class="ml-2" style="color: black; font-family: 'Inter', sans-serif; font-size: 20px;">W
                    Smart</span>
            </a>

            <!-- Profile Dropdown -->
            <ul class="navbar-nav mb-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle p-0" href="#" id="profileDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{ asset('images/dashboard/profile.png') }}" alt="profile" class="rounded-circle"
                            width="40" height="40" style="border: none;" />
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown"
                        style="z-index: 1050; position: absolute; top: 100%; right: 0;">
                        <a class="dropdown-item" href="#">
                            <i class="ti-settings text-primary mr-2"></i>
                            Settings
                        </a>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="logout(); show();">
                            <i class="ti-power-off text-primary mr-2"></i>
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdYJ8qbOskQIW7BzOFx+UvnydWWr+PGY8xnYjdjfbjgQgB03kXKefcFum2nJgr"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6mnf6cnydrs0ufZ80x1MWtEC+9eI3ZPqvycuFTRaFw7vRg63f"
        crossorigin="anonymous"></script>
    <script>
        function logout() {
            event.preventDefault();
            document.getElementById('logout-form').submit();
        }    
    function show() {
            document.getElementById("loader").style.display = "block";
        }
    </script>
</body>

</html>