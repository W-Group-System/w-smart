<nav class="sidebar sidebar-offcanvas" id="sidebar" style="border-right: 2px solid #ccc;">
    <!-- Username Section -->
    <div class="nav-item p-3 border-bottom d-flex align-items-center" style="margin-top: 23px;">
        <img src="{{ asset('images/icons/user-icon.svg') }}" alt="User Icon" class="menu-icon"
            style="width: 20px; height: 20px; margin-left: 16px; margin-right: 10px; margin-bottom: 12px">
        <span class="menu-title" style="font-size: inherit; margin-bottom: 12px">User Name Here</span>
    </div>

    <!-- Menu Items -->
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center" href="#">
                <img src="{{ asset('images/icons/dashboard-icon.png') }}" alt="Dashboard Icon"
                    class="menu-icon icon-hover me-3" style="width: 20px; height: 20px; margin-right: 10px;">
                <span class="menu-title icon-hover">Dashboard</span>
            </a>
        </li>

        <!-- Inventory Dropdown -->
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center dropdown-toggle" href="#" role="button"
                data-bs-toggle="collapse" data-bs-target="#inventorySubmenu" aria-expanded="false"
                aria-controls="inventorySubmenu">
                <img src="{{ asset('images/icons/inventory-icon.svg') }}" alt="Inventory Icon" class="menu-icon"
                    style="width: 20px; height: 20px; margin-right: 10px;">
                <span class="menu-title">Inventory Management</span>
                <i class="arrow-icon ms-auto"></i>
            </a>
            <ul id="inventorySubmenu" class="collapse submenu">
                <li class="nav-item dashboard-list">
                    <a class="nav-link" href="#">Inventory List</a>
                </li>
                <li class="nav-item dashboard-list">
                    <a class="nav-link" href="#">Inventory Transfer</a>
                </li>
                <li class="nav-item dashboard-list">
                    <a class="nav-link" href="#">Withdrawal Request</a>
                </li>
            </ul>
        </li>

        <!-- Equipment & Asset Dropdown -->
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center dropdown-toggle" href="#" role="button"
                data-bs-toggle="collapse" data-bs-target="#equipmentSubmenu" aria-expanded="false"
                aria-controls="equipmentSubmenu">
                <img src="{{ asset('images/icons/equipment-icon.svg') }}" alt="Equipment Icon" class="menu-icon"
                    style="width: 20px; height: 20px; margin-right: 10px;">
                <span class="menu-title">Equipment & Asset</span>
                <i class="arrow-icon ms-auto"></i>
            </a>
            <ul id="equipmentSubmenu" class="collapse submenu">
                <li class="nav-item dashboard-list">
                    <a class="nav-link" href="#">New Asset</a>
                </li>
                <li class="nav-item dashboard-list">
                    <a class="nav-link" href="#">Transfer Asset</a>
                </li>
                <li class="nav-item dashboard-list">
                    <a class="nav-link" href="#">Disposal Asset</a>
                </li>
            </ul>
        </li>

        <!-- Procurement Dropdown -->
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center dropdown-toggle" href="#" role="button"
                data-bs-toggle="collapse" data-bs-target="#procurementSubmenu" aria-expanded="false"
                aria-controls="procurementSubmenu">
                <img src="{{ asset('images/icons/procurement-icon.svg') }}" alt="Procurement Icon" class="menu-icon"
                    style="width: 20px; height: 20px; margin-right: 10px;">
                <span class="menu-title">Procurement</span>
                <i class="arrow-icon ms-auto"></i>
            </a>
            <ul id="procurementSubmenu" class="collapse submenu">
                <li class="nav-item dashboard-list">
                    <a class="nav-link" href="#">Purchased Request</a>
                </li>
                <li class="nav-item dashboard-list">
                    <a class="nav-link" href="#">Canvassing</a>
                </li>
                <li class="nav-item dashboard-list">
                    <a class="nav-link" href="#">Purchased Order</a>
                </li>
                <li class="nav-item dashboard-list">
                    <a class="nav-link" href="#">Approval Status</a>
                </li>
                <li class="nav-item dashboard-list">
                    <a class="nav-link" href="#">Vendor Management</a>
                </li>
            </ul>
        </li>

        <!-- Tenant Management Dropdown -->
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center dropdown-toggle" href="#" role="button"
                data-bs-toggle="collapse" data-bs-target="#tenantSubmenu" aria-expanded="false"
                aria-controls="tenantSubmenu">
                <img src="{{ asset('images/icons/tenant-icon.svg') }}" alt="Tenant Management Icon" class="menu-icon"
                    style="width: 20px; height: 20px; margin-right: 10px;">
                <span class="menu-title">Tenant Management</span>
                <i class="arrow-icon ms-auto"></i>
            </a>
            <ul id="tenantSubmenu" class="collapse submenu">
                <li class="nav-item dashboard-list">
                    <a class="nav-link" href="#">Leased Record</a>
                </li>
            </ul>
        </li>

        <!-- Settings Dropdown -->
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center dropdown-toggle" href="#" role="button"
                data-bs-toggle="collapse" data-bs-target="#settingsSubmenu" aria-expanded="false"
                aria-controls="settingsSubmenu">
                <img src="{{ asset('images/icons/setting-icon.svg') }}" alt="Settings Icon" class="menu-icon"
                    style="width: 20px; height: 20px; margin-right: 10px;">
                <span class="menu-title">Settings</span>
                <i class="arrow-icon ms-auto"></i>
            </a>
            <ul id="settingsSubmenu" class="collapse submenu">
                <li class="nav-item dashboard-list">
                    <a class="nav-link" href="#">Company</a>
                </li>
                <li class="nav-item dashboard-list">
                    <a class="nav-link" href="#">Department</a>
                </li>
                <li class="nav-item dashboard-list">
                    <a class="nav-link" href="#">Role</a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link d-flex align-items-center" href="#">
                <img src="{{ asset('images/icons/report-icon.svg') }}" alt="Report Icon" class="menu-icon"
                    style="width: 20px; height: 20px; margin-right: 10px;">
                <span class="menu-title">Report</span>
            </a>
        </li>
    </ul>
</nav>