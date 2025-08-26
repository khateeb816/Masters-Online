@extends('layouts.app')
@section('title', 'Brands - ' . config('app.name'))

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">
                <i class="zmdi zmdi-label mr-2"></i>Brand Management
            </h4>
            <a href="{{ route('brands.create') }}" class="btn btn-primary">
                <i class="zmdi zmdi-plus mr-1"></i>Add Brand
            </a>
        </div>
        <div class="card-body">
            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="card border-0 bg-primary text-white">
                        <div class="card-body text-center">
                            <i class="zmdi zmdi-label mb-2" style="font-size: 2rem;"></i>
                            <h5 class="mb-1">{{ $brands->count() }}</h5>
                            <small>Total Brands</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card border-0 bg-success text-white">
                        <div class="card-body text-center">
                            <i class="zmdi zmdi-check-circle mb-2" style="font-size: 2rem;"></i>
                            <h5 class="mb-1">{{ $brands->where('status', 'active')->count() }}</h5>
                            <small>Active Brands</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card border-0 bg-info text-white">
                        <div class="card-body text-center">
                            <i class="zmdi zmdi-inbox mb-2" style="font-size: 2rem;"></i>
                            <h5 class="mb-1">{{ $brands->sum(function($brand) { return $brand->inventories->count(); }) }}</h5>
                            <small>Total Products</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Brands Grid -->
            <div class="row">
                @foreach ($brands as $brand)
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                @if($brand->image)
                                    <div class="mx-auto" style="width: 60px; height: 60px;">
                                        <img src="{{ asset('uploads/' . $brand->image) }}"
                                             alt="{{ $brand->name }}"
                                             class="img-fluid rounded-circle"
                                             style="width: 60px; height: 60px; object-fit: cover; border: 2px solid #17a2b8;">
                                    </div>
                                @else
                                    <div class="bg-info rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                         style="width: 60px; height: 60px;">
                                        <i class="zmdi zmdi-label text-white" style="font-size: 1.5rem;"></i>
                                    </div>
                                @endif
                            </div>
                            <h5 class="card-title mb-2">{{ $brand->name }}</h5>
                            <div class="mb-3">
                                <span class="badge badge-{{ $brand->status === 'active' ? 'success' : 'secondary' }} badge-pill">
                                    <i class="zmdi zmdi-{{ $brand->status === 'active' ? 'check-circle' : 'close' }} mr-1"></i>
                                    {{ ucfirst($brand->status) }}
                                </span>
                            </div>
                            <div class="mb-3">
                                <small class="text-dark">
                                    <i class="zmdi zmdi-inbox mr-1"></i>{{ $brand->inventories->count() }} products
                                </small>
                            </div>
                            <div class="btn-group" role="group">
                                <a href="{{ route('brands.show', $brand->id) }}" class="btn btn-outline-primary btn-sm" title="View">
                                    <i class="zmdi zmdi-eye"></i>
                                </a>
                                <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-outline-warning btn-sm" title="Edit">
                                    <i class="zmdi zmdi-edit"></i>
                                </a>
                                <a href="{{ route('brands.delete', $brand->id) }}" class="btn btn-outline-danger btn-sm"
                                   onclick="return confirm('Are you sure you want to delete this brand?')" title="Delete">
                                    <i class="zmdi zmdi-delete"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
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
