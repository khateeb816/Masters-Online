<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #007bff;
            margin: 0;
            font-size: 28px;
        }
        .header p {
            color: #666;
            margin: 5px 0 0 0;
        }
        .stats-grid {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        .stat-card {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            width: 22%;
            margin-bottom: 15px;
        }
        .stat-card h3 {
            margin: 0 0 10px 0;
            color: #007bff;
            font-size: 24px;
        }
        .stat-card p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section h2 {
            color: #007bff;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .order-status {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        .status-item {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 10px;
            width: 48%;
        }
        .status-item h4 {
            margin: 0 0 5px 0;
            color: #333;
        }
        .status-item p {
            margin: 0;
            color: #666;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .table th, .table td {
            border: 1px solid #dee2e6;
            padding: 12px;
            text-align: left;
        }
        .table th {
            background: #f8f9fa;
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #dee2e6;
            padding-top: 20px;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Dashboard Report</h1>
        <p>Generated on {{ $generatedAt }}</p>
    </div>

    <!-- Key Statistics -->
    <div class="section">
        <h2>Key Statistics</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <h3>{{ $totalOrders }}</h3>
                <p>Total Orders</p>
            </div>
            <div class="stat-card">
                <h3>${{ number_format($totalRevenue / 100, 2) }}</h3>
                <p>Total Revenue</p>
            </div>
            <div class="stat-card">
                <h3>{{ $totalUsers }}</h3>
                <p>Total Users</p>
            </div>
            <div class="stat-card">
                <h3>{{ $totalProducts }}</h3>
                <p>Total Products</p>
            </div>
        </div>
    </div>

    <!-- Order Status Overview -->
    <div class="section">
        <h2>Order Status Overview</h2>
        <div class="order-status">
            <div class="status-item">
                <h4>Pending</h4>
                <p>{{ $pendingOrders }} orders ({{ $pendingPercentage }}%)</p>
            </div>
            <div class="status-item">
                <h4>Processing</h4>
                <p>{{ $processingOrders }} orders ({{ $processingPercentage }}%)</p>
            </div>
            <div class="status-item">
                <h4>Approved</h4>
                <p>{{ $approvedOrders }} orders ({{ $approvedPercentage }}%)</p>
            </div>
            <div class="status-item">
                <h4>Shipped</h4>
                <p>{{ $shippedOrders }} orders ({{ $shippedPercentage }}%)</p>
            </div>
            <div class="status-item">
                <h4>Delivered</h4>
                <p>{{ $deliveredOrders }} orders ({{ $deliveredPercentage }}%)</p>
            </div>
            <div class="status-item">
                <h4>Rejected</h4>
                <p>{{ $rejectedOrders }} orders ({{ $rejectedPercentage }}%)</p>
            </div>
            <div class="status-item">
                <h4>Cancelled</h4>
                <p>{{ $cancelledOrders }} orders ({{ $cancelledPercentage }}%)</p>
            </div>
        </div>
    </div>

    <!-- Top Products -->
    <div class="section">
        <h2>Top Products</h2>
        @if(count($topProducts) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Orders</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topProducts as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->title ?? 'N/A' }}</td>
                        <td>${{ number_format($product->price / 100, 2) }}</td>
                        <td>{{ $product->orderDetails->count() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No products available</p>
        @endif
    </div>

    <!-- Recent Orders -->
    <div class="section">
        <h2>Recent Orders</h2>
        @if(count($recentOrders) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Order Number</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->user->first_name }} {{ $order->user->last_name }}</td>
                        <td>${{ number_format($order->total / 100, 2) }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>{{ $order->created_at->format('M j, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No orders available</p>
        @endif
    </div>

    <!-- Monthly Data -->
    <div class="section">
        <h2>Monthly Overview</h2>
        <div class="order-status">
            <div class="status-item">
                <h4>Monthly Orders</h4>
                <p>{{ $monthlyOrders }}</p>
            </div>
            <div class="status-item">
                <h4>Monthly Revenue</h4>
                <p>${{ $monthlyRevenue }}</p>
            </div>
            <div class="status-item">
                <h4>Average Order Value</h4>
                <p>${{ $avgOrderValue }}</p>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>This report was automatically generated by the system.</p>
        <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>
