@extends('layouts.app')
@section('title', 'Brand Details - ' . config('app.name'))
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Brand Details</h4>
                        <div>
                            <a href="{{ route('brands.delete', $brand->id) }}" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this brand?')">
                                <i class="zmdi zmdi-delete"></i> Delete
                            </a>
                            <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-warning btn-sm">
                                <i class="zmdi zmdi-edit"></i> Edit
                            </a>
                            <a href="{{ route('brands') }}" class="btn btn-secondary btn-sm">
                                <i class="zmdi zmdi-arrow-left"></i> Back to Brands
                            </a>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <div class="profile-picture-container mb-3">
                                    @if ($brand->image)
                                        <img src="{{ asset('uploads/' . $brand->image) }}" alt="Image"
                                            class="img-fluid rounded-circle"
                                            style="width: 200px; height: 200px; object-fit: cover;">
                                    @else
                                        <div class="bg-gradient-primary rounded-circle d-flex align-items-center justify-content-center position-relative"
                                            style="width: 200px; height: 200px; margin: 0 auto; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                            <i class="zmdi zmdi-account-circle text-white" style="font-size: 120px;"></i>
                                            <div class="position-absolute bottom-0 end-0 bg-success rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 40px; border: 3px solid white;">
                                                <i class="zmdi zmdi-check text-white" style="font-size: 16px;"></i>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- User Status Icons -->
                                <div class="user-status-icons mb-3">
                                    <div class="d-flex justify-content-center gap-2">
                                        @if ($brand->status == 'active')
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
                                <h3>{{ $brand->name }}</h3>
                                <p class="text-muted">{{ ucfirst($brand->description) }}</p>

                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 class="text-primary">
                                            <i class="zmdi zmdi-account-box mr-2"></i>Brand Information
                                        </h5>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-account mr-2"></i>Name:</strong></td>
                                                <td>{{ $brand->name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-account mr-2"></i>Description:</strong></td>
                                                <td>{{ $brand->description }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-account-add mr-2"></i>Status:</strong>
                                                </td>
                                                <td>{{ $brand->status }}</td>
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
    @endsection
