{{-- @extends('layouts.header_admin')
@section('css')
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h4 class="mb-4">Today's Statistics</h4>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="statistics">
                        <div class="icon text-primary">
                            <i class="icon-bar-graph"></i>
                        </div>
                        <div class="numbers">
                            <p class="card-category">Total Stock Value</p>
                            <h3 class="card-title">95,390 K</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="statistics">
                        <div class="icon text-primary">
                            <i class="icon-user"></i>
                        </div>
                        <div class="numbers">
                            <p class="card-category">Total Inbound SKUs</p>
                            <h3 class="card-title">10</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Warehouse Stock Value</h5>
                    <p class="text-muted">Last updated just now</p>
                </div>
                <div class="card-body">
                    <canvas id="stockChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Inventory Summary</h5>
                    <p class="text-muted">Last 6 months</p>
                </div>
                <div class="card-body">
                    <canvas id="inventorySummaryChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var ctx1 = document.getElementById('stockChart').getContext('2d');
    var stockChart = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: ['Finished Goods', 'Stocks', 'WIP'],
            datasets: [{
                label: 'Stock Value (K)',
                data: [30, 20, 10],
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc']
            }]
        }
    });

    var ctx2 = document.getElementById('inventorySummaryChart').getContext('2d');
    var inventoryChart = new Chart(ctx2, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Inventory Value (K)',
                data: [220, 230, 250, 270, 290, 310],
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                borderColor: '#4e73df',
                fill: true
            }]
        }
    });
</script>
@endsection

@section('js')
<script src="{{ asset('admin/js/inspinia.js')}}"></script>
<script src="{{ asset('admin/js/plugins/pace/pace.min.js')}}"></script>
@endsection --}}

@extends('layouts.header')
@section('content')
    
@endsection