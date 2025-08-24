@extends('layouts.app')
@section('title', 'Promo Codes - ' . config('app.name'))

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title">Promo Codes</h5>
                <a href="{{ route('promo-codes.create') }}" class="btn btn-primary">
                    <i class="zmdi zmdi-plus"></i> Add Promo Code
                </a>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table" id="table">
                    <thead>
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
                                <strong class="text-secondary">{{ $promoCode->code }}</strong>
                            </td>
                            <td>
                                <span class="badge badge-success">{{ $promoCode->discount_percentage }}%</span>
                            </td>
                            <td>
                                <div>
                                    <small class="text-dark">From: {{ $promoCode->start_date->format('M d, Y') }}</small><br>
                                    <small class="text-dark">To: {{ $promoCode->end_date->format('M d, Y') }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="badge {{ $promoCode->getStatusBadgeClass() }}">
                                    {{ $promoCode->getStatusText() }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-info">{{ $promoCode->orders->count() }} orders</span>
                            </td>
                            <td>
                                <a href="{{ route('promo-codes.show', $promoCode->id) }}" class="btn btn-primary btn-sm">
                                    <i class="zmdi zmdi-eye"></i> View
                                </a>
                                <a href="{{ route('promo-codes.edit', $promoCode->id) }}" class="btn btn-warning btn-sm">
                                    <i class="zmdi zmdi-edit"></i> Edit
                                </a>
                                <a href="{{ route('promo-codes.delete', $promoCode->id) }}" class="btn btn-danger btn-sm"
                                   onclick="return confirm('Are you sure you want to delete this promo code?')">
                                    <i class="zmdi zmdi-delete"></i> Delete
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
