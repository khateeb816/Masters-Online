<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Inventory;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $shippedOrders = Order::where('status', 'shipped')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();

        // Calculate percentages
        $totalOrderCount = $totalOrders > 0 ? $totalOrders : 1;
        $deliveredPercentage = round(($deliveredOrders / $totalOrderCount) * 100);
        $processingPercentage = round(($processingOrders / $totalOrderCount) * 100);
        $shippedPercentage = round(($shippedOrders / $totalOrderCount) * 100);
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

        return view('dashboard', compact(
            'totalOrders',
            'totalUsers',
            'totalProducts',
            'totalRevenue',
            'deliveredOrders',
            'processingOrders',
            'shippedOrders',
            'cancelledOrders',
            'deliveredPercentage',
            'processingPercentage',
            'shippedPercentage',
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


    public function icons()
    {
        return view('icons');
    }


    public function forms()
    {
        return view('forms');
    }


    public function tables()
    {
        return view('tables');
    }



    public function profile()
    {
        return view('profile');
    }
}
