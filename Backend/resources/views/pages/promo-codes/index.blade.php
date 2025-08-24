@extends('layouts.app')
@section('title', 'Promo Codes - ' . config('app.name'))

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">
                <i class="zmdi zmdi-ticket-star mr-2"></i>Promo Code Management
            </h4>
            <a href="{{ route('promo-codes.create') }}" class="btn btn-primary">
                <i class="zmdi zmdi-plus mr-1"></i>Add Promo Code
            </a>
        </div>
        <div class="card-body">
            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card border-0 bg-primary text-white">
                        <div class="card-body text-center">
                            <i class="zmdi zmdi-ticket-star mb-2" style="font-size: 2rem;"></i>
                            <h5 class="mb-1">{{ $promoCodes->count() }}</h5>
                            <small>Total Codes</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-0 bg-success text-white">
                        <div class="card-body text-center">
                            <i class="zmdi zmdi-check-circle mb-2" style="font-size: 2rem;"></i>
                            <h5 class="mb-1">{{ $promoCodes->where('status', 'active')->count() }}</h5>
                            <small>Active Codes</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-0 bg-warning text-white">
                        <div class="card-body text-center">
                            <i class="zmdi zmdi-time mb-2" style="font-size: 2rem;"></i>
                            <h5 class="mb-1">{{ $promoCodes->where('status', 'inactive')->count() }}</h5>
                            <small>Inactive Codes</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-0 bg-info text-white">
                        <div class="card-body text-center">
                            <i class="zmdi zmdi-shopping-cart mb-2" style="font-size: 2rem;"></i>
                            <h5 class="mb-1">{{ $promoCodes->sum(function($code) { return $code->orders->count(); }) }}</h5>
                            <small>Total Usage</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Promo Codes Table -->
            <div class="table-responsive">
                <table class="table table-hover" id="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Code</th>
                            <th scope="col">Discount</th>
                            <th scope="col">Validity</th>
                            <th scope="col">Status</th>
                            <th scope="col">Usage</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($promoCodes as $promoCode)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="mr-3">
                                        <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center"
                                             style="width: 40px; height: 40px;">
                                            <i class="zmdi zmdi-ticket-star text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-secondary">{{ $promoCode->code }}</h6>
                                        <small class="text-dark">{{ Str::limit($promoCode->description, 30) }}</small>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="text-center">
                                    <span class="badge badge-success badge-pill">
                                        <i class="zmdi zmdi-percent mr-1"></i>{{ $promoCode->discount_percentage }}% OFF
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div class="mb-1">
                                        <small class="text-dark">
                                            <i class="zmdi zmdi-calendar mr-1"></i>{{ $promoCode->start_date->format('M d, Y') }}
                                        </small>
                                    </div>
                                    <div>
                                        <small class="text-dark">
                                            <i class="zmdi zmdi-time mr-1"></i>{{ $promoCode->end_date->format('M d, Y') }}
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-{{ $promoCode->getStatusBadgeClass() }} badge-pill">
                                    <i class="zmdi zmdi-{{ $promoCode->status === 'active' ? 'check-circle' : 'close' }} mr-1"></i>
                                    {{ $promoCode->getStatusText() }}
                                </span>
                            </td>
                            <td>
                                <div class="text-center">
                                    <span class="badge badge-info badge-pill">
                                        <i class="zmdi zmdi-shopping-cart mr-1"></i>{{ $promoCode->orders->count() }} orders
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('promo-codes.show', $promoCode->id) }}" class="btn btn-outline-primary btn-sm" title="View">
                                        <i class="zmdi zmdi-eye"></i>
                                    </a>
                                    <a href="{{ route('promo-codes.edit', $promoCode->id) }}" class="btn btn-outline-warning btn-sm" title="Edit">
                                        <i class="zmdi zmdi-edit"></i>
                                    </a>
                                    <a href="{{ route('promo-codes.delete', $promoCode->id) }}" class="btn btn-outline-danger btn-sm"
                                       onclick="return confirm('Are you sure you want to delete this promo code?')" title="Delete">
                                        <i class="zmdi zmdi-delete"></i>
                                    </a>
                                </div>
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
