@extends('layouts.app')
@section('title', 'Promo Code Details - ' . config('app.name'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Promo Code Details</h4>
                    <div>
                        <a href="{{ route('promo-codes.edit', $promoCode->id) }}" class="btn btn-warning btn-sm">
                            <i class="zmdi zmdi-edit"></i> Edit
                        </a>
                        <a href="{{ route('promo-codes.delete', $promoCode->id) }}" class="btn btn-danger btn-sm"
                           onclick="return confirm('Are you sure you want to delete this promo code?')">
                            <i class="zmdi zmdi-delete"></i> Delete
                        </a>
                        <a href="{{ route('promo-codes') }}" class="btn btn-secondary btn-sm">
                            <i class="zmdi zmdi-arrow-left"></i> Back to Promo Codes
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="promo-code-icon mb-3">
                                <div class="bg-gradient-primary rounded-circle d-flex align-items-center justify-content-center position-relative"
                                     style="width: 200px; height: 200px; margin: 0 auto; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <i class="zmdi zmdi-tag text-white" style="font-size: 120px;"></i>
                                </div>
                            </div>

                            <!-- Promo Code Status -->
                            <div class="promo-code-status mb-3">
                                <div class="d-flex justify-content-center gap-2">
                                    <span class="badge {{ $promoCode->getStatusBadgeClass() }} p-2">
                                        {{ $promoCode->getStatusText() }}
                                    </span>
                                </div>
                            </div>

                            <h3 class="text-primary">{{ $promoCode->code }}</h3>
                            <p class="text-muted">{{ $promoCode->description ?? 'No description available' }}</p>
                        </div>

                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="text-primary mb-3">
                                        <i class="zmdi zmdi-info mr-2"></i>Promo Code Information
                                    </h5>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong><i class="zmdi zmdi-tag mr-2"></i>Code:</strong></td>
                                            <td><span class="badge badge-primary p-2">{{ $promoCode->code }}</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong><i class="zmdi zmdi-description mr-2"></i>Description:</strong></td>
                                            <td>{{ $promoCode->description ?? 'No description provided' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong><i class="zmdi zmdi-money-off mr-2"></i>Discount:</strong></td>
                                            <td><span class="badge badge-success p-2">{{ $promoCode->discount_percentage }}%</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong><i class="zmdi zmdi-calendar mr-2"></i>Start Date:</strong></td>
                                            <td>{{ $promoCode->start_date->format('M d, Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong><i class="zmdi zmdi-time mr-2"></i>End Date:</strong></td>
                                            <td>{{ $promoCode->end_date->format('M d, Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong><i class="zmdi zmdi-check-circle mr-2"></i>Status:</strong></td>
                                            <td>
                                                <span class="badge {{ $promoCode->getStatusBadgeClass() }} p-2">
                                                    {{ $promoCode->getStatusText() }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong><i class="zmdi zmdi-calendar mr-2"></i>Created:</strong></td>
                                            <td>{{ $promoCode->created_at->format('M d, Y \a\t h:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong><i class="zmdi zmdi-time mr-2"></i>Last Updated:</strong></td>
                                            <td>{{ $promoCode->updated_at->format('M d, Y \a\t h:i A') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Validity Information -->
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h5 class="text-primary mb-3">
                                        <i class="zmdi zmdi-calendar-check mr-2"></i>Validity Information
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-center h-100">
                                                <div class="card-body d-flex flex-column justify-content-center">
                                                    <i class="zmdi zmdi-calendar text-primary mb-3" style="font-size: 2.5rem;"></i>
                                                    <h6 class="mb-2">Start Date</h6>
                                                    <p class="mb-1">{{ $promoCode->start_date->format('M d, Y') }}</p>
                                                    <small class="text-muted">{{ $promoCode->start_date->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-center h-100">
                                                <div class="card-body d-flex flex-column justify-content-center">
                                                    <i class="zmdi zmdi-time text-warning mb-3" style="font-size: 2.5rem;"></i>
                                                    <h6 class="mb-2">End Date</h6>
                                                    <p class="mb-1">{{ $promoCode->end_date->format('M d, Y') }}</p>
                                                    <small class="text-muted">{{ $promoCode->end_date->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-center h-100">
                                                <div class="card-body d-flex flex-column justify-content-center">
                                                    <i class="zmdi zmdi-shopping-cart text-info mb-3" style="font-size: 2.5rem;"></i>
                                                    <h6 class="mb-2">Usage Count</h6>
                                                    <p class="mb-1">{{ $promoCode->orders->count() }}</p>
                                                    <small class="text-muted">orders used this code</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Orders Using This Promo Code -->
                            @if($promoCode->orders->count() > 0)
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h5 class="text-primary mb-3">
                                        <i class="zmdi zmdi-shopping-cart mr-2"></i>Orders Using This Promo Code
                                    </h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Order #</th>
                                                    <th>Customer</th>
                                                    <th>Order Date</th>
                                                    <th>Total</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($promoCode->orders as $order)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('orders.show', $order->id) }}" class="text-primary">
                                                            {{ $order->order_number }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $order->user->first_name }} {{ $order->user->last_name }}</td>
                                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                    <td>${{ number_format($order->total / 100, 2) }}</td>
                                                    <td>
                                                        <span class="badge {{ $order->getStatusBadgeClass() }}">
                                                            {{ ucfirst($order->status) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
