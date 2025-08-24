@extends('layouts.app')
@section('title', 'Order Details - ' . config('app.name'))
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Order Details</h4>
                        <div>
                            <a href="{{ route('orders') }}" class="btn btn-secondary btn-sm">
                                <i class="zmdi zmdi-arrow-left"></i> Back to Orders
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="order-summary">
                                    <h5 class="text-primary mb-3">
                                        <i class="zmdi zmdi-receipt mr-2"></i>Order Summary
                                    </h5>

                                    <div class="order-status mb-3">
                                        <h6>Order Status</h6>
                                        <span class="badge {{ $order->getStatusBadgeClass() }} p-2">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>

                                    <div class="payment-status mb-3">
                                        <h6>Payment Status</h6>
                                        <span class="badge {{ $order->getPaymentStatusBadgeClass() }} p-2">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </div>

                                    <div class="order-number mb-3">
                                        <h6>Order Number</h6>
                                        <strong class="text-primary">{{ $order->order_number }}</strong>
                                    </div>

                                    <div class="order-date mb-3">
                                        <h6>Order Date</h6>
                                        <span>{{ $order->created_at->format('M d, Y \a\t h:i A') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 class="text-primary mb-3">
                                            <i class="zmdi zmdi-account mr-2"></i>Customer Information
                                        </h5>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-account mr-2"></i>Name:</strong></td>
                                                <td>{{ $order->user->first_name }} {{ $order->user->last_name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-email mr-2"></i>Email:</strong></td>
                                                <td>{{ $order->user->email }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-phone mr-2"></i>Phone:</strong></td>
                                                <td>{{ $order->user->phone ?? 'Not provided' }}</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="col-md-12 mt-4">
                                        <h5 class="text-primary mb-3">
                                            <i class="zmdi zmdi-local-shipping mr-2"></i>Shipping Information
                                        </h5>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-home mr-2"></i>Address:</strong></td>
                                                <td>{{ $order->shipping_address }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-city mr-2"></i>City:</strong></td>
                                                <td>{{ $order->city }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-pin mr-2"></i>State:</strong></td>
                                                <td>{{ $order->state }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-globe mr-2"></i>Country:</strong></td>
                                                <td>{{ $order->country }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-pin-drop mr-2"></i>ZIP Code:</strong></td>
                                                <td>{{ $order->zip }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="text-primary mb-3">
                                    <i class="zmdi zmdi-shopping-cart mr-2"></i>Order Items
                                </h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Item</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order->orderDetails as $detail)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($detail->inventory->images)
                                                            @php
                                                                $imageArray = json_decode($detail->inventory->images, true);
                                                                $firstImage = is_array($imageArray) ? $imageArray[0] : $detail->inventory->images;
                                                            @endphp
                                                            <img src="{{ asset('uploads/' . $firstImage) }}"
                                                                 alt="{{ $detail->inventory->name }}"
                                                                 class="mr-3"
                                                                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                                        @endif
                                                        <div>
                                                            <strong>{{ $detail->inventory->name }}</strong><br>
                                                            <small class="text-muted">{{ $detail->inventory->category->title ?? 'N/A' }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>${{ number_format($detail->price / 100, 2) }}</td>
                                                <td>{{ $detail->quantity }}</td>
                                                <td>${{ number_format($detail->total / 100, 2) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6 offset-md-6">
                                <div class="order-totals">
                                    <h5 class="text-primary mb-3">Order Totals</h5>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Subtotal:</strong></td>
                                            <td class="text-right">${{ number_format($order->sub_total / 100, 2) }}</td>
                                        </tr>
                                        @if($order->promoCode)
                                        <tr>
                                            <td><strong>Discount:</strong></td>
                                            <td class="text-right text-success">-${{ number_format((($order->promoCode->discount_percentage / 100) * $order->sub_total) / 100, 2) }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td><strong>Shipping:</strong></td>
                                            <td class="text-right">${{ number_format($order->shipping_cost / 100, 2) }}</td>
                                        </tr>
                                        <tr class="border-top">
                                            <td><strong>Total:</strong></td>
                                            <td class="text-right"><strong class="text-primary">${{ number_format($order->total / 100, 2) }}</strong></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
