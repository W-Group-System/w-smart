<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    @laravelPWA
    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    {{-- <script src="{{ asset('js/internetAlert.js') }}" defer></script> --}}
    <link rel="shortcut icon" href="{{ asset('images/icons/icon-144x144.png') }}">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com" defer>
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{ asset('/body_css/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('/body_css/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('/body_css/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('/body_css/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('/body_css/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/body_css/js/select.dataTables.min.css') }}">
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('/body_css/vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/body_css/vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.6/dist/sweetalert2.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('/body_css/css/vertical-layout-light/style.css') }}">
    @yield('css')

    <style>
      .loader {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('images/loader.gif') }}") 50% 50% no-repeat white;
        opacity: .8;
        background-size: 120px 120px;
      }
    </style>
</head>
<body>
  <div id="loader" style="display:none;" class="loader"></div>
    <div class="container-scroller">
       
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
          <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
            <a class="navbar-brand brand-logo me-5" href="{{url('/')}}"><img src="{{ asset('images/logo.png') }}" class="me-2" alt="logo" style="height:auto;max-height:60px"/></a>
            <a class="navbar-brand brand-logo-mini" href="{{url('/')}}"><img src="{{ asset('images/logo.png') }}" alt="logo"/></a>
          </div>
          <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="icon-menu"></span>
            </button>
            <ul class="navbar-nav navbar-nav-right">
              <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                  <img src="{{ asset('images/no_image.png') }}" alt="profile"/>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                  <a class="dropdown-item">
                    <i class="ti-settings text-primary"></i>
                    Settings
                  </a>
                  <a class="dropdown-item" href="{{ route('logout') }}" onclick="logout(); show();">
                    <i class="ti-power-off text-primary"></i>
                    Logout
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
                </div>
              </li>
            
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
              <span class="icon-menu"></span>
            </button>
          </div>
        </nav> 
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <li class="nav-item {{ Route::current()->getName() == "home" || "" ? "active" : "" }}"  >
                    <a class="nav-link"  href="{{url('/')}}" onclick='show()'>
                        <i class="icon-grid menu-icon"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    @if(checkModule(auth()->user()->role, 'Inventory Management'))
                    <a class="nav-link" data-toggle="collapse" href="#inventory">
                        <i class="ti-clipboard menu-icon"></i>
                        <span class="menu-title">Inventory Management</span>
                        <i class="menu-arrow"></i>
                    </a>
                    @endif
                    {{-- @dd(checkRoles(auth()->user()->role, 'Inventory List')) --}}
                    <div class="collapse" id="inventory">
                        <ul class="nav flex-column sub-menu">
                            @if(checkRoles(auth()->user()->role, 'Inventory List'))
                            <li class="nav-item dashboard-list">
                                <a class="nav-link"
                                    href="{{url('inventory/inventory_list')}}">Inventory List</a>
                            </li>
                            @endif
                            @if(checkRoles(auth()->user()->role, 'Inventory Transfer'))
                            <li class="nav-item dashboard-list">
                                <a class="nav-link"
                                    href="{{url('inventory/inventory_transfer')}}">
                                    Inventory Transfer
                                </a>
                            </li>
                            @endif
                            @if(checkRoles(auth()->user()->role, 'Withdrawal Request'))
                            <li class="nav-item dashboard-list" id="withdrawal-request-item">
                                <a class="nav-link"
                                    href="{{url('inventory/withdrawal')}}">
                                    Withdrawal Request
                                </a>
                            </li>
                            @endif
                            @if(checkRoles(auth()->user()->role, 'Returned Inventory'))
                            <li class="nav-item dashboard-list" id="returned-inventory-item">
                                <a class="nav-link"
                                    href="{{url('inventory/returned')}}">
                                    Returned Inventory
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    @if(checkModule(auth()->user()->role, 'Equipment & Asset'))
                    <a class="nav-link" data-toggle="collapse" href="#equipmentAndAssets">
                        <i class="ti-panel menu-icon"></i>
                        <span class="menu-title">Equipments & Assets</span>
                        <i class="menu-arrow"></i>
                    </a>
                    @endif
                    <div class="collapse" id="equipmentAndAssets">
                        <ul class="nav flex-column sub-menu">
                            @if(checkRoles(auth()->user()->role, 'Asset List'))
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="{{url('equipment/asset_list')}}">Asset List</a>
                            </li>
                            @endif
                            @if(checkRoles(auth()->user()->role, 'Transfer Asset'))
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="{{url('equipment/transfer_asset')}}">
                                    Transfer Asset
                                </a>
                            </li>
                            @endif
                            @if(checkRoles(auth()->user()->role,'Disposal Asset'))
                            <li class="nav-item" id="withdrawal-request-item">
                                <a class="nav-link"
                                    href="{{url('equipment/disposal_asset')}}">
                                    Disposal Asset
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    @if(checkModule(auth()->user()->role, 'Procurement'))
                    <a class="nav-link" data-toggle="collapse" href="#procurement">
                        <i class="ti-briefcase menu-icon"></i>
                        <span class="menu-title">Procurement</span>
                        <i class="menu-arrow"></i>
                    </a>
                    @endif
                    <div class="collapse" id="procurement">
                        <ul class="nav flex-column sub-menu">
                            @if(checkRoles(auth()->user()->role, 'Purchased Request'))
                            <li class="nav-item dashboard-list">
                                <a class="nav-link" href="{{url('procurement/purchase-request')}}">Purchased Request</a>
                            </li>
                            @endif
                            @if(checkRoles(auth()->user()->role, 'For Approval'))
                            <li class="nav-item dashboard-list">
                                <a class="nav-link" href="{{url('procurement/for-approval-pr')}}">For Approval</a>
                            </li>
                            @endif
                            {{-- <li class="nav-item dashboard-list" id="canvassing-item">
                                <a class="nav-link {{ request()->is('procurement/canvassing') ? 'submenu-active' : '' }}" href="{{route('procurement.canvassing')}}">Canvassing</a>
                            </li> --}}
                            @if(checkRoles(auth()->user()->role, 'Purchased Order'))
                            <li class="nav-item dashboard-list">
                                <a class="nav-link" href="{{url('procurement/purchase-order')}}">Purchased Order</a>
                            </li>
                            @endif
                            @if(checkRoles(auth()->user()->role, 'Supplier Accreditation'))
                            <li class="nav-item dashboard-list">
                                <a class="nav-link" href="{{url('procurement/supplier_accreditation')}}">Supplier Accreditation</a>
                            </li>
                            @endif
                            @if(checkRoles(auth()->user()->role, 'Supplier Evaluation'))
                            <li class="nav-item dashboard-list" id="supplier-evaluation-item">
                                <a class="nav-link" href="{{url('procurement/supplier_evaluation')}}">Supplier Evaluation</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    @if(checkModule(auth()->user()->role, 'Settings'))
                    <a class="nav-link" data-toggle="collapse" href="#settings">
                        <i class="icon-cog menu-icon"></i>
                        <span class="menu-title">Settings</span>
                        <i class="menu-arrow"></i>
                    </a>
                    @endif
                    <div class="collapse" id="settings">
                        <ul class="nav flex-column sub-menu">
                            @if(checkRoles(auth()->user()->role, 'Company'))
                            <li class="nav-item dashboard-list" id="company-item">
                                <a class="nav-link" href="{{url('settings/company')}}">Company</a>
                            </li>
                            @endif
                            @if(checkRoles(auth()->user()->role, 'Department'))
                            <li class="nav-item dashboard-list" id="department-item">
                                <a class="nav-link" href="{{url('settings/department')}}">Department</a>
                            </li>
                            @endif
                            @if(checkRoles(auth()->user()->role, 'User Management'))
                            <li class="nav-item dashboard-list" id="user-item">
                                <a class="nav-link" href="{{url('settings/users')}}">User Management</a>
                            </li>
                            @endif
                            @if(checkRoles(auth()->user()->role, 'Vendor Management'))
                            <li class="nav-item dashboard-list" id="user-item">
                                <a class="nav-link" href="{{url('settings/vendors')}}">Vendor Management</a>
                            </li>
                            @endif
                            @if(checkRoles(auth()->user()->role, 'Role'))
                            <li class="nav-item dashboard-list" id="role-item">
                                <a class="nav-link" href="{{url('settings/roles')}}">Role</a>
                            </li>
                            @endif
                            @if(checkRoles(auth()->user()->role, 'Category'))
                            <li class="nav-item dashboard-list" id="category-item">
                                <a class="nav-link" href="{{url('settings/category')}}">Category</a>
                            </li>
                            @endif
                            @if(checkRoles(auth()->user()->role, 'UOMs'))
                            <li class="nav-item dashboard-list" id="uom-item">
                                <a class="nav-link" href="{{url('settings/uom')}}">UOMs</a>
                            </li>
                            @endif
                            {{-- @if(checkRoles(auth()->user()->role, 'UOMs')) --}}
                            <li class="nav-item dashboard-list" id="uom-item">
                                <a class="nav-link" href="{{url('settings/purchase_approver')}}">Purchase Approvers</a>
                            </li>
                            {{-- @endif --}}
                        </ul>
                    </div>
                </li>

            </ul>
            </nav>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                </div>
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
      </div>
     
      @include('sweetalert::alert')    
    <script>
        function logout() {
			event.preventDefault();
			document.getElementById('logout-form').submit();
		}    
    function show() {
			document.getElementById("loader").style.display = "block";
		}
    </script>
    <!-- plugins:js -->
    <script src="{{ asset('/body_css/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    {{-- <script src="{{ asset('/body_css/vendors/chart.js/Chart.min.js') }}"></script> --}}

    <script src="{{ asset('/body_css/vendors/select2/select2.min.js') }}"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->

    <!-- endinject -->
    <!-- Custom js for this page-->
    {{-- <script src="{{ asset('/body_css/js/dashboard.js') }}"></script> --}}
    <script src="{{ asset('/body_css/js/select2.js') }}"></script>

    <script src="{{ asset('/body_css/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('/body_css/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('/body_css/js/dataTables.select.min.js') }}"></script>

    <script src="{{ asset('/body_css/vendors/jquery.repeater/jquery.repeater.min.js') }}"></script>

    <script src="{{ asset('/body_css/js/off-canvas.js') }}"></script>
    <script src="{{ asset('/body_css/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('/body_css/js/template.js') }}"></script>
    <script src="{{ asset('/body_css/js/settings.js') }}"></script>
    <script src="{{ asset('/body_css/js/todolist.js') }}"></script>

    <script src="{{ asset('/body_css/js/tabs.js') }}"></script>
    <script src="{{ asset('/body_css/js/form-repeater.js') }}"></script>
    <script src="{{ asset('/body_css/vendors/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ asset('/body_css/vendors/inputmask/jquery.inputmask.bundle.js') }}"></script>
    <script src="{{ asset('/body_css/vendors/inputmask/jquery.inputmask.bundle.js') }}"></script>
    <script src="{{ asset('/body_css/js/inputmask.js') }}"></script>
    <script>
        function get_min(value)
        {
            document.getElementById("to").min = value;
        }
    </script>
    @yield('js')
</body>
</html>
