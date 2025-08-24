@extends('layouts.app')
@section('title', 'Order Details - ' . config('app.name'))
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">
                            <i class="zmdi zmdi-shopping-cart mr-2"></i>Order Details
                        </h4>
                        <div>
                            <a href="{{ route('orders') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="zmdi zmdi-arrow-left"></i> Back to Orders
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="order-summary">
                                    <h5 class="text-dark mb-3">
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
                                        <strong class="text-dark">{{ $order->order_number }}</strong>
                                    </div>

                                    <div class="order-date mb-3">
                                        <h6>Order Date</h6>
                                        <span>{{ $order->created_at->format('M d, Y \a\t h:i A') }}</span>
                                    </div>

                                    <!-- Order Actions -->
                                    @if (auth()->user()->role === 'admin' && in_array($order->status, ['pending', 'processing']))
                                        <div class="order-actions mt-4">
                                            <h6 class="text-dark mb-3">Order Actions</h6>

                                            <!-- Approve Order Button -->
                                            <form action="{{ route('orders.approve', $order->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-block mb-3"
                                                    onclick="return confirm('Are you sure you want to approve this order? This action cannot be undone.')">
                                                    <i class="zmdi zmdi-check mr-2"></i>Approve Order
                                                </button>
                                            </form>

                                            <!-- Reject Order Button -->
                                            <button type="button" class="btn btn-danger btn-block mb-3"
                                                onclick="showRejectInput({{ $order->id }})">
                                                <i class="zmdi zmdi-close mr-2"></i>Reject Order
                                            </button>



                                            <!-- Reject Input Section (Hidden by default) -->
                                            <div id="rejectInputSection_{{ $order->id }}" class="mt-3 reject-input-section" style="display: none;">
                                                <div class="alert alert-warning">
                                                    <i class="zmdi zmdi-alert-triangle mr-2"></i>
                                                    <strong>Warning:</strong> Rejecting an order will change its status to "rejected" and require a reason.
                                                </div>

                                                <form action="{{ route('orders.reject', $order->id) }}" method="POST" class="reject-form" onsubmit="return validateRejectForm(this, {{ $order->id }})">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="rejection_reason_{{ $order->id }}" class="font-weight-bold">
                                                            <i class="zmdi zmdi-comment-text mr-2"></i>Rejection Reason <span class="text-danger">*</span>
                                                        </label>
                                                        <textarea class="form-control" name="rejection_reason" id="rejection_reason_{{ $order->id }}"
                                                            rows="3" placeholder="Please provide a detailed reason for rejecting this order..." required></textarea>
                                                        <small class="form-text text-muted">
                                                            This reason will be visible to the customer and stored in the order history.
                                                        </small>
                                                    </div>
                                                    <div class="mt-3">
                                                        <button type="submit" class="btn btn-danger btn-sm mr-2">
                                                            <i class="zmdi zmdi-close mr-2"></i>Submit Rejection
                                                        </button>
                                                        <button type="button" class="btn btn-secondary btn-sm"
                                                            onclick="hideRejectInput({{ $order->id }})">
                                                            <i class="zmdi zmdi-close mr-2"></i>Cancel
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                                                        @elseif(auth()->user()->role === 'admin' && in_array($order->status, ['approved']))
                                        <div class="order-actions mt-4">
                                            <h6 class="text-dark mb-3">Order Actions</h6>

                                            <!-- Order Status Display -->
                                            <div class="alert alert-success mb-3 p-2">
                                                <div class="d-flex align-items-center">
                                                    <i class="zmdi zmdi-check-circle mr-3" style="font-size: 1.5rem;"></i>
                                                    <div>
                                                        <strong class="d-block">Order Approved</strong>
                                                        <small class="mb-0">This order has been approved and is ready for processing.</small>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Reject Order Button (Only for approved orders) -->
                                            <button type="button" class="btn btn-outline-danger btn-block"
                                                onclick="showRejectInput({{ $order->id }})">
                                                <i class="zmdi zmdi-close mr-2"></i>Reject Order
                                            </button>

                                            <!-- Reject Input Section (Hidden by default) -->
                                            <div id="rejectInputSection_{{ $order->id }}" class="mt-3 reject-input-section" style="display: none;">
                                                <div class="alert alert-warning p-2">
                                                    <i class="zmdi zmdi-alert-triangle mr-2"></i>
                                                    <strong>Warning:</strong> Rejecting an order will change its status to "rejected" and require a reason.
                                                </div>

                                                <form action="{{ route('orders.reject', $order->id) }}" method="POST" class="reject-form" onsubmit="return validateRejectForm(this, {{ $order->id }})">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="rejection_reason_{{ $order->id }}" class="font-weight-bold">
                                                            <i class="zmdi zmdi-comment-text mr-2"></i>Rejection Reason <span class="text-danger">*</span>
                                                        </label>
                                                        <textarea class="form-control" name="rejection_reason" id="rejection_reason_{{ $order->id }}"
                                                            rows="3" placeholder="Please provide a detailed reason for rejecting this order..." required></textarea>
                                                        <small class="form-text text-muted">
                                                            This reason will be visible to the customer and stored in the order history.
                                                        </small>
                                                    </div>
                                                    <div class="mt-3">
                                                        <button type="submit" class="btn btn-danger btn-sm mr-2">
                                                            <i class="zmdi zmdi-close mr-2"></i>Submit Rejection
                                                        </button>
                                                        <button type="button" class="btn btn-secondary btn-sm"
                                                            onclick="hideRejectInput({{ $order->id }})">
                                                            <i class="zmdi zmdi-close mr-2"></i>Cancel
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @elseif(auth()->user()->role === 'admin' && $order->status === 'rejected')
                                        <div class="order-actions mt-4">
                                            <h6 class="text-dark mb-3">Order Actions</h6>

                                            <!-- Order Status Display -->
                                            <div class="alert alert-danger mb-3 p-2">
                                                <div class="d-flex align-items-center">
                                                    <i class="zmdi zmdi-close-circle mr-3" style="font-size: 1.5rem;"></i>
                                                    <div>
                                                        <strong class="d-block">Order Rejected</strong>
                                                        <small class="mb-0">This order has been rejected. You can approve it again or reject it with a different reason.</small>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Approve Order Button (for rejected orders) -->
                                            <form action="{{ route('orders.approve', $order->id) }}" method="POST" class="d-inline mb-3">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-block mb-3"
                                                    onclick="return confirm('Are you sure you want to approve this previously rejected order?')">
                                                    <i class="zmdi zmdi-check mr-2"></i>Approve Order
                                                </button>
                                            </form>

                                            <!-- Reject Order Button (for rejected orders) -->
                                            <button type="button" class="btn btn-outline-danger btn-block"
                                                onclick="showRejectInput({{ $order->id }})">
                                                <i class="zmdi zmdi-close mr-2"></i>Reject Order Again
                                            </button>

                                            <!-- Reject Input Section (Hidden by default) -->
                                            <div id="rejectInputSection_{{ $order->id }}" class="mt-3 reject-input-section" style="display: none;">
                                                <div class="alert alert-warning p-2">
                                                    <i class="zmdi zmdi-alert-triangle mr-2"></i>
                                                    <strong>Warning:</strong> Rejecting this order again will update the rejection reason.
                                                </div>

                                                <form action="{{ route('orders.reject', $order->id) }}" method="POST" class="reject-form" onsubmit="return validateRejectForm(this, {{ $order->id }})">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="rejection_reason_{{ $order->id }}" class="font-weight-bold">
                                                            <i class="zmdi zmdi-comment-text mr-2"></i>New Rejection Reason <span class="text-danger">*</span>
                                                        </label>
                                                        <textarea class="form-control" name="rejection_reason" id="rejection_reason_{{ $order->id }}"
                                                            rows="3" placeholder="Please provide a new reason for rejecting this order..." required></textarea>
                                                        <small class="form-text text-muted">
                                                            This will replace the previous rejection reason.
                                                        </small>
                                                    </div>
                                                    <div class="mt-3">
                                                        <button type="submit" class="btn btn-danger btn-sm mr-2">
                                                            <i class="zmdi zmdi-close mr-2"></i>Update Rejection
                                                        </button>
                                                        <button type="button" class="btn btn-secondary btn-sm"
                                                            onclick="hideRejectInput({{ $order->id }})">
                                                            <i class="zmdi zmdi-close mr-2"></i>Cancel
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @elseif(auth()->user()->role === 'admin' && in_array($order->status, ['shipped', 'delivered']))
                                        <div class="order-actions mt-4">
                                            <h6 class="text-dark mb-3">Order Status</h6>

                                            <!-- Order Status Display -->
                                            @if($order->status === 'shipped')
                                                <div class="alert alert-info mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <i class="zmdi zmdi-local-shipping mr-3" style="font-size: 1.5rem;"></i>
                                                        <div>
                                                            <strong class="d-block">Order Shipped</strong>
                                                            <small class="mb-0">This order has been shipped and is in transit. No further actions can be taken.</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif($order->status === 'delivered')
                                                <div class="alert alert-success mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <i class="zmdi zmdi-check-circle mr-3" style="font-size: 1.5rem;"></i>
                                                        <div>
                                                            <strong class="d-block">Order Delivered</strong>
                                                            <small class="mb-0">This order has been successfully delivered to the customer. No further actions can be taken.</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    <!-- Rejection Reason (if order is rejected) -->
                                    @if ($order->status === 'rejected' && $order->rejection_reason)
                                        <div class="rejection-reason mt-4">
                                            <h6 class="text-danger mb-2">Rejection Reason</h6>
                                            <div class="alert alert-danger">
                                                <i class="zmdi zmdi-alert-circle mr-2"></i>
                                                {{ $order->rejection_reason }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 class="text-dark mb-3">
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
                                        <h5 class="text-dark mb-3">
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
                                <h5 class="text-dark mb-3">
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
                                            @foreach ($order->orderDetails as $detail)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            @if ($detail->inventory->images)
                                                                @php
                                                                    $imageArray = json_decode(
                                                                        $detail->inventory->images,
                                                                        true,
                                                                    );
                                                                    $firstImage = is_array($imageArray)
                                                                        ? $imageArray[0]
                                                                        : $detail->inventory->images;
                                                                @endphp
                                                                <img src="{{ asset('uploads/' . $firstImage) }}"
                                                                    alt="{{ $detail->inventory->name }}" class="mr-3"
                                                                    style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                                            @endif
                                                            <div>
                                                                <strong>{{ $detail->inventory->name }}</strong><br>
                                                                <small
                                                                    class="text-dark">{{ $detail->inventory->category->title ?? 'N/A' }}</small>
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
                                    <h5 class="text-dark mb-3">Order Totals</h5>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Subtotal:</strong></td>
                                            <td class="text-right">${{ number_format($order->sub_total / 100, 2) }}</td>
                                        </tr>
                                        @if ($order->promoCode)
                                            <tr>
                                                <td><strong>Discount:</strong></td>
                                                <td class="text-right text-success">
                                                    -${{ number_format((($order->promoCode->discount_percentage / 100) * $order->sub_total) / 100, 2) }}
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td><strong>Shipping:</strong></td>
                                            <td class="text-right">${{ number_format($order->shipping_cost / 100, 2) }}
                                            </td>
                                        </tr>
                                        <tr class="border-top">
                                            <td><strong>Total:</strong></td>
                                            <td class="text-right"><strong
                                                    class="text-dark">${{ number_format($order->total / 100, 2) }}</strong>
                                            </td>
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

    <!-- Modern CSS Styling -->
    <style>
        /* Modern Card-like Styling for Reject Input Sections */
        .reject-input-section {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            backdrop-filter: blur(10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .reject-input-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #dc3545, #fd7e14, #dc3545);
            background-size: 200% 100%;
            animation: gradient-shift 3s ease-in-out infinite;
        }

        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .reject-input-section:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(220, 53, 69, 0.15);
            border-color: rgba(220, 53, 69, 0.2);
        }

        /* Modern Form Controls */
        .reject-input-section .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 0.875rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #ffffff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            pointer-events: auto !important;
            user-select: text !important;
            cursor: text !important;
            resize: vertical;
            min-height: 80px;
        }

        .reject-input-section .form-control:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1);
            background: #ffffff;
            transform: scale(1.02);
            outline: none !important;
        }

        .reject-input-section .form-control::placeholder {
            color: #adb5bd;
            font-style: italic;
            pointer-events: none;
        }

        /* Ensure textarea is fully interactive */
        .reject-input-section textarea.form-control {
            pointer-events: auto !important;
            user-select: text !important;
            cursor: text !important;
            resize: vertical;
            min-height: 80px;
            font-family: inherit;
            line-height: 1.5;
            position: relative !important;
            z-index: 10 !important;
            background: #ffffff !important;
            color: #495057 !important;
        }

        /* Override any conflicting styles */
        .reject-input-section textarea.form-control:focus,
        .reject-input-section textarea.form-control:active,
        .reject-input-section textarea.form-control:hover {
            pointer-events: auto !important;
            user-select: text !important;
            cursor: text !important;
            background: #ffffff !important;
            color: #495057 !important;
        }



        /* Modern Labels */
        .reject-input-section .font-weight-bold {
            font-weight: 600 !important;
            color: #495057;
            margin-bottom: 0.5rem;
            display: block;
        }

        /* Modern Buttons */
        .reject-input-section .btn {
            border-radius: 10px;
            padding: 0.625rem 1.25rem;
            font-weight: 500;
            letter-spacing: 0.025em;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .reject-input-section .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .reject-input-section .btn:hover::before {
            left: 100%;
        }

        .reject-input-section .btn-danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border: none;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        }

        .reject-input-section .btn-danger:hover {
            background: linear-gradient(135deg, #c82333 0%, #a71e2a 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
        }

        .reject-input-section .btn-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
            border: none;
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
        }

        .reject-input-section .btn-secondary:hover {
            background: linear-gradient(135deg, #5a6268 0%, #495057 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.4);
        }

        /* Modern Alert Styling */
        .reject-input-section .alert {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            border-left: 4px solid #ffc107;
            box-shadow: 0 2px 10px rgba(255, 193, 7, 0.15);
        }

        .reject-input-section .alert-warning {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            color: #856404;
        }

        /* Modern Form Text */
        .reject-input-section .form-text {
            color: #6c757d;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            font-style: italic;
        }

        /* Smooth Animation for Show/Hide */
        .reject-input-section {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .reject-input-section[style*="display: block"] {
            opacity: 1;
            transform: translateY(0);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .reject-input-section {
                padding: 1rem;
                border-radius: 12px;
            }

            .reject-input-section .btn {
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
            }
        }

        /* Loading State Animation */
        .btn-loading {
            position: relative;
            color: transparent !important;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid transparent;
            border-top: 2px solid currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    <!-- JavaScript for Order Actions -->
    <script>


                        // Show Reject Input
        function showRejectInput(orderId) {
            console.log('showRejectInput called with orderId:', orderId);

            // Get current order status from the page
            const orderStatus = '{{ $order->status }}';
            const allowedStatuses = ['pending', 'processing', 'approved', 'rejected'];

            console.log('Current order status:', orderStatus);
            console.log('Allowed statuses:', allowedStatuses);

            // Check if order can be rejected
            if (!allowedStatuses.includes(orderStatus)) {
                alert('This order cannot be rejected. Only pending, processing, approved, and rejected orders can be rejected.');
                return;
            }

            // Show the reject input section
            const rejectSection = document.getElementById(`rejectInputSection_${orderId}`);
            if (rejectSection) {
                rejectSection.style.display = 'block';
                console.log('Reject input section displayed');

                // Focus on the textarea after showing
                setTimeout(() => {
                    const textarea = document.getElementById(`rejection_reason_${orderId}`);
                    if (textarea) {
                        textarea.focus();
                        console.log('Textarea focused:', textarea);
                        console.log('Textarea properties:', {
                            disabled: textarea.disabled,
                            readonly: textarea.readOnly,
                            style: textarea.style.cssText,
                            className: textarea.className
                        });
                    }
                }, 100);
            }
        }

        // Hide Reject Input
        function hideRejectInput(orderId) {
            const rejectSection = document.getElementById(`rejectInputSection_${orderId}`);
            if (rejectSection) {
                rejectSection.style.display = 'none';
                // Clear the textarea
                const textarea = document.getElementById(`rejection_reason_${orderId}`);
                if (textarea) {
                    textarea.value = '';
                }
                console.log('Reject input section hidden');
            }
        }

        // Validate Reject Form
        function validateRejectForm(form, orderId) {
            console.log('Form submission attempted for order:', orderId);
            console.log('Form data:', new FormData(form));

            const rejectionReason = form.querySelector('textarea[name="rejection_reason"]').value.trim();
            console.log('Rejection reason:', rejectionReason);

            if (!rejectionReason) {
                alert('Please provide a rejection reason.');
                return false;
            }

            console.log('Form validation passed, submitting...');
            return true;
        }










    </script>
@endsection
