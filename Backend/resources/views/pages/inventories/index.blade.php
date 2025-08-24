@extends('layouts.app')
@section('title', 'Inventories - ' . config('app.name'))

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">
                <i class="zmdi zmdi-inbox mr-2"></i>Product Management
            </h4>
            <a href="{{ route('inventories.create') }}" class="btn btn-primary">
                <i class="zmdi zmdi-plus mr-1"></i>Add Product
            </a>
        </div>
        <div class="card-body">
            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card border-0 bg-primary text-white">
                        <div class="card-body text-center">
                            <i class="zmdi zmdi-inbox mb-2" style="font-size: 2rem;"></i>
                            <h5 class="mb-1">{{ $inventories->count() }}</h5>
                            <small>Total Products</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-0 bg-success text-white">
                        <div class="card-body text-center">
                            <i class="zmdi zmdi-check-circle mb-2" style="font-size: 2rem;"></i>
                            <h5 class="mb-1">{{ $inventories->where('status', 'active')->count() }}</h5>
                            <small>Active Products</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-0 bg-warning text-white">
                        <div class="card-body text-center">
                            <i class="zmdi zmdi-alert-triangle mb-2" style="font-size: 2rem;"></i>
                            <h5 class="mb-1">{{ $inventories->where('stock_quantity', '<', 10)->count() }}</h5>
                            <small>Low Stock</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-0 bg-info text-white">
                        <div class="card-body text-center">
                            <i class="zmdi zmdi-money mb-2" style="font-size: 2rem;"></i>
                            <h5 class="mb-1">${{ number_format($inventories->sum('price') / 100, 2) }}</h5>
                            <small>Total Value</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Table -->
            <div class="table-responsive">
                <table class="table table-hover" id="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product</th>
                            <th scope="col">Category</th>
                            <th scope="col">Brand</th>
                            <th scope="col">Pricing</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inventories as $inventory)
                        <tr>
                            <td>{{ $inventory->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="mr-3">
                                        @if($inventory->images)
                                            @php
                                                $imageArray = json_decode($inventory->images, true);
                                                $firstImage = is_array($imageArray) ? $imageArray[0] : $inventory->images;
                                            @endphp
                                            <img src="{{ asset('uploads/' . $firstImage) }}"
                                                 alt="{{ $inventory->name }}"
                                                 class="rounded"
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                 style="width: 50px; height: 50px;">
                                                <i class="zmdi zmdi-inbox text-dark"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $inventory->name }}</h6>
                                        <small class="text-dark">{{ Str::limit($inventory->description, 50) }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-secondary badge-pill">
                                    {{ $inventory->category->title ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-info badge-pill">
                                    {{ $inventory->brand->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <div>
                                    <div class="mb-1">
                                        <strong>${{ number_format($inventory->price / 100, 2) }}</strong>
                                    </div>
                                    @if($inventory->discounted_price)
                                        <small class="text-success">
                                            <i class="zmdi zmdi-tag mr-1"></i>
                                            ${{ number_format($inventory->discounted_price / 100, 2) }}
                                        </small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="mr-2">
                                        @if($inventory->stock_quantity > 20)
                                            <i class="zmdi zmdi-check-circle text-success"></i>
                                        @elseif($inventory->stock_quantity > 10)
                                            <i class="zmdi zmdi-time text-warning"></i>
                                        @else
                                            <i class="zmdi zmdi-alert-triangle text-danger"></i>
                                        @endif
                                    </div>
                                    <span class="{{ $inventory->stock_quantity < 10 ? 'text-danger font-weight-bold' : '' }}">
                                        {{ $inventory->stock_quantity }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-{{ $inventory->status === 'active' ? 'success' : 'secondary' }} badge-pill">
                                    <i class="zmdi zmdi-{{ $inventory->status === 'active' ? 'check-circle' : 'close' }} mr-1"></i>
                                    {{ ucfirst($inventory->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('inventories.show', $inventory->id) }}" class="btn btn-outline-primary btn-sm" title="View">
                                        <i class="zmdi zmdi-eye"></i>
                                    </a>
                                    <a href="{{ route('inventories.edit', $inventory->id) }}" class="btn btn-outline-warning btn-sm" title="Edit">
                                        <i class="zmdi zmdi-edit"></i>
                                    </a>
                                    <a href="{{ route('inventories.delete', $inventory->id) }}" class="btn btn-outline-danger btn-sm"
                                       onclick="return confirm('Are you sure you want to delete this product?')" title="Delete">
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
