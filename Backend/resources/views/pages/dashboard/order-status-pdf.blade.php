<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status Report</title>
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
            max-width: 900px;
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

        .overview-stats {
            display: table;
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .overview-card {
            display: table-cell;
            width: 25%;
            padding: 20px;
            text-align: center;
            border: 1px solid #ecf0f1;
            background: #f8f9fa;
        }

        .overview-card h3 {
            font-size: 28px;
            color: #2c3e50;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .overview-card p {
            color: #7f8c8d;
            font-size: 14px;
            margin: 0;
        }

        .status-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .status-row {
            display: table-row;
        }

        .status-card {
            display: table-cell;
            width: 33.33%;
            padding: 20px;
            border: 1px solid #ecf0f1;
            background: white;
            text-align: center;
            vertical-align: top;
        }

        .status-card.pending { border-left: 4px solid #ffc107; }
        .status-card.processing { border-left: 4px solid #17a2b8; }
        .status-card.approved { border-left: 4px solid #28a745; }
        .status-card.shipped { border-left: 4px solid #007bff; }
        .status-card.delivered { border-left: 4px solid #28a745; }
        .status-card.rejected { border-left: 4px solid #dc3545; }
        .status-card.cancelled { border-left: 4px solid #6c757d; }

        .status-card h3 {
            font-size: 16px;
            margin-bottom: 10px;
            color: #2c3e50;
            font-weight: bold;
        }

        .status-card .count {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .status-card.pending .count { color: #ffc107; }
        .status-card.processing .count { color: #17a2b8; }
        .status-card.approved .count { color: #28a745; }
        .status-card.shipped .count { color: #007bff; }
        .status-card.delivered .count { color: #28a745; }
        .status-card.rejected .count { color: #dc3545; }
        .status-card.cancelled .count { color: #6c757d; }

        .status-card .percentage {
            font-size: 14px;
            color: #7f8c8d;
            font-weight: bold;
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

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #7f8c8d;
        }

        .empty-state p {
            font-size: 16px;
            margin-top: 10px;
        }

        .status-section {
            margin-bottom: 25px;
        }

        .status-section h3 {
            color: #2c3e50;
            font-size: 18px;
            margin-bottom: 15px;
            font-weight: bold;
            text-transform: uppercase;
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
            <h1>ORDER STATUS REPORT</h1>
            <p>Comprehensive Order Management Overview</p>
            <p style="margin-top: 10px; font-size: 12px;">Generated on {{ $generatedAt }}</p>
        </div>

        <div class="content">
            <!-- Overview Stats -->
            <div class="section">
                <h2>ORDER OVERVIEW</h2>
                <div class="overview-stats">
                    <div class="overview-card">
                        <h3>{{ $totalOrders }}</h3>
                        <p>Total Orders</p>
                    </div>
                    <div class="overview-card">
                        <h3>{{ $pendingOrders + $processingOrders }}</h3>
                        <p>Active Orders</p>
                    </div>
                    <div class="overview-card">
                        <h3>{{ $deliveredOrders }}</h3>
                        <p>Completed Orders</p>
                    </div>
                    <div class="overview-card">
                        <h3>{{ $rejectedOrders + $cancelledOrders }}</h3>
                        <p>Failed Orders</p>
                    </div>
                </div>
            </div>

            <!-- Status Breakdown -->
            <div class="section">
                <h2>ORDER STATUS BREAKDOWN</h2>
                <div class="status-grid">
                    <div class="status-row">
                        <div class="status-card pending">
                            <h3>Pending</h3>
                            <div class="count">{{ $pendingOrders }}</div>
                            <div class="percentage">{{ $pendingPercentage }}% of total</div>
                        </div>

                        <div class="status-card processing">
                            <h3>Processing</h3>
                            <div class="count">{{ $processingOrders }}</div>
                            <div class="percentage">{{ $processingPercentage }}% of total</div>
                        </div>

                        <div class="status-card approved">
                            <h3>Approved</h3>
                            <div class="count">{{ $approvedOrders }}</div>
                            <div class="percentage">{{ $approvedPercentage }}% of total</div>
                        </div>
                    </div>

                    <div class="status-row">
                        <div class="status-card shipped">
                            <h3>Shipped</h3>
                            <div class="count">{{ $shippedOrders }}</div>
                            <div class="percentage">{{ $shippedPercentage }}% of total</div>
                        </div>

                        <div class="status-card delivered">
                            <h3>Delivered</h3>
                            <div class="count">{{ $deliveredOrders }}</div>
                            <div class="percentage">{{ $deliveredPercentage }}% of total</div>
                        </div>

                        <div class="status-card rejected">
                            <h3>Rejected</h3>
                            <div class="count">{{ $rejectedOrders }}</div>
                            <div class="percentage">{{ $rejectedPercentage }}% of total</div>
                        </div>
                    </div>

                    <div class="status-row">
                        <div class="status-card cancelled">
                            <h3>Cancelled</h3>
                            <div class="count">{{ $cancelledOrders }}</div>
                            <div class="percentage">{{ $cancelledPercentage }}% of total</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders by Status -->
            <div class="section">
                <h2>RECENT ORDERS BY STATUS</h2>

                @foreach(['pending', 'processing', 'approved', 'shipped', 'delivered', 'rejected', 'cancelled'] as $status)
                    @if(count($ordersByStatus[$status]) > 0)
                        <div class="status-section">
                            <h3>{{ ucfirst($status) }} Orders</h3>
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
                                    @foreach($ordersByStatus[$status] as $order)
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
                        </div>
                    @endif
                @endforeach

                @if($totalOrders == 0)
                    <div class="empty-state">
                        <p>No orders available</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="footer">
            <p><strong>ORDER STATUS REPORT</strong></p>
            <p>This report provides comprehensive insights into your order management</p>
            <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
