@extends('layouts.app')

@section('title', 'Notifications - ' . config('app.name'))

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0"><i class="zmdi zmdi-notifications mr-2"></i>Notifications</h5>
                <div class="card-action">
                    @if($notifications->where('is_read', false)->count() > 0)
                        <form action="{{ route('notifications.mark-all-read') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="zmdi zmdi-check-all mr-1"></i>Mark All as Read
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            <div class="card-body">
                @if($notifications->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Title</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($notifications as $notification)
                                <tr class="{{ $notification->is_read ? '' : 'table-warning' }}" style="{{ $notification->is_read ? '' : 'background-color: #fff3cd; color: #000;' }}">
                                    <td>
                                        <i class="{{ $notification->getIconClass() }}" style="font-size: 1.2em; color: {{ $notification->type == 'error' ? '#dc3545' : ($notification->type == 'warning' ? '#ffc107' : ($notification->type == 'success' ? '#28a745' : '#17a2b8')) }};"></i>
                                    </td>
                                    <td>
                                        <strong>{{ $notification->title }}</strong>
                                    </td>
                                    <td>
                                        {{ Str::limit($notification->message, 100) }}
                                    </td>
                                    <td>
                                        {{ $notification->created_at->format('M j, Y g:i A') }}
                                    </td>
                                    <td>
                                        @if($notification->is_read)
                                            <span class="badge badge-success" style="background-color: #28a745; color: white;">Read</span>
                                        @else
                                            <span class="badge badge-warning" style="background-color: #ffc107; color: #212529;">Unread</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('notifications.show', $notification->id) }}"
                                               class="btn btn-primary btn-sm">
                                                <i class="zmdi zmdi-eye"></i>
                                            </a>
                                            @if(!$notification->is_read)
                                                <form action="{{ route('notifications.mark-read', $notification->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="zmdi zmdi-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('notifications.delete', $notification->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure you want to delete this notification?')">
                                                    <i class="zmdi zmdi-delete"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $notifications->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="zmdi zmdi-notifications text-muted" style="font-size: 4rem;"></i>
                        <h5 class="mt-3 text-muted">No notifications found</h5>
                        <p class="text-muted">You don't have any notifications yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
