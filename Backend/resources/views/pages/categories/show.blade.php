@extends('layouts.app')
@section('title', 'Category Details - ' . config('app.name'))
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">
                            <i class="zmdi zmdi-folder mr-2"></i>Category Details
                        </h4>
                        <div>
                            <a href="{{ route('categories.delete', $category->id) }}" class="btn btn-outline-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this category?')">
                                <i class="zmdi zmdi-delete"></i> Delete
                            </a>
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-outline-warning btn-sm">
                                <i class="zmdi zmdi-edit"></i> Edit
                            </a>
                            <a href="{{ route('categories') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="zmdi zmdi-arrow-left"></i> Back to Categories
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <div class="category-icon-container mb-3">
                                    @if ($category->image)
                                        <img src="{{ asset('uploads/' . $category->image) }}" alt="Category Image"
                                            class="img-fluid rounded"
                                            style="width: 200px; height: 200px; object-fit: cover;">
                                    @else
                                        <div class="bg-gradient-primary rounded d-flex align-items-center justify-content-center position-relative"
                                            style="width: 200px; height: 200px; margin: 0 auto; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                            <i class="zmdi zmdi-folder text-white" style="font-size: 120px;"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Category Status -->
                                <div class="category-status mb-3">
                                    <div class="d-flex justify-content-center gap-2">
                                        @if ($category->status == 'active')
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
                                <h3 class="text-primary">{{ $category->title }}</h3>
                                <p class="text-dark">{{ $category->description ?? 'No description available' }}</p>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 class="text-primary mb-3">
                                            <i class="zmdi zmdi-info mr-2"></i>Category Information
                                        </h5>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-folder mr-2"></i>Title:</strong></td>
                                                <td>{{ $category->title }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-description mr-2"></i>Description:</strong></td>
                                                <td>{{ $category->description ?? 'No description provided' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-check-circle mr-2"></i>Status:</strong></td>
                                                <td>
                                                    <span class="badge badge-{{ $category->status == 'active' ? 'success' : 'secondary' }} badge-pill">
                                                        <i class="zmdi zmdi-{{ $category->status == 'active' ? 'check-circle' : 'close' }} mr-1"></i>
                                                        {{ ucfirst($category->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-calendar mr-2"></i>Created:</strong></td>
                                                <td>{{ $category->created_at->format('M d, Y \a\t h:i A') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-time mr-2"></i>Last Updated:</strong></td>
                                                <td>{{ $category->updated_at->format('M d, Y \a\t h:i A') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <!-- Products in this Category -->
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <h5 class="text-primary mb-3">
                                            <i class="zmdi zmdi-inbox mr-2"></i>Products in this Category
                                        </h5>
                                        @if($category->inventories && $category->inventories->count() > 0)
                                            <div class="row">
                                                @foreach($category->inventories->take(6) as $inventory)
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
                                                                            <i class="zmdi zmdi-inbox text-dark"></i>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <h6 class="mb-1">{{ $inventory->name }}</h6>
                                                                    <small class="text-dark">${{ number_format($inventory->price / 100, 2) }}</small>
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
                                            @if($category->inventories->count() > 6)
                                                <div class="text-center mt-3">
                                                    <small class="text-dark">Showing 6 of {{ $category->inventories->count() }} products</small>
                                                </div>
                                            @endif
                                        @else
                                            <div class="text-center py-4">
                                                <i class="zmdi zmdi-inbox text-dark" style="font-size: 3rem;"></i>
                                                <h5 class="text-dark mt-3">No Products Yet</h5>
                                                <p class="text-dark mb-0">This category doesn't have any products yet.</p>
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
