<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Inventory;
use App\Models\Notification;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total counts
        $totalOrders = Order::count();
        $totalUsers = User::count();
        $totalProducts = Inventory::count();
        $totalRevenue = Order::sum('total');

        // Get order status counts
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $approvedOrders = Order::where('status', 'approved')->count();
        $shippedOrders = Order::where('status', 'shipped')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $rejectedOrders = Order::where('status', 'rejected')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();

        // Calculate percentages
        $totalOrderCount = $totalOrders > 0 ? $totalOrders : 1;
        $pendingPercentage = round(($pendingOrders / $totalOrderCount) * 100);
        $processingPercentage = round(($processingOrders / $totalOrderCount) * 100);
        $approvedPercentage = round(($approvedOrders / $totalOrderCount) * 100);
        $shippedPercentage = round(($shippedOrders / $totalOrderCount) * 100);
        $deliveredPercentage = round(($deliveredOrders / $totalOrderCount) * 100);
        $rejectedPercentage = round(($rejectedOrders / $totalOrderCount) * 100);
        $cancelledPercentage = round(($cancelledOrders / $totalOrderCount) * 100);

        // Get monthly data for charts
        $monthlyOrders = $this->getMonthlyData('orders');
        $monthlyRevenue = $this->getMonthlyData('revenue');

        // Get top products
        $topProducts = Inventory::with(['category', 'orderDetails'])
            ->withCount('orderDetails')
            ->orderBy('order_details_count', 'desc')
            ->limit(5)
            ->get();

        // Get recent orders
        $recentOrders = Order::with(['user'])
            ->latest()
            ->limit(5)
            ->get();

        // Calculate growth percentages (simplified)
        $orderGrowth = 15; // You can implement actual growth calculation
        $revenueGrowth = 12;
        $userGrowth = 8;
        $productGrowth = 20;

        // Calculate average order value
        $avgOrderValue = $totalOrders > 0 ? round($totalRevenue / $totalOrders / 100, 2) : 0;
        $avgOrderGrowth = 5;

        return view('pages.dashboard.index', compact(
            'totalOrders',
            'totalUsers',
            'totalProducts',
            'totalRevenue',
            'pendingOrders',
            'processingOrders',
            'approvedOrders',
            'shippedOrders',
            'deliveredOrders',
            'rejectedOrders',
            'cancelledOrders',
            'pendingPercentage',
            'processingPercentage',
            'approvedPercentage',
            'shippedPercentage',
            'deliveredPercentage',
            'rejectedPercentage',
            'cancelledPercentage',
            'monthlyOrders',
            'monthlyRevenue',
            'topProducts',
            'recentOrders',
            'orderGrowth',
            'revenueGrowth',
            'userGrowth',
            'productGrowth',
            'avgOrderValue',
            'avgOrderGrowth'
        ));
    }

    public function exportSalesAnalytics()
    {
        // Get sales analytics data
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total');
        $avgOrderValue = $totalOrders > 0 ? round($totalRevenue / $totalOrders / 100, 2) : 0;

        // Get monthly data
        $monthlyOrders = $this->getMonthlyData('orders');
        $monthlyRevenue = $this->getMonthlyData('revenue');

        // Format monthly data for better display
        $monthlyOrdersFormatted = $this->formatMonthlyData($monthlyOrders);
        $monthlyRevenueFormatted = $this->formatMonthlyData($monthlyRevenue);

        // Calculate growth percentages
        $orderGrowth = 15;
        $revenueGrowth = 12;
        $avgOrderGrowth = 5;

        // Get recent orders for sales context
        $recentOrders = Order::with(['user'])
            ->latest()
            ->limit(10)
            ->get();

        $data = [
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'avgOrderValue' => $avgOrderValue,
            'monthlyOrders' => $monthlyOrdersFormatted,
            'monthlyRevenue' => $monthlyRevenueFormatted,
            'recentOrders' => $recentOrders,
            'orderGrowth' => $orderGrowth,
            'revenueGrowth' => $revenueGrowth,
            'avgOrderGrowth' => $avgOrderGrowth,
            'generatedAt' => now()->format('F j, Y \a\t g:i A')
        ];

        $pdf = PDF::loadView('pages.dashboard.sales-analytics-pdf', $data);

        Notification::create([
            'user_id' => auth()->user()->id,
            'title' => 'Sales Analytics Report',
            'message' => 'Sales analytics report has been generated.',
            'type' => 'success',
            'icon' => 'fa-file-pdf',
            'data' => json_encode($data)
        ]);

        return $pdf->download('sales-analytics-report-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportOrderStatus()
    {
        // Get order status data
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $approvedOrders = Order::where('status', 'approved')->count();
        $shippedOrders = Order::where('status', 'shipped')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $rejectedOrders = Order::where('status', 'rejected')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();

        // Calculate percentages
        $totalOrderCount = $totalOrders > 0 ? $totalOrders : 1;
        $pendingPercentage = round(($pendingOrders / $totalOrderCount) * 100);
        $processingPercentage = round(($processingOrders / $totalOrderCount) * 100);
        $approvedPercentage = round(($approvedOrders / $totalOrderCount) * 100);
        $shippedPercentage = round(($shippedOrders / $totalOrderCount) * 100);
        $deliveredPercentage = round(($deliveredOrders / $totalOrderCount) * 100);
        $rejectedPercentage = round(($rejectedOrders / $totalOrderCount) * 100);
        $cancelledPercentage = round(($cancelledOrders / $totalOrderCount) * 100);

        // Get orders by status for detailed view
        $ordersByStatus = [
            'pending' => Order::where('status', 'pending')->with('user')->latest()->limit(5)->get(),
            'processing' => Order::where('status', 'processing')->with('user')->latest()->limit(5)->get(),
            'approved' => Order::where('status', 'approved')->with('user')->latest()->limit(5)->get(),
            'shipped' => Order::where('status', 'shipped')->with('user')->latest()->limit(5)->get(),
            'delivered' => Order::where('status', 'delivered')->with('user')->latest()->limit(5)->get(),
            'rejected' => Order::where('status', 'rejected')->with('user')->latest()->limit(5)->get(),
            'cancelled' => Order::where('status', 'cancelled')->with('user')->latest()->limit(5)->get(),
        ];

        $data = [
            'totalOrders' => $totalOrders,
            'pendingOrders' => $pendingOrders,
            'processingOrders' => $processingOrders,
            'approvedOrders' => $approvedOrders,
            'shippedOrders' => $shippedOrders,
            'deliveredOrders' => $deliveredOrders,
            'rejectedOrders' => $rejectedOrders,
            'cancelledOrders' => $cancelledOrders,
            'pendingPercentage' => $pendingPercentage,
            'processingPercentage' => $processingPercentage,
            'approvedPercentage' => $approvedPercentage,
            'shippedPercentage' => $shippedPercentage,
            'deliveredPercentage' => $deliveredPercentage,
            'rejectedPercentage' => $rejectedPercentage,
            'cancelledPercentage' => $cancelledPercentage,
            'ordersByStatus' => $ordersByStatus,
            'generatedAt' => now()->format('F j, Y \a\t g:i A')
        ];

        Notification::create([

            'user_id' => auth()->user()->id,
            'title' => 'Order Status Report',
            'message' => 'Order status report has been generated.',
            'type' => 'success',
            'icon' => 'fa-file-pdf',
            'data' => json_encode($data)
        ]);

        $pdf = PDF::loadView('pages.dashboard.order-status-pdf', $data);

        return $pdf->download('order-status-report-' . now()->format('Y-m-d') . '.pdf');
    }

    private function getMonthlyData($type)
    {
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            if ($type === 'orders') {
                $count = Order::whereMonth('created_at', $i)->count();
                $data[] = $count;
            } else {
                $revenue = Order::whereMonth('created_at', $i)->sum('total');
                $data[] = round($revenue / 100); // Convert from cents to dollars
            }
        }
        return implode(',', $data);
    }

    private function formatMonthlyData($dataString)
    {
        $data = explode(',', $dataString);
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $formatted = [];

        foreach ($data as $index => $value) {
            $formatted[] = $months[$index] . ': ' . $value;
        }

        return implode(', ', $formatted);
    }
}
