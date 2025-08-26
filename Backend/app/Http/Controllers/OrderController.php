<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use App\Models\Inventory;
use App\Models\PromoCode;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'orderDetails.inventory'])->latest()->get();
        return view('pages.orders.index', compact('orders'));
    }



    public function show($id)
    {
        $order = Order::with(['user', 'orderDetails.inventory', 'promoCode'])->findOrFail($id);
        return view('pages.orders.show', compact('order'));
    }

    public function approve(Order $order)
    {
        try {
            $order->update(['status' => 'approved']);
            Notification::create([

                'user_id' => auth()->user()->id,
                'title' => 'Order Approved',
                'message' => 'Order ' . $order->number . ' approved successfully',
                'type' => 'success',
                'icon' => 'fa-check',
            ]);
            return redirect()->back()->with('success', 'Order ' . $order->number . ' approved successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to approve order: ' . $e->getMessage());
        }
    }

    public function reject(Order $order, Request $request)
    {
        try {
            // Debug logging
            Log::info('Reject order attempt', [
                'order_id' => $order->id,
                'current_status' => $order->status,
                'request_data' => $request->all(),
                'user_id' => auth()->id()
            ]);

            // Check if order can be rejected
            $allowedStatuses = ['pending', 'processing', 'approved', 'rejected'];
            if (!in_array($order->status, $allowedStatuses)) {
                Log::warning('Order rejection blocked - invalid status', [
                    'order_id' => $order->id,
                    'current_status' => $order->status,
                    'allowed_statuses' => $allowedStatuses
                ]);
                return redirect()->back()->with('error', 'This order cannot be rejected. Only pending, processing, approved, and rejected orders can be rejected.');
            }

            $request->validate([
                'rejection_reason' => 'required|string|max:1000'
            ]);

            Log::info('Updating order status to rejected', [
                'order_id' => $order->id,
                'rejection_reason' => $request->rejection_reason
            ]);

            $order->update([
                'status' => 'rejected',
                'rejection_reason' => $request->rejection_reason
            ]);

            Log::info('Order rejected successfully', [
                'order_id' => $order->id,
                'new_status' => $order->status
            ]);

            Notification::create([

                'user_id' => auth()->user()->id,
                'title' => 'Order Rejected',
                'message' => 'Order ' . $order->number . ' rejected successfully with reason: ' . $request->rejection_reason,
                'type' => 'success',
                'icon' => 'fa-times',
            ]);

            return redirect()->back()->with('success', 'Order ' . $order->number . ' rejected successfully with reason: ' . $request->rejection_reason);
        } catch (\Exception $e) {
            Log::error('Order rejection failed', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Failed to reject order: ' . $e->getMessage());
        }
    }
}
