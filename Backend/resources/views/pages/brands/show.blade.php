@extends('layouts.app')
@section('title', 'Brand Details - ' . config('app.name'))
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">
                            <i class="zmdi zmdi-label mr-2"></i>Brand Details
                        </h4>
                        <div>
                            <a href="{{ route('brands.delete', $brand->id) }}" class="btn btn-outline-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this brand?')">
                                <i class="zmdi zmdi-delete"></i> Delete
                            </a>
                            <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-outline-warning btn-sm">
                                <i class="zmdi zmdi-edit"></i> Edit
                            </a>
                            <a href="{{ route('brands') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="zmdi zmdi-arrow-left"></i> Back to Brands
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <div class="brand-icon-container mb-3">
                                    @if ($brand->image)
                                        <img src="{{ asset('uploads/' . $brand->image) }}" alt="Brand Image"
                                            class="img-fluid rounded"
                                            style="width: 200px; height: 200px; object-fit: cover;">
                                    @else
                                        <div class="bg-gradient-primary rounded d-flex align-items-center justify-content-center position-relative"
                                            style="width: 200px; height: 200px; margin: 0 auto; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                            <i class="zmdi zmdi-label text-white" style="font-size: 120px;"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Brand Status -->
                                <div class="brand-status mb-3">
                                    <div class="d-flex justify-content-center gap-2">
                                        @if ($brand->status == 'active')
                                            <span class="badge badge-success badge-pill d-flex align-items-center">
                                                <i class="zmdi zmdi-check-circle mr-1"></i> Active
                                            </span>
                                        @else
                                            <span class="badge badge-secondary badge-pill d-flex align-items-center">
                                                <i class="zmdi zmdi-close mr-1"></i> Inactive
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <h3 class="text-info">{{ $brand->name }}</h3>
                                <p class="text-muted">{{ $brand->description ?? 'No description available' }}</p>

                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 class="text-primary mb-3">
                                            <i class="zmdi zmdi-info mr-2"></i>Brand Information
                                        </h5>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-label mr-2"></i>Name:</strong></td>
                                                <td>{{ $brand->name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-description mr-2"></i>Description:</strong></td>
                                                <td>{{ $brand->description ?? 'No description provided' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-check-circle mr-2"></i>Status:</strong></td>
                                                <td>
                                                    <span class="badge badge-{{ $brand->status == 'active' ? 'success' : 'secondary' }} badge-pill">
                                                        <i class="zmdi zmdi-{{ $brand->status == 'active' ? 'check-circle' : 'close' }} mr-1"></i>
                                                        {{ ucfirst($brand->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-calendar mr-2"></i>Created:</strong></td>
                                                <td>{{ $brand->created_at->format('M d, Y \a\t h:i A') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-time mr-2"></i>Last Updated:</strong></td>
                                                <td>{{ $brand->updated_at->format('M d, Y \a\t h:i A') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <!-- Products by this Brand -->
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <h5 class="text-primary mb-3">
                                            <i class="zmdi zmdi-inbox mr-2"></i>Products by this Brand
                                        </h5>
                                        @if($brand->inventories && $brand->inventories->count() > 0)
                                            <div class="row">
                                                @foreach($brand->inventories->take(6) as $inventory)
                                                <div class="col-md-6 mb-3">
                                                    <div class="card border-0 shadow-sm">
                                                        <div class="card-body">
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
                                                                            <i class="zmdi zmdi-inbox text-muted"></i>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <h6 class="mb-1">{{ $inventory->name }}</h6>
                                                                    <small class="text-muted">${{ number_format($inventory->price / 100, 2) }}</small>
                                                                </div>
                                                                <div class="text-right">
                                                                    <span class="badge badge-{{ $inventory->status == 'active' ? 'success' : 'secondary' }} badge-pill">
                                                                        {{ ucfirst($inventory->status) }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            @if($brand->inventories->count() > 6)
                                                <div class="text-center mt-3">
                                                    <small class="text-muted">Showing 6 of {{ $brand->inventories->count() }} products</small>
                                                </div>
                                            @endif
                                        @else
                                            <div class="text-center py-4">
                                                <i class="zmdi zmdi-inbox text-muted" style="font-size: 3rem;"></i>
                                                <h5 class="text-muted mt-3">No Products Yet</h5>
                                                <p class="text-muted mb-0">This brand doesn't have any products yet.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
