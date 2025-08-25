<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Analytics Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.4;
            color: #333;
            background: #f5f5f5;
            padding: 20px;
        }

        .container {
            background: white;
            max-width: 800px;
            margin: 0 auto;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header {
            background: #2c3e50;
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 14px;
            opacity: 0.9;
        }

        .content {
            padding: 30px;
        }

        .section {
            margin-bottom: 30px;
        }

        .section h2 {
            color: #2c3e50;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ecf0f1;
        }

        .stats-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .stat-card {
            display: table-cell;
            width: 33.33%;
            padding: 20px;
            text-align: center;
            border: 1px solid #ecf0f1;
            background: #f8f9fa;
        }

        .stat-card h3 {
            font-size: 32px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .stat-card p {
            font-size: 14px;
            color: #7f8c8d;
            margin-bottom: 10px;
        }

        .growth-indicator {
            font-size: 12px;
            font-weight: bold;
            padding: 4px 8px;
            border-radius: 4px;
        }

        .growth-positive {
            background: #d4edda;
            color: #155724;
        }

        .monthly-data {
            background: #f8f9fa;
            border: 1px solid #ecf0f1;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .data-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #ecf0f1;
        }

        .data-row:last-child {
            border-bottom: none;
        }

        .data-label {
            font-weight: bold;
            color: #2c3e50;
        }

        .data-value {
            font-weight: bold;
            color: #3498db;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .table th {
            background: #2c3e50;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: bold;
            font-size: 14px;
        }

        .table td {
            padding: 12px;
            border-bottom: 1px solid #ecf0f1;
            font-size: 14px;
        }

        .table tr:nth-child(even) {
            background: #f8f9fa;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-pending { background: #fff3cd; color: #856404; }
        .status-processing { background: #cce7ff; color: #004085; }
        .status-approved { background: #d4edda; color: #155724; }
        .status-shipped { background: #d1ecf1; color: #0c5460; }
        .status-delivered { background: #d4edda; color: #155724; }
        .status-rejected { background: #f8d7da; color: #721c24; }
        .status-cancelled { background: #f8d7da; color: #721c24; }

        .footer {
            background: #ecf0f1;
            padding: 20px 30px;
            text-align: center;
            color: #7f8c8d;
            font-size: 12px;
        }



        @media print {
            body {
                background: white;
                padding: 0;
            }

            .container {
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>SALES ANALYTICS REPORT</h1>
            <p>Comprehensive Sales Performance Analysis</p>
            <p style="margin-top: 10px; font-size: 12px;">Generated on {{ $generatedAt }}</p>
        </div>

        <div class="content">
            <!-- Key Metrics -->
            <div class="section">
                <h2>KEY PERFORMANCE METRICS</h2>
                <div class="stats-grid">
                    <div class="stat-card">
                        <h3>{{ $totalOrders }}</h3>
                        <p>Total Orders</p>
                        <div class="growth-indicator growth-positive">
                            +{{ $orderGrowth }}%
                        </div>
                    </div>
                    <div class="stat-card">
                        <h3>${{ number_format($totalRevenue / 100, 2) }}</h3>
                        <p>Total Revenue</p>
                        <div class="growth-indicator growth-positive">
                            +{{ $revenueGrowth }}%
                        </div>
                    </div>
                    <div class="stat-card">
                        <h3>${{ $avgOrderValue }}</h3>
                        <p>Average Order Value</p>
                        <div class="growth-indicator growth-positive">
                            +{{ $avgOrderGrowth }}%
                        </div>
                    </div>
                </div>
            </div>

                        <!-- Monthly Data -->
            <div class="section">
                <h2>MONTHLY PERFORMANCE DATA</h2>
                <div class="monthly-data">
                    <h4 style="color: #2c3e50; font-size: 16px; margin-bottom: 15px;">Monthly Orders Breakdown</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Orders</th>
                                <th>Month</th>
                                <th>Orders</th>
                                <th>Month</th>
                                <th>Orders</th>
                                <th>Month</th>
                                <th>Orders</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $orders = explode(', ', $monthlyOrders);
                                $chunks = array_chunk($orders, 4);
                            @endphp
                            @foreach($chunks as $chunk)
                                <tr>
                                    @foreach($chunk as $order)
                                        @php
                                            $parts = explode(': ', $order);
                                            $month = $parts[0];
                                            $value = $parts[1];
                                        @endphp
                                        <td><strong>{{ $month }}</strong></td>
                                        <td>{{ $value }}</td>
                                    @endforeach
                                    @if(count($chunk) < 4)
                                        @for($i = count($chunk); $i < 4; $i++)
                                            <td></td>
                                            <td></td>
                                        @endfor
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <h4 style="color: #2c3e50; font-size: 16px; margin: 25px 0 15px 0;">Monthly Revenue Breakdown</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Revenue</th>
                                <th>Month</th>
                                <th>Revenue</th>
                                <th>Month</th>
                                <th>Revenue</th>
                                <th>Month</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $revenues = explode(', ', $monthlyRevenue);
                                $chunks = array_chunk($revenues, 4);
                            @endphp
                            @foreach($chunks as $chunk)
                                <tr>
                                    @foreach($chunk as $revenue)
                                        @php
                                            $parts = explode(': ', $revenue);
                                            $month = $parts[0];
                                            $value = $parts[1];
                                        @endphp
                                        <td><strong>{{ $month }}</strong></td>
                                        <td>${{ number_format($value, 0) }}</td>
                                    @endforeach
                                    @if(count($chunk) < 4)
                                        @for($i = count($chunk); $i < 4; $i++)
                                            <td></td>
                                            <td></td>
                                        @endfor
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="section">
                <h2>RECENT SALES ACTIVITY</h2>
                @if(count($recentOrders) > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                            <tr>
                                <td><strong>{{ $order->order_number }}</strong></td>
                                <td>{{ $order->user->first_name }} {{ $order->user->last_name }}</td>
                                <td><strong>${{ number_format($order->total / 100, 2) }}</strong></td>
                                <td>
                                    <span class="status-badge status-{{ $order->status }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('M j, Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div style="text-align: center; padding: 40px; color: #7f8c8d;">
                        <p>No recent orders available</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="footer">
            <p><strong>SALES ANALYTICS REPORT</strong></p>
            <p>This report provides comprehensive insights into your sales performance</p>
            <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
