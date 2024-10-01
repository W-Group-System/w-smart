<div class="container-fluid py-3">
    <div class="row">
        <div class="col-md-6">
            <h5 class="fw-bold">Inventory Management</h5>
            <nav aria-label="breadcrumb" class="mt-1">
                <div class="breadcrumb-text d-inline">
                    <span>Inventory Management</span>
                    <span class="bullet-separator">•</span>
                    <span>Inventory List</span>
                </div>
            </nav>
        </div>
    </div>

    <div class="row align-items-center mb-4">
        <div class="col-lg-4 col-md-6">
            <form class="d-flex gap-2 align-items-center">
                <label class="fw-bold me-2" for="start-date">From</label>
                <div class="input-group" style="border-radius: 10px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                    <input type="date" class="form-control" id="start-date" placeholder="dd/mm/yyyy"
                        aria-label="Start Date"
                        style="border-radius: 10px; font-size: 1.1rem; padding: 0.75rem 0.75rem;">
                </div>
                <label class="fw-bold me-2" for="end-date">To</label>
                <div class="input-group" style="border-radius: 10px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                    <input type="date" class="form-control" id="end-date" placeholder="dd/mm/yyyy" aria-label="End Date"
                        style="border-radius: 10px; font-size: 1.1rem; padding: 0.75rem 0.75rem;">
                </div>
                <button type="submit" class="btn btn-primary ms-2"
                    style="min-width: 120px; width: 100%; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                    Submit
                </button>
            </form>
        </div>

        <div class="col-lg-8 col-md-6 d-flex justify-content-end">
            <div class="card text-center me-2" style="min-width: 150px;">
                <div class="card-body">
                    <h6 class="card-title">Transfer</h6>
                    <h3 class="card-text fw-bold">0</h3>
                    <a href="#" class="btn btn-primary btn-sm">View All</a>
                </div>
            </div>

            <div class="card text-center" style="min-width: 150px;">
                <div class="card-body">
                    <h6 class="card-title">Withdrawal</h6>
                    <h3 class="card-text fw-bold">0</h3>
                    <a href="#" class="btn btn-primary btn-sm">View All</a>
                </div>
            </div>
        </div>
    </div>
</div>