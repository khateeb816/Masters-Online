@extends('layouts.app')
@section('title', 'Users - ' . config('app.name'))

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">
                <i class="zmdi zmdi-account-circle mr-2"></i>Users Management
            </h4>
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i class="zmdi zmdi-plus mr-1"></i>Add User
            </a>
        </div>
        <div class="card-body">
            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card border-0 bg-primary text-white">
                        <div class="card-body text-center">
                            <i class="zmdi zmdi-account-circle mb-2" style="font-size: 2rem;"></i>
                            <h5 class="mb-1">{{ $users->count() }}</h5>
                            <small>Total Users</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-0 bg-success text-white">
                        <div class="card-body text-center">
                            <i class="zmdi zmdi-check-circle mb-2" style="font-size: 2rem;"></i>
                            <h5 class="mb-1">{{ $users->where('status', 'active')->count() }}</h5>
                            <small>Active Users</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-0 bg-warning text-white">
                        <div class="card-body text-center">
                            <i class="zmdi zmdi-time mb-2" style="font-size: 2rem;"></i>
                            <h5 class="mb-1">{{ $users->where('status', 'inactive')->count() }}</h5>
                            <small>Inactive Users</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-0 bg-info text-white">
                        <div class="card-body text-center">
                            <i class="zmdi zmdi-calendar mb-2" style="font-size: 2rem;"></i>
                            <h5 class="mb-1">{{ $users->where('created_at', '>=', now()->subDays(30))->count() }}</h5>
                            <small>New This Month</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users Table -->
            <div class="table-responsive">
                <table class="table table-hover" id="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">S.No</th>
                            <th scope="col">User</th>
                            <th scope="col">Contact</th>
                            <th scope="col">Role</th>
                            <th scope="col">Status</th>
                            <th scope="col">Joined</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="mr-3">
                                        @if($user->profile_picture)
                                            <img src="{{ asset('uploads/' . $user->profile_picture) }}"
                                                 alt="{{ $user->first_name }}"
                                                 class="rounded-circle"
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center"
                                                 style="width: 40px; height: 40px;">
                                                <i class="zmdi zmdi-account text-white"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $user->first_name }} {{ $user->last_name }}</h6>
                                        <small class="text-dark">@/{{ $user->username }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div class="mb-1">
                                        <i class="zmdi zmdi-email text-dark mr-1"></i>
                                        <small>{{ $user->email }}</small>
                                    </div>
                                    @if($user->phone)
                                    <div>
                                        <i class="zmdi zmdi-phone text-dark mr-1"></i>
                                        <small>{{ $user->phone }}</small>
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-{{ $user->role === 'admin' ? 'danger' : 'secondary' }} badge-pill">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $user->status === 'active' ? 'success' : 'warning' }} badge-pill">
                                    <i class="zmdi zmdi-{{ $user->status === 'active' ? 'check-circle' : 'time' }} mr-1"></i>
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>
                            <td>
                                <small class="text-dark">{{ $user->created_at->format('M d, Y') }}</small>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-outline-primary btn-sm" title="View">
                                        <i class="zmdi zmdi-eye"></i>
                                    </a>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline-warning btn-sm" title="Edit">
                                        <i class="zmdi zmdi-edit"></i>
                                    </a>
                                    <a href="{{ route('users.delete', $user->id) }}" class="btn btn-outline-danger btn-sm"
                                       onclick="return confirm('Are you sure you want to delete this user?')" title="Delete">
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
