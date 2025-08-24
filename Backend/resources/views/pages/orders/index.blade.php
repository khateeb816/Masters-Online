@extends('layouts.app')
@section('title', 'Orders - ' . config('app.name'))

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">
                    <i class="zmdi zmdi-shopping-cart mr-2"></i>Order Management
                </h4>
                <div>
                    <span class="badge badge-primary badge-pill">{{ $orders->count() }} Total Orders</span>
                </div>
            </div>
            <div class="card-body">
                <!-- Stats Cards -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card border-0 bg-primary text-white">
                            <div class="card-body text-center">
                                <i class="zmdi zmdi-shopping-cart mb-2" style="font-size: 2rem;"></i>
                                <h5 class="mb-1">{{ $orders->count() }}</h5>
                                <small>Total Orders</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card border-0 bg-success text-white">
                            <div class="card-body text-center">
                                <i class="zmdi zmdi-check-circle mb-2" style="font-size: 2rem;"></i>
                                <h5 class="mb-1">{{ $orders->whereIn('status', ['delivered', 'approved'])->count() }}</h5>
                                <small>Completed</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card border-0 bg-warning text-white">
                            <div class="card-body text-center">
                                <i class="zmdi zmdi-time mb-2" style="font-size: 2rem;"></i>
                                <h5 class="mb-1">{{ $orders->whereIn('status', ['pending', 'processing', 'shipped'])->count() }}</h5>
                                <small>In Progress</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card border-0 bg-danger text-white">
                            <div class="card-body text-center">
                                <i class="zmdi zmdi-close mb-2" style="font-size: 2rem;"></i>
                                <h5 class="mb-1">{{ $orders->whereIn('status', ['rejected', 'cancelled'])->count() }}</h5>
                                <small>Rejected/Cancelled</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card border-0 bg-info text-white">
                            <div class="card-body text-center">
                                <i class="zmdi zmdi-money mb-2" style="font-size: 2rem;"></i>
                                <h5 class="mb-1">${{ number_format($orders->sum('total') / 100, 2) }}</h5>
                                <small>Total Revenue</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Orders Table -->
                <div class="table-responsive">
                    <table class="table table-hover" id="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Order #</th>
                                <th scope="col">Customer</th>
                                <th scope="col">Items</th>
                                <th scope="col">Total</th>
                                <th scope="col">Status</th>
                                <th scope="col">Payment</th>
                                <th scope="col">Date</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center"
                                                     style="width: 40px; height: 40px;">
                                                    <i class="zmdi zmdi-shopping-cart text-white"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <strong>{{ $order->order_number }}</strong>
                                                <br>
                                                <small class="text-dark">#{{ $order->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <h6 class="mb-1">{{ $order->user->first_name }} {{ $order->user->last_name }}</h6>
                                            <small class="text-dark">
                                                <i class="zmdi zmdi-email mr-1"></i>{{ $order->user->email }}
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <span class="badge badge-info badge-pill">
                                                <i class="zmdi zmdi-inbox mr-1"></i>{{ $order->orderDetails->count() }} items
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <h6 class="mb-1 text-primary">${{ number_format($order->total / 100, 2) }}</h6>
                                            @if($order->promoCode)
                                                <small class="text-success">
                                                    <i class="zmdi zmdi-tag mr-1"></i>{{ $order->promoCode->code }}
                                                </small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $order->getStatusBadgeClass() }} badge-pill">
                                            <i class="zmdi zmdi-{{
                                                $order->status === 'delivered' ? 'check-circle' :
                                                ($order->status === 'processing' ? 'time' :
                                                ($order->status === 'shipped' ? 'local-shipping' :
                                                ($order->status === 'approved' ? 'check-circle' :
                                                ($order->status === 'rejected' ? 'close' : 'close'))))
                                            }} mr-1"></i>
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $order->getPaymentStatusBadgeClass() }} badge-pill">
                                            <i class="zmdi zmdi-{{ $order->payment_status === 'paid' ? 'check-circle' : 'time' }} mr-1"></i>
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div>
                                            <small class="text-dark">{{ $order->created_at->format('M d, Y') }}</small>
                                            <br>
                                            <small class="text-dark">{{ $order->created_at->format('h:i A') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-primary btn-sm" title="View Details">
                                            <i class="zmdi zmdi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>
    <script>
        new DataTable('#table');
    </script>
@endsection
