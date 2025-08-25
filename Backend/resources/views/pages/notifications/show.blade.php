@extends('layouts.app')

@section('title', 'Notification Details - ' . config('app.name'))

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">
                    <i class="{{ $notification->getIconClass() }} {{ $notification->getTypeColor() }} mr-2"></i>
                    Notification Details
                </h5>
                <div class="card-action">
                    <a href="{{ route('notifications') }}" class="btn btn-secondary btn-sm">
                        <i class="zmdi zmdi-arrow-back mr-1"></i>Back to Notifications
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="notification-details">
                            <h4 class="mb-3">{{ $notification->title }}</h4>
                            <div class="alert alert-{{ $notification->type == 'error' ? 'danger' : $notification->type }}">
                                <p class="mb-0">{{ $notification->message }}</p>
                            </div>

                            @if($notification->data)
                                <div class="mt-4">
                                    <h6>Additional Information:</h6>
                                    <pre class="bg-light p-3 rounded">{{ json_encode($notification->data, JSON_PRETTY_PRINT) }}</pre>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="notification-meta">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Notification Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>Type:</strong>
                                        <span class="badge badge-{{ $notification->type == 'error' ? 'danger' : $notification->type }} ml-2">
                                            {{ ucfirst($notification->type) }}
                                        </span>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Status:</strong>
                                        @if($notification->is_read)
                                            <span class="badge badge-success ml-2">Read</span>
                                        @else
                                            <span class="badge badge-warning ml-2">Unread</span>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <strong>Created:</strong><br>
                                        <small class="text-muted">{{ $notification->created_at->format('F j, Y g:i A') }}</small>
                                    </div>
                                    @if($notification->read_at)
                                        <div class="mb-3">
                                            <strong>Read:</strong><br>
                                            <small class="text-muted">{{ $notification->read_at->format('F j, Y g:i A') }}</small>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-3">
                                @if(!$notification->is_read)
                                    <form action="{{ route('notifications.mark-read', $notification->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-block">
                                            <i class="zmdi zmdi-check mr-1"></i>Mark as Read
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('notifications.delete', $notification->id) }}" method="POST" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-block"
                                            onclick="return confirm('Are you sure you want to delete this notification?')">
                                        <i class="zmdi zmdi-delete mr-1"></i>Delete Notification
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
