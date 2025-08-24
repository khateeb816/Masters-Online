@extends('layouts.app')
@section('title', 'Inventory Details - ' . config('app.name'))
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Inventory Details</h4>
                        <div>
                            <a href="{{ route('inventories.delete', $inventory->id) }}" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this inventory?')">
                                <i class="zmdi zmdi-delete"></i> Delete
                            </a>
                            <a href="{{ route('inventories.edit', $inventory->id) }}" class="btn btn-warning btn-sm">
                                <i class="zmdi zmdi-edit"></i> Edit
                            </a>
                            <a href="{{ route('inventories') }}" class="btn btn-secondary btn-sm">
                                <i class="zmdi zmdi-arrow-left"></i> Back to Inventories
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <div class="inventory-image-container mb-3">
                                    @if ($inventory->images)
                                        @php
                                            $imageArray = json_decode($inventory->images, true);
                                        @endphp
                                        @if(is_array($imageArray) && count($imageArray) > 0)
                                            <div id="inventoryImageCarousel" class="carousel slide" data-ride="carousel">
                                                <div class="carousel-inner">
                                                    @foreach($imageArray as $index => $image)
                                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                            <img src="{{ asset('uploads/' . $image) }}" alt="Inventory Image {{ $index + 1 }}"
                                                                class="img-fluid rounded"
                                                                style="width: 200px; height: 200px; object-fit: cover;">
                                                        </div>
                                                    @endforeach
                                                </div>
                                                @if(count($imageArray) > 1)
                                                    <a class="carousel-control-prev" href="#inventoryImageCarousel" role="button" data-slide="prev">
                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                        <span class="sr-only">Previous</span>
                                                    </a>
                                                    <a class="carousel-control-next" href="#inventoryImageCarousel" role="button" data-slide="next">
                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                        <span class="sr-only">Next</span>
                                                    </a>
                                                @endif
                                            </div>
                                        @else
                                            <img src="{{ asset('uploads/' . $inventory->images) }}" alt="Inventory Image"
                                                class="img-fluid rounded"
                                                style="width: 200px; height: 200px; object-fit: cover;">
                                        @endif
                                    @else
                                        <div class="bg-gradient-primary rounded d-flex align-items-center justify-content-center position-relative"
                                            style="width: 200px; height: 200px; margin: 0 auto; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                            <i class="zmdi zmdi-inbox text-white" style="font-size: 120px;"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Inventory Status -->
                                <div class="inventory-status mb-3">
                                    <div class="d-flex justify-content-center gap-2">
                                        @if ($inventory->status == 'active')
                                            <span class="badge badge-success d-flex align-items-center">
                                                <i class="zmdi zmdi-check-circle mr-1"></i> Active
                                            </span>
                                        @else
                                            <span class="badge badge-danger d-flex align-items-center">
                                                <i class="zmdi zmdi-close-circle mr-1"></i> Inactive
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <h3>{{ $inventory->name ?? 'Inventory Item' }}</h3>
                                <p class="text-muted">{{ $inventory->description ?? 'No description available' }}</p>
                            </div>

                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 class="text-primary">
                                            <i class="zmdi zmdi-inbox mr-2"></i>Inventory Information
                                        </h5>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-label mr-2"></i>Name:</strong></td>
                                                <td>{{ $inventory->name ?? 'Not provided' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-money mr-2"></i>Price:</strong></td>
                                                <td>${{ number_format($inventory->price, 2) ?? 'Not provided' }}</td>
                                            </tr>
                                            @if($inventory->discounted_price)
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-money-off mr-2"></i>Discounted Price:</strong></td>
                                                <td>${{ number_format($inventory->discounted_price, 2) }}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-collection-box mr-2"></i>Stock Quantity:</strong></td>
                                                <td>{{ $inventory->stock_quantity ?? 'Not provided' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-check-circle mr-2"></i>Status:</strong></td>
                                                <td>
                                                    <span class="badge badge-{{ $inventory->status == 'active' ? 'success' : 'danger' }}">
                                                        {{ ucfirst($inventory->status ?? 'unknown') }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-calendar mr-2"></i>Created:</strong></td>
                                                <td>{{ $inventory->created_at ? $inventory->created_at->format('M d, Y') : 'Not provided' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-time mr-2"></i>Last Updated:</strong></td>
                                                <td>{{ $inventory->updated_at ? $inventory->updated_at->format('M d, Y') : 'Not provided' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <!-- Category and Brand Information -->
                                @if($inventory->category || $inventory->brand)
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <h5 class="text-primary">
                                            <i class="zmdi zmdi-tag mr-2"></i>Category & Brand
                                        </h5>
                                        <div class="row">
                                            @if($inventory->category)
                                            <div class="col-md-6">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td><strong><i class="zmdi zmdi-folder mr-2"></i>Category:</strong></td>
                                                        <td>{{ $inventory->category->title ?? 'Not provided' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            @endif

                                            @if($inventory->brand)
                                            <div class="col-md-6">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td><strong><i class="zmdi zmdi-label mr-2"></i>Brand:</strong></td>
                                                        <td>{{ $inventory->brand->name ?? 'Not provided' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            @endif
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

        <!-- Reviews Section -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">
                            <i class="zmdi zmdi-star mr-2"></i>Customer Reviews
                        </h4>
                        <div>
                            <span class="badge badge-primary">{{ $inventory->reviews->count() }} reviews</span>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($inventory->reviews->count() > 0)
                            <div class="row">
                                @foreach($inventory->reviews as $review)
                                <div class="col-md-6 mb-3">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="mr-3">
                                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center"
                                                             style="width: 45px; height: 45px;">
                                                            <i class="zmdi zmdi-account text-white"></i>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-1 font-weight-bold">{{ $review->user->first_name }} {{ $review->user->last_name }}</h6>
                                                        <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                                                    </div>
                                                </div>
                                                <div>
                                                    <span class="badge badge-warning badge-pill">
                                                        <i class="zmdi zmdi-star mr-1"></i>{{ $review->rating }}/5
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="bg-light p-3 rounded mb-3">
                                                <p class="mb-0 text-dark">{{ $review->comment }}</p>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge badge-{{ $review->status == 'active' ? 'success' : 'secondary' }} badge-pill">
                                                    {{ ucfirst($review->status) }}
                                                </span>
                                                <small class="text-muted">Review #{{ $review->id }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="zmdi zmdi-star-outline text-muted" style="font-size: 4rem;"></i>
                                <h5 class="text-muted mt-3">No Reviews Yet</h5>
                                <p class="text-muted mb-0">This product hasn't received any reviews yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information Section -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            <i class="zmdi zmdi-info mr-2"></i>Additional Information
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="card border-0 bg-primary text-white text-center h-100">
                                    <div class="card-body d-flex flex-column justify-content-center">
                                        <i class="zmdi zmdi-shopping-cart mb-3" style="font-size: 2.5rem;"></i>
                                        <h6 class="mb-2">Order History</h6>
                                        <p class="mb-0 opacity-75">This item has been ordered multiple times</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card border-0 bg-danger text-white text-center h-100">
                                    <div class="card-body d-flex flex-column justify-content-center">
                                        <i class="zmdi zmdi-favorite mb-3" style="font-size: 2.5rem;"></i>
                                        <h6 class="mb-2">Wishlist</h6>
                                        <p class="mb-0 opacity-75">Added to {{ $inventory->wishLists->count() ?? 0 }} wishlists</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card border-0 bg-success text-white text-center h-100">
                                    <div class="card-body d-flex flex-column justify-content-center">
                                        <i class="zmdi zmdi-chart mb-3" style="font-size: 2.5rem;"></i>
                                        <h6 class="mb-2">Performance</h6>
                                        <p class="mb-0 opacity-75">Based on sales and reviews</p>
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
