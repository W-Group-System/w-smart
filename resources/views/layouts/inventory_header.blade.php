<div class="container-fluid py-3">
    <div class="row">
        <div class="col-md-6">
            <h5 class="fw-bold">Inventory Management</h5>
            <nav aria-label="breadcrumb" class="mt-1">
                <div class="breadcrumb-text d-inline">
                    <span>Inventory Management</span>
                    <span class="bullet-separator">•</span>
                    <span>
                        @if (Request::is('inventory/list'))
                            Inventory List
                        @elseif (Request::is('inventory/transfer'))
                            Inventory Transfer
                        @elseif (Request::is('inventory/withdrawal'))
                            Withdrawal Request
                        @elseif (Request::is('inventory/returned'))
                            Returned Inventory
                        @endif
                    </span>
                </div>
            </nav>
        </div>
    </div>

    <div class="row align-items-center mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center flex-wrap">
            <form class="d-flex gap-2 align-items-center me-3" style="flex-shrink: 0; flex-basis: 400px;"
                id="filter-submit">
                <label class="fw-bold me-2" for="start-date">From</label>
                <div class="input-group" style="border-radius: 10px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                    <input type="date" class="form-control" id="start-date" placeholder="dd/mm/yyyy"
                        aria-label="Start Date" style="border-radius: 10px; font-size: 1rem; padding: 0.5rem 0.5rem;">
                </div>
                <label class="fw-bold me-2" for="end-date">To</label>
                <div class="input-group" style="border-radius: 10px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                    <input type="date" class="form-control" id="end-date" placeholder="dd/mm/yyyy" aria-label="End Date"
                        style="border-radius: 10px; font-size: 1rem; padding: 0.5rem 0.5rem;">
                </div>
                <button type="submit" class="btn btn-primary ms-2"
                    style="min-width: 120px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                    Submit
                </button>
            </form>

            <!-- Transfer Card -->
            <div class="card shadow-sm"
                style="flex: 1 1 220px; padding: 15px; border-radius: 10px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); margin-right: 15px;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="text-center">
                        <h6 class="card-title mb-3">
                            @if (Request::is('inventory/transfer') || Request::is('inventory/withdrawal') || Request::is('inventory/returned'))
                                Pending
                            @else
                                Transfer
                            @endif
                        </h6>
                        <h3 class="card-text fw-bold mb-0">0</h3>
                    </div>
                    <a href="#" class="btn btn-primary btn-sm" style="min-width: 110px; border-radius: 7px;">View
                        All</a>
                </div>
            </div>

            <!-- Withdrawal Card -->
            <div class="card shadow-sm"
                style="flex: 1 1 220px; padding: 15px; border-radius: 10px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="text-center">
                        <h6 class="card-title mb-3">
                            @if (Request::is('inventory/transfer') || Request::is('inventory/withdrawal') || Request::is('inventory/returned'))
                                Active
                            @else
                                Withdrawal
                            @endif
                        </h6>
                        <h3 class="card-text fw-bold mb-0">0</h3>
                    </div>
                    <a href="#" class="btn btn-primary btn-sm" style="min-width: 110px; border-radius: 7px;">View
                        All</a>
                </div>
            </div>
        </div>
    </div>
</div>