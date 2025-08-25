@extends('layouts.app')

@section('title', 'Message Details - ' . config('app.name'))

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0"><i class="zmdi zmdi-email mr-2"></i>Message Details</h5>
                <div class="card-action">
                    <a href="{{ route('messages') }}" class="btn btn-secondary btn-sm">
                        <i class="zmdi zmdi-arrow-back mr-1"></i>Back to Messages
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <!-- Message Content -->
                        <div class="message-content">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">{{ $message->subject }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="message-meta mb-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>From:</strong>
                                                {{ $message->sender->first_name }} {{ $message->sender->last_name }}
                                                <br><small class="text-dark">{{ $message->sender->email }}</small>
                                            </div>
                                            <div class="col-md-6">
                                                <strong>To:</strong>
                                                {{ $message->receiver->first_name }} {{ $message->receiver->last_name }}
                                                <br><small class="text-dark">{{ $message->receiver->email }}</small>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <strong>Date:</strong> {{ $message->created_at->format('F j, Y g:i A') }}
                                        </div>
                                    </div>

                                    <div class="message-body">
                                        <div class="alert alert-light">
                                            {!! nl2br(e($message->message)) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Message Actions -->
                        <div class="message-actions">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Message Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>Status:</strong>
                                        @if($message->is_read)
                                            <span class="badge badge-success ml-2">Read</span>
                                        @else
                                            <span class="badge badge-warning ml-2">Unread</span>
                                        @endif
                                    </div>

                                    @if($message->read_at)
                                        <div class="mb-3">
                                            <strong>Read:</strong><br>
                                            <small class="text-dark">{{ $message->read_at->format('F j, Y g:i A') }}</small>
                                        </div>
                                    @endif

                                    <div class="mb-3">
                                        <strong>Direction:</strong><br>
                                        @if($message->sender_id == auth()->id())
                                            <span class="badge badge-info">Sent</span>
                                        @else
                                            <span class="badge badge-primary">Received</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                @if($message->receiver_id == auth()->id() && !$message->is_read)
                                    <form action="{{ route('messages.mark-read', $message->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-block">
                                            <i class="zmdi zmdi-check mr-1"></i>Mark as Read
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('messages.delete', $message->id) }}" method="POST" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-block"
                                            onclick="return confirm('Are you sure you want to delete this message?')">
                                        <i class="zmdi zmdi-delete mr-1"></i>Delete Message
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
