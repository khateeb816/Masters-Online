@extends('layouts.app')

@section('title', 'Dashboard - ' . config('app.name'))

@section('content')
<!--Start Dashboard Content-->
<div class="card mt-3">
    <div class="card-content">
        <div class="row row-group m-0">
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                    <h5 class="text-white mb-0">{{ $totalOrders ?? 0 }} <span class="float-right"><i class="zmdi zmdi-shopping-cart"></i></span></h5>
                    <div class="progress my-3" style="height:3px;">
                        <div class="progress-bar" style="width:{{ min(($totalOrders ?? 0) / 100 * 100, 100) }}%"></div>
                    </div>
                    <p class="mb-0 text-white small-font">Total Orders <span class="float-right">+{{ $orderGrowth ?? 0 }}% <i class="zmdi zmdi-long-arrow-up"></i></span></p>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                    <h5 class="text-white mb-0">${{ number_format(($totalRevenue ?? 0) / 100, 2) }} <span class="float-right"><i class="zmdi zmdi-money"></i></span></h5>
                    <div class="progress my-3" style="height:3px;">
                        <div class="progress-bar" style="width:{{ min(($totalRevenue ?? 0) / 10000 * 100, 100) }}%"></div>
                    </div>
                    <p class="mb-0 text-white small-font">Total Revenue <span class="float-right">+{{ $revenueGrowth ?? 0 }}% <i class="zmdi zmdi-long-arrow-up"></i></span></p>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                    <h5 class="text-white mb-0">{{ $totalUsers ?? 0 }} <span class="float-right"><i class="zmdi zmdi-account-circle"></i></span></h5>
                    <div class="progress my-3" style="height:3px;">
                        <div class="progress-bar" style="width:{{ min(($totalUsers ?? 0) / 50 * 100, 100) }}%"></div>
                    </div>
                    <p class="mb-0 text-white small-font">Total Users <span class="float-right">+{{ $userGrowth ?? 0 }}% <i class="zmdi zmdi-long-arrow-up"></i></span></p>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                    <h5 class="text-white mb-0">{{ $totalProducts ?? 0 }} <span class="float-right"><i class="zmdi zmdi-inbox"></i></span></h5>
                    <div class="progress my-3" style="height:3px;">
                        <div class="progress-bar" style="width:{{ min(($totalProducts ?? 0) / 50 * 100, 100) }}%"></div>
                    </div>
                    <p class="mb-0 text-white small-font">Total Products <span class="float-right">+{{ $productGrowth ?? 0 }}% <i class="zmdi zmdi-long-arrow-up"></i></span></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-lg-8 col-xl-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="zmdi zmdi-chart mr-2"></i>Sales Analytics</h5>
                <div class="card-action">
                    <div class="dropdown">
                        <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
                            <i class="icon-options"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ route('orders') }}">View All Orders</a>
                            <a class="dropdown-item" href="{{ route('inventories') }}">View Products</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="javascript:void();">Export Data</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container-1">
                    <canvas id="chart1"></canvas>
                </div>
            </div>

            <div class="row m-0 row-group text-center border-top border-light-3">
                <div class="col-12 col-lg-4">
                    <div class="p-3">
                        <h5 class="mb-0">{{ $totalOrders ?? 0 }}</h5>
                        <small class="mb-0">Total Orders <span> <i class="zmdi zmdi-arrow-up"></i> {{ $orderGrowth ?? 0 }}%</span></small>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="p-3">
                        <h5 class="mb-0">${{ number_format(($totalRevenue ?? 0) / 100, 2) }}</h5>
                        <small class="mb-0">Total Revenue <span> <i class="zmdi zmdi-arrow-up"></i> {{ $revenueGrowth ?? 0 }}%</span></small>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="p-3">
                        <h5 class="mb-0">{{ $avgOrderValue ?? 0 }}</h5>
                        <small class="mb-0">Avg Order Value <span> <i class="zmdi zmdi-arrow-up"></i> {{ $avgOrderGrowth ?? 0 }}%</span></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4 col-xl-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="zmdi zmdi-pie-chart mr-2"></i>Order Status</h5>
                <div class="card-action">
                    <div class="dropdown">
                        <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
                            <i class="icon-options"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ route('orders') }}">View All Orders</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="javascript:void();">Export Report</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container-2">
                    <canvas id="chart2" class="w-100"></canvas>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-sm">
                    <tbody>
                        <tr>
                            <td><i class="zmdi zmdi-circle text-success mr-2"></i> Delivered</td>
                            <td>{{ $deliveredOrders ?? 0 }}</td>
                            <td>{{ $deliveredPercentage ?? 0 }}%</td>
                        </tr>
                        <tr>
                            <td><i class="zmdi zmdi-circle text-warning mr-2"></i> Processing</td>
                            <td>{{ $processingOrders ?? 0 }}</td>
                            <td>{{ $processingPercentage ?? 0 }}%</td>
                        </tr>
                        <tr>
                            <td><i class="zmdi zmdi-circle text-info mr-2"></i> Shipped</td>
                            <td>{{ $shippedOrders ?? 0 }}</td>
                            <td>{{ $shippedPercentage ?? 0 }}%</td>
                        </tr>
                        <tr>
                            <td><i class="zmdi zmdi-circle text-danger mr-2"></i> Cancelled</td>
                            <td>{{ $cancelledOrders ?? 0 }}</td>
                            <td>{{ $cancelledPercentage ?? 0 }}%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="zmdi zmdi-star mr-2"></i>Top Products</h5>
                <div class="card-action">
                    <a href="{{ route('inventories') }}" class="btn btn-primary btn-sm">View All</a>
                </div>
            </div>
            <div class="card-body">
                @if(isset($topProducts) && count($topProducts) > 0)
                    @foreach($topProducts as $product)
                    <div class="d-flex align-items-center mb-3">
                        <div class="mr-3">
                            @if($product->images)
                                @php
                                    $imageArray = json_decode($product->images, true);
                                    $firstImage = is_array($imageArray) ? $imageArray[0] : $product->images;
                                @endphp
                                <img src="{{ asset('uploads/' . $firstImage) }}" alt="{{ $product->name }}"
                                     class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                     style="width: 50px; height: 50px;">
                                    <i class="zmdi zmdi-inbox text-dark"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $product->name }}</h6>
                            <small class="text-dark">{{ $product->category->title ?? 'N/A' }}</small>
                        </div>
                        <div class="text-right">
                            <h6 class="mb-1">${{ number_format($product->price / 100, 2) }}</h6>
                            <small class="text-success">{{ $product->orderDetails->count() }} orders</small>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-4">
                        <i class="zmdi zmdi-inbox text-dark" style="font-size: 3rem;"></i>
                        <p class="text-dark mt-2">No products available</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="zmdi zmdi-time mr-2"></i>Recent Orders</h5>
                <div class="card-action">
                    <a href="{{ route('orders') }}" class="btn btn-primary btn-sm">View All</a>
                </div>
            </div>
            <div class="card-body">
                @if(isset($recentOrders) && count($recentOrders) > 0)
                    @foreach($recentOrders as $order)
                    <div class="d-flex align-items-center mb-3">
                        <div class="mr-3">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center"
                                 style="width: 40px; height: 40px;">
                                <i class="zmdi zmdi-shopping-cart text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $order->order_number }}</h6>
                            <small class="text-dark">{{ $order->user->first_name }} {{ $order->user->last_name }}</small>
                        </div>
                        <div class="text-right">
                            <h6 class="mb-1">${{ number_format($order->total / 100, 2) }}</h6>
                            <span class="badge badge-{{ $order->getStatusBadgeClass() }}">{{ ucfirst($order->status) }}</span>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-4">
                        <i class="zmdi zmdi-shopping-cart text-dark" style="font-size: 3rem;"></i>
                        <p class="text-dark mt-2">No orders available</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="zmdi zmdi-view-list mr-2"></i>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('orders') }}" class="card border-0 bg-primary text-white text-center h-100">
                            <div class="card-body d-flex flex-column justify-content-center">
                                <i class="zmdi zmdi-shopping-cart mb-3" style="font-size: 2.5rem;"></i>
                                <h6 class="mb-2">Manage Orders</h6>
                                <p class="mb-0 opacity-75">View and manage all orders</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('inventories') }}" class="card border-0 bg-success text-white text-center h-100">
                            <div class="card-body d-flex flex-column justify-content-center">
                                <i class="zmdi zmdi-inbox mb-3" style="font-size: 2.5rem;"></i>
                                <h6 class="mb-2">Manage Products</h6>
                                <p class="mb-0 opacity-75">Add and edit inventory items</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('users') }}" class="card border-0 bg-info text-white text-center h-100">
                            <div class="card-body d-flex flex-column justify-content-center">
                                <i class="zmdi zmdi-account-circle mb-3" style="font-size: 2.5rem;"></i>
                                <h6 class="mb-2">Manage Users</h6>
                                <p class="mb-0 opacity-75">View and manage user accounts</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('promo-codes') }}" class="card border-0 bg-warning text-white text-center h-100">
                            <div class="card-body d-flex flex-column justify-content-center">
                                <i class="zmdi zmdi-ticket-star mb-3" style="font-size: 2.5rem;"></i>
                                <h6 class="mb-2">Promo Codes</h6>
                                <p class="mb-0 opacity-75">Manage discount codes</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End Dashboard Content-->
@endsection

@section('scripts')
<!-- Chart js -->
<script src="{{ asset('backendAssets/plugins/Chart.js/Chart.min.js') }}"></script>
<script>
    $(function() {
        "use strict";

        // Sales Analytics Chart
        var ctx = document.getElementById('chart1').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: 'Orders',
                    data: [{{ $monthlyOrders ?? '0,0,0,0,0,0,0,0,0,0,0,0' }}],
                    backgroundColor: '#fff',
                    borderColor: "transparent",
                    pointRadius: "0",
                    borderWidth: 3
                }, {
                    label: 'Revenue',
                    data: [{{ $monthlyRevenue ?? '0,0,0,0,0,0,0,0,0,0,0,0' }}],
                    backgroundColor: "rgba(255, 255, 255, 0.25)",
                    borderColor: "transparent",
                    pointRadius: "0",
                    borderWidth: 1
                }]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false,
                    labels: {
                        fontColor: '#ddd',
                        boxWidth: 40
                    }
                },
                tooltips: {
                    displayColors: false
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            beginAtZero: true,
                            fontColor: '#ddd'
                        },
                        gridLines: {
                            display: true,
                            color: "rgba(221, 221, 221, 0.08)"
                        },
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            fontColor: '#ddd'
                        },
                        gridLines: {
                            display: true,
                            color: "rgba(221, 221, 221, 0.08)"
                        },
                    }]
                }
            }
        });

        // Order Status Chart
        var ctx = document.getElementById("chart2").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ["Delivered", "Processing", "Shipped", "Cancelled"],
                datasets: [{
                    backgroundColor: [
                        "#28a745",
                        "#ffc107",
                        "#17a2b8",
                        "#dc3545"
                    ],
                    data: [{{ $deliveredOrders ?? 0 }}, {{ $processingOrders ?? 0 }}, {{ $shippedOrders ?? 0 }}, {{ $cancelledOrders ?? 0 }}],
                    borderWidth: [0, 0, 0, 0]
                }]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    position: "bottom",
                    display: false,
                    labels: {
                        fontColor: '#ddd',
                        boxWidth: 15
                    }
                },
                tooltips: {
                    displayColors: false
                }
            }
        });
    });
</script>
@endsection
