@extends('layouts.app')
@section('title', 'User Details - ' . config('app.name'))
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">User Details</h4>
                        <div>
                            <a href="{{ route('users.delete', $user->id) }}" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this user?')">
                                <i class="zmdi zmdi-delete"></i> Delete
                            </a>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                <i class="zmdi zmdi-edit"></i> Edit
                            </a>
                            <a href="{{ route('users') }}" class="btn btn-secondary btn-sm">
                                <i class="zmdi zmdi-arrow-left"></i> Back to Users
                            </a>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <div class="profile-picture-container mb-3">
                                    @if ($user->profile_picture)
                                        <img src="{{ asset('uploads/' . $user->profile_picture) }}" alt="Profile Picture"
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
                                        @if ($user->status == 'active')
                                            <span class="badge badge-success d-flex align-items-center">
                                                <i class="zmdi zmdi-check-circle mr-1"></i> Active
                                            </span>
                                        @else
                                            <span class="badge badge-danger d-flex align-items-center">
                                                <i class="zmdi zmdi-close-circle mr-1"></i> Inactive
                                            </span>
                                        @endif

                                        @if ($user->role == 'admin')
                                            <span class="badge badge-primary d-flex align-items-center">
                                                <i class="zmdi zmdi-shield-security mr-1"></i> Admin
                                            </span>
                                        @elseif($user->role == 'manager')
                                            <span class="badge badge-info d-flex align-items-center">
                                                <i class="zmdi zmdi-account-star mr-1"></i> Manager
                                            </span>
                                        @else
                                            <span class="badge badge-secondary d-flex align-items-center">
                                                <i class="zmdi zmdi-account mr-1"></i> User
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <h3>{{ $user->first_name }} {{ $user->last_name }}</h3>
                                <p class="text-muted">{{ ucfirst($user->role) }}</p>
                                <span class="badge badge-{{ $user->status == 'active' ? 'success' : 'danger' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 class="text-primary">
                                            <i class="zmdi zmdi-account-box mr-2"></i>Personal Information
                                        </h5>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-account mr-2"></i>First Name:</strong></td>
                                                <td>{{ $user->first_name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-account mr-2"></i>Last Name:</strong></td>
                                                <td>{{ $user->last_name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-account-add mr-2"></i>Username:</strong>
                                                </td>
                                                <td>{{ $user->username }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-email mr-2"></i>Email:</strong></td>
                                                <td>{{ $user->email }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-phone mr-2"></i>Phone:</strong></td>
                                                <td>{{ $user->phone ?? 'Not provided' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <h5 class="text-primary">
                                            <i class="zmdi zmdi-settings mr-2"></i>Account Information
                                        </h5>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-shield-security mr-2"></i>Role:</strong>
                                                </td>
                                                <td>{{ ucfirst($user->role) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-check-circle mr-2"></i>Status:</strong></td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $user->status == 'active' ? 'success' : 'danger' }}">
                                                        {{ ucfirst($user->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-calendar mr-2"></i>Created:</strong></td>
                                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="zmdi zmdi-time mr-2"></i>Last Updated:</strong></td>
                                                <td>{{ $user->updated_at->format('M d, Y') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    @if ($user->profile_id)
                                        @php
                                            $profile = App\Models\Profile::find($user->profile_id);
                                        @endphp
                                        @if ($profile)
                                            <hr>
                                            <div class="row">
                                                <div class="col-12">
                                                    <h5 class="text-primary">
                                                        <i class="zmdi zmdi-card mr-2"></i>Profile Information
                                                    </h5>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <table class="table table-borderless">
                                                                <tr>
                                                                    <td><strong><i class="zmdi zmdi-home mr-2"></i>Address
                                                                            Line 1:</strong></td>
                                                                    <td>{{ $profile->address_line_1 ?? 'Not provided' }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong><i class="zmdi zmdi-home mr-2"></i>Address
                                                                            Line 2:</strong></td>
                                                                    <td>{{ $profile->address_line_2 ?? 'Not provided' }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong><i
                                                                                class="zmdi zmdi-city mr-2"></i>City:</strong>
                                                                    </td>
                                                                    <td>{{ $profile->city ?? 'Not provided' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong><i
                                                                                class="zmdi zmdi-pin mr-2"></i>State:</strong>
                                                                    </td>
                                                                    <td>{{ $profile->state ?? 'Not provided' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong><i
                                                                                class="zmdi zmdi-globe mr-2"></i>Country:</strong>
                                                                    </td>
                                                                    <td>{{ $profile->country ?? 'Not provided' }}</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <table class="table table-borderless">
                                                                <tr>
                                                                    <td><strong><i class="zmdi zmdi-pin-drop mr-2"></i>ZIP
                                                                            Code:</strong></td>
                                                                    <td>{{ $profile->zip ?? 'Not provided' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong><i
                                                                                class="zmdi zmdi-phone-in-talk mr-2"></i>Alternative
                                                                            Phone:</strong></td>
                                                                    <td>{{ $profile->alternative_phone ?? 'Not provided' }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong><i class="zmdi zmdi-cake mr-2"></i>Date of
                                                                            Birth:</strong></td>
                                                                    <td>{{ $profile->date_of_birth ? \Carbon\Carbon::parse($profile->date_of_birth)->format('M d, Y') : 'Not provided' }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong><i
                                                                                class="zmdi zmdi-face mr-2"></i>Gender:</strong>
                                                                    </td>
                                                                    <td>{{ $profile->gender ? ucfirst($profile->gender) : 'Not provided' }}
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
