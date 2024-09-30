@php
    $user = Auth::user();
    $userRole = $user->role ?? null;
    $userFeatures = $userRole ? $userRole->features->pluck('feature')->toArray() : []; // Fetch all feature names
    $isSuperAdmin = !$userRole;
@endphp

<nav class="sidebar sidebar-offcanvas" id="sidebar" style="border-right: 2px solid #ccc;">
    <!-- Username Section -->
    <div class="nav-item p-3 border-bottom d-flex align-items-center" style="margin-top: 23px;">
        <img src="{{ asset('images/icons/user-icon.svg') }}" alt="User Icon" class="menu-icon"
            style="width: 20px; height: 20px; margin-left: 16px; margin-right: 10px; margin-bottom: 12px">
        <span class="menu-title" style="font-size: inherit; margin-bottom: 12px">{{ $user->name }}</span>
    </div>

    <!-- Menu Items -->
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center {{ request()->routeIs('home') ? 'active' : '' }}"
                href="{{ url('/') }}">
                <img src="{{ asset('images/icons/dashboard-icon.png') }}" alt="Dashboard Icon"
                    class="menu-icon icon-hover me-3" style="width: 20px; height: 20px; margin-right: 10px;">
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <!-- Inventory Management -->
        @if($isSuperAdmin || in_array('Inventory Management', $userFeatures))
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center dropdown-toggle {{ request()->is('inventory*') ? 'active' : '' }}"
                    href="#" role="button" data-bs-toggle="collapse" data-bs-target="#inventorySubmenu"
                    aria-expanded="{{ request()->is('inventory*') ? 'true' : 'false' }}">
                    <img src="{{ asset('images/icons/inventory-icon.svg') }}" alt="Inventory Icon" class="menu-icon"
                        style="width: 20px; height: 20px; margin-right: 10px;">
                    <span class="menu-title">Inventory Management</span>
                    <i class="arrow-icon ms-auto"></i>
                </a>
                <ul id="inventorySubmenu" class="collapse submenu {{ request()->is('inventory*') ? 'show' : '' }}">
                    <li class="nav-item dashboard-list">
                        <a class="nav-link {{ request()->is('inventory/list') ? 'submenu-active' : '' }}" href="#">Inventory
                            List</a>
                    </li>
                    <li class="nav-item dashboard-list">
                        <a class="nav-link {{ request()->is('inventory/transfer') ? 'submenu-active' : '' }}"
                            href="#">Inventory Transfer</a>
                    </li>
                    <li class="nav-item dashboard-list">
                        <a class="nav-link {{ request()->is('inventory/withdrawal') ? 'submenu-active' : '' }}"
                            href="#">Withdrawal Request</a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- Equipment & Asset -->
        @if($isSuperAdmin || in_array('Equipment & Asset', $userFeatures))
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center dropdown-toggle {{ request()->is('equipment*') ? 'active' : '' }}"
                    href="#" role="button" data-bs-toggle="collapse" data-bs-target="#equipmentSubmenu"
                    aria-expanded="{{ request()->is('equipment*') ? 'true' : 'false' }}">
                    <img src="{{ asset('images/icons/equipment-icon.svg') }}" alt="Equipment Icon" class="menu-icon"
                        style="width: 20px; height: 20px; margin-right: 10px;">
                    <span class="menu-title">Equipment & Asset</span>
                    <i class="arrow-icon ms-auto"></i>
                </a>
                <ul id="equipmentSubmenu" class="collapse submenu {{ request()->is('equipment*') ? 'show' : '' }}">
                    <li class="nav-item dashboard-list">
                        <a class="nav-link {{ request()->is('equipment/new') ? 'submenu-active' : '' }}" href="#">New
                            Asset</a>
                    </li>
                    <li class="nav-item dashboard-list">
                        <a class="nav-link {{ request()->is('equipment/transfer') ? 'submenu-active' : '' }}"
                            href="#">Transfer Asset</a>
                    </li>
                    <li class="nav-item dashboard-list">
                        <a class="nav-link {{ request()->is('equipment/disposal') ? 'submenu-active' : '' }}"
                            href="#">Disposal Asset</a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- Procurement -->
        @if($isSuperAdmin || in_array('Procurement', $userFeatures))
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center dropdown-toggle {{ request()->is('procurement*') ? 'active' : '' }}"
                    href="#" role="button" data-bs-toggle="collapse" data-bs-target="#procurementSubmenu"
                    aria-expanded="{{ request()->is('procurement*') ? 'true' : 'false' }}">
                    <img src="{{ asset('images/icons/procurement-icon.svg') }}" alt="Procurement Icon" class="menu-icon"
                        style="width: 20px; height: 20px; margin-right: 10px;">
                    <span class="menu-title">Procurement</span>
                    <i class="arrow-icon ms-auto"></i>
                </a>
                <ul id="procurementSubmenu" class="collapse submenu {{ request()->is('procurement*') ? 'show' : '' }}">
                    <li class="nav-item dashboard-list">
                        <a class="nav-link {{ request()->is('procurement/purchase-request') ? 'submenu-active' : '' }}"
                            href="#">Purchased Request</a>
                    </li>
                    <li class="nav-item dashboard-list">
                        <a class="nav-link {{ request()->is('procurement/canvassing') ? 'submenu-active' : '' }}"
                            href="#">Canvassing</a>
                    </li>
                    <li class="nav-item dashboard-list">
                        <a class="nav-link {{ request()->is('procurement/order') ? 'submenu-active' : '' }}"
                            href="#">Purchased Order</a>
                    </li>
                    <li class="nav-item dashboard-list">
                        <a class="nav-link {{ request()->is('procurement/approval') ? 'submenu-active' : '' }}"
                            href="#">Approval Status</a>
                    </li>
                    <li class="nav-item dashboard-list">
                        <a class="nav-link {{ request()->is('procurement/vendor') ? 'submenu-active' : '' }}"
                            href="#">Vendor Management</a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- Settings -->
        @if($isSuperAdmin || in_array('Settings', $userFeatures))
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center dropdown-toggle {{ request()->is('settings*') ? 'active' : '' }}"
                    href="#" role="button" data-bs-toggle="collapse" data-bs-target="#settingsSubmenu"
                    aria-expanded="{{ request()->is('settings*') ? 'true' : 'false' }}">
                    <img src="{{ asset('images/icons/setting-icon.svg') }}" alt="Settings Icon" class="menu-icon"
                        style="width: 20px; height: 20px; margin-right: 10px;">
                    <span class="menu-title">Settings</span>
                    <i class="arrow-icon ms-auto"></i>
                </a>
                <ul id="settingsSubmenu" class="collapse submenu {{ request()->is('settings*') ? 'show' : '' }}">
                    <li class="nav-item dashboard-list">
                        <a class="nav-link {{ request()->is('settings/company') ? 'submenu-active' : '' }}"
                            href="#">Company</a>
                    </li>
                    <li class="nav-item dashboard-list">
                        <a class="nav-link {{ request()->is('settings/department') ? 'submenu-active' : '' }}"
                            href="#">Department</a>
                    </li>
                    <li class="nav-item dashboard-list">
                        <a class="nav-link {{ request()->is('settings/roles') ? 'submenu-active' : '' }}"
                            href="{{ route('settings.roles') }}">Role</a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- Report -->
        @if($isSuperAdmin || in_array('Report', $userFeatures))
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center" href="#">
                    <img src="{{ asset('images/icons/report-icon.svg') }}" alt="Report Icon" class="menu-icon"
                        style="width: 20px; height: 20px; margin-right: 10px;">
                    <span class="menu-title">Report</span>
                </a>
            </li>
        @endif
    </ul>
</nav>