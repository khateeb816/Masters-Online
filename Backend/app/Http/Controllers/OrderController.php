<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use App\Models\Inventory;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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


}
