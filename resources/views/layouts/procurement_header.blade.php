<div class="container-fluid py-3">
    <input type="hidden" id="userRole" value="{{ auth()->user()->role }}">
    <input type="hidden" id="userName" value="{{ auth()->user()->name }}">
    <input type="hidden" id="userSubsidiary" value="{{ auth()->user()->subsidiary }}">
    <div class="row">
        <div class="col-md-6">
            <h5 class="fw-bold">Procurement</h5>
            <nav aria-label="breadcrumb" class="mt-1">
                <div class="breadcrumb-text d-inline">
                    <span>Procurement</span>
                    <span class="bullet-separator">•</span>
                    <span>
                        @if (Request::is('procurement/purchase-request'))
                            Purchase Request
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
                            @if (Request::is('procurement/purchase-request'))
                                Pending
                            @endif
                        </h6>
                        @if (Request::is('procurement/purchase-request'))
                        <h3 class="card-text fw-bold mb-0">{{count($purchase_requests->where('status','Pending'))}}</h3>
                        @else
                        <h3 class="card-text fw-bold mb-0">0</h3>
                        @endif
                    </div>
                    <a href="#" id="viewTable" class="btn btn-primary btn-sm" style="min-width: 110px; border-radius: 7px;">View
                        All</a>
                </div>
            </div>

            <!-- Withdrawal Card -->
            <div class="card shadow-sm"
                style="flex: 1 1 220px; padding: 15px; border-radius: 10px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); margin-right: 15px;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="text-center">
                        <h6 class="card-title mb-3">
                            @if (Request::is('procurement/purchase-request'))
                                RFQ
                            @endif
                        </h6>
                        <h3 class="card-text fw-bold mb-0">0</h3>
                    </div>
                    <a href="#" id="viewTable2" class="btn btn-primary btn-sm" style="min-width: 110px; border-radius: 7px;">View
                        All</a>
                </div>
            </div>
            
            <!-- Withdrawal Card -->
            <div class="card shadow-sm"
                style="flex: 1 1 220px; padding: 15px; border-radius: 10px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="text-center">
                        <h6 class="card-title mb-3">
                            @if (Request::is('procurement/purchase-request'))
                                Closed
                            @endif
                        </h6>
                        <h3 class="card-text fw-bold mb-0">0</h3>
                    </div>
                    <a href="#" id="viewTable2" class="btn btn-primary btn-sm" style="min-width: 110px; border-radius: 7px;">View
                        All</a>
                </div>
            </div>
        </div>
    </div>
</div>