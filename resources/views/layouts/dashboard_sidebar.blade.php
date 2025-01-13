<nav class="sidebar sidebar-offcanvas" id="sidebar" style="border-right: 2px solid #ccc;">
    <div class="nav-item p-3 border-bottom d-flex align-items-center" style="margin-top: 23px;">
        <img src="{{ asset('images/icons/user-icon.svg') }}" alt="User Icon" class="menu-icon"
            style="width: 20px; height: 20px; margin-left: 16px; margin-right: 10px; margin-bottom: 12px">
        <span class="menu-title" style="font-size: inherit; margin-bottom: 12px">{{ Auth::user()->name }}</span>
    </div>

    <ul class="nav flex-column">
        <!-- Dashboard -->
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center {{ request()->routeIs('home') ? 'active' : '' }}"
                href="{{ url('/') }}">
                <img src="{{ asset('images/icons/dashboard-icon.png') }}" alt="Dashboard Icon"
                    class="menu-icon icon-hover me-3" style="width: 20px; height: 20px; margin-right: 10px;">
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <!-- Inventory Management -->
        <li class="nav-item" id="inventory-menu" style="display: none;">
            <a class="nav-link d-flex align-items-center dropdown-toggle {{ request()->is('inventory*') ? 'active' : '' }}"
                href="#" role="button" id="inventoryToggle">
                <img src="{{ asset('images/icons/inventory-icon.svg') }}" alt="Inventory Icon" class="menu-icon"
                    style="width: 20px; height: 20px; margin-right: 10px;">
                <span class="menu-title">Inventory Management</span>
                <i class="arrow-icon ms-auto"></i>
            </a>
            <ul id="inventorySubmenu" class="collapse submenu {{ request()->is('inventory*') ? 'show' : '' }}">
                <li class="nav-item dashboard-list" id="inventory-list-item" style="display: none;">
                    <a class="nav-link {{ request()->is('inventory/list') ? 'submenu-active' : '' }}"
                        href="{{ route('inventory.list') }}">Inventory List</a>
                </li>
                <li class="nav-item dashboard-list" id="inventory-transfer-item" style="display: none;">
                    <a class="nav-link {{ request()->is('inventory/transfer') ? 'submenu-active' : '' }}"
                        href="{{ route('inventory.transfer') }}">
                        Inventory Transfer
                    </a>
                </li>
                <li class="nav-item dashboard-list" id="withdrawal-request-item" style="display: none;">
                    <a class="nav-link {{ request()->is('inventory/withdrawal') ? 'submenu-active' : '' }}"
                        href="{{ route('inventory.withdrawal') }}">
                        Withdrawal Request
                    </a>
                </li>
                <li class="nav-item dashboard-list" id="returned-inventory-item" style="display: none;">
                    <a class="nav-link {{ request()->is('inventory/returned') ? 'submenu-active' : '' }}"
                        href="{{ route('inventory.returned') }}">
                        Returned Inventory
                    </a>
                </li>
            </ul>
        </li>

        <!-- Equipment & Asset -->
        <li class="nav-item" id="equipment-menu" style="display: none;">
            <a class="nav-link d-flex align-items-center dropdown-toggle {{ request()->is('equipment*') ? 'active' : '' }}"
                href="#" role="button" id="equipmentToggle">
                <img src="{{ asset('images/icons/equipment-icon.svg') }}" alt="Equipment Icon" class="menu-icon"
                    style="width: 20px; height: 20px; margin-right: 10px;">
                <span class="menu-title">Equipment & Asset</span>
                <i class="arrow-icon ms-auto"></i>
            </a>
            <ul id="equipmentSubmenu" class="collapse submenu {{ request()->is('equipment*') ? 'show' : '' }}">
                <li class="nav-item dashboard-list" id="new-asset-item" style="display: none;">
                    <a class="nav-link {{ request()->is('equipment/list') ? 'submenu-active' : '' }}" href="{{ route('equipment.list') }}">Asset List</a>
                </li>
                <li class="nav-item dashboard-list" id="transfer-asset-item" style="display: none;">
                    <a class="nav-link {{ request()->is('equipment/transfer') ? 'submenu-active' : '' }}" href="{{ route('equipment.transfer') }}">Transfer Asset</a>
                </li>
                <li class="nav-item dashboard-list" id="disposal-asset-item" style="display: none;">
                    <a class="nav-link {{ request()->is('equipment/disposal') ? 'submenu-active' : '' }}" href="{{ route('equipment.disposal') }}">Disposal Asset</a>
                </li>
            </ul>
        </li>

        <!-- Procurement -->
        <li class="nav-item" id="procurement-menu" style="display: none;">
            <a class="nav-link d-flex align-items-center dropdown-toggle {{ request()->is('procurement*') ? 'active' : '' }}"
                href="#" role="button" id="procurementToggle">
                <img src="{{ asset('images/icons/procurement-icon.svg') }}" alt="Procurement Icon" class="menu-icon"
                    style="width: 20px; height: 20px; margin-right: 10px;">
                <span class="menu-title">Procurement</span>
                <i class="arrow-icon ms-auto"></i>
            </a>
            <ul id="procurementSubmenu" class="collapse submenu {{ request()->is('procurement*') ? 'show' : '' }}">
                <li class="nav-item dashboard-list" id="purchase-request-item" style="display: none;">
                    <a class="nav-link {{ request()->is('procurement/purchase-request') ? 'submenu-active' : '' }}" href="{{route('procurement.purchase_request')}}">Purchased Request</a>
                </li>
                <li class="nav-item dashboard-list" id="" style="display: none;">
                    <a class="nav-link {{ request()->is('procurement/for-approval-pr') ? 'submenu-active' : '' }}" href="{{route('procurement.for_approval_pr')}}">For Approval Purchase Request</a>
                </li>
                <li class="nav-item dashboard-list" id="canvassing-item" style="display: none;">
                    <a class="nav-link {{ request()->is('procurement/canvassing') ? 'submenu-active' : '' }}" href="{{route('procurement.canvassing')}}">Canvassing</a>
                </li>
                <li class="nav-item dashboard-list" id="purchase-order-item" style="display: none;">
                    <a class="nav-link {{ request()->is('procurement/purchase-order') ? 'submenu-active' : '' }}" href="{{route('procurement.purchase_order')}}">Purchased Order</a>
                </li>
            </ul>
        </li>

        <!-- Settings -->
        <li class="nav-item" id="settings-menu" style="display: none;">
            <a class="nav-link d-flex align-items-center dropdown-toggle {{ request()->is('settings*') ? 'active' : '' }}"
                href="#" role="button" id="settingsToggle">
                <img src="{{ asset('images/icons/setting-icon.svg') }}" alt="Settings Icon" class="menu-icon"
                    style="width: 20px; height: 20px; margin-right: 10px;">
                <span class="menu-title">Settings</span>
                <i class="arrow-icon ms-auto"></i>
            </a>
            <ul id="settingsSubmenu" class="collapse submenu {{ request()->is('settings*') ? 'show' : '' }}">
                <li class="nav-item dashboard-list" id="company-item" style="display: none;">
                    <a class="nav-link {{ request()->is('settings/company') ? 'submenu-active' : '' }}" href="{{ route('settings.company') }}">Company</a>
                </li>
                <li class="nav-item dashboard-list" id="department-item" style="display: none;">
                    <a class="nav-link {{ request()->is('settings/department') ? 'submenu-active' : '' }}" href="{{route('settings.department')}}">Department</a>
                </li>
                <li class="nav-item dashboard-list" id="user-item">
                    <a class="nav-link {{ request()->is('settings/users') ? 'submenu-active' : '' }}" href="{{ route('settings.users') }}">User Management</a>
                </li>
                <li class="nav-item dashboard-list" id="user-item">
                    <a class="nav-link {{ request()->is('settings/vendors') ? 'submenu-active' : '' }}" href="{{ route('settings.vendors') }}">Vendor Management</a>
                </li>
                <li class="nav-item dashboard-list" id="role-item" style="display: none;">
                    <a class="nav-link {{ request()->is('settings/roles') ? 'submenu-active' : '' }}" href="{{ route('settings.roles') }}">Role</a>
                </li>
                <li class="nav-item dashboard-list" id="category-item" style="display: none;">
                    <a class="nav-link {{ request()->is('category') ? 'submenu-active' : '' }}" href="{{ route('category') }}">Category</a>
                </li>
                <li class="nav-item dashboard-list" id="uom-item" style="display: none;">
                    <a class="nav-link {{ request()->is('settings/uom') ? 'submenu-active' : '' }}" href="{{ route('settings.uom') }}">UOMs</a>
                </li>
            </ul>
        </li>

        <!-- Report -->
        <li class="nav-item" id="report-menu" style="display: none;">
            <a class="nav-link d-flex align-items-center" href="#">
                <img src="{{ asset('images/icons/report-icon.svg') }}" alt="Report Icon" class="menu-icon"
                    style="width: 20px; height: 20px; margin-right: 10px;">
                <span class="menu-title">Report</span>
            </a>
            <ul id="reportSubmenu" class="collapse submenu">
                <li class="nav-item dashboard-list" id="summary-report-item" style="display: none;">
                    <a class="nav-link" href="#">Summary Report</a>
                </li>
                <li class="nav-item dashboard-list" id="detailed-report-item" style="display: none;">
                    <a class="nav-link" href="#">Detailed Report</a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
