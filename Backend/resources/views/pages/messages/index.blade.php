@extends('layouts.app')

@section('title', 'Messages - ' . config('app.name'))

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0"><i class="zmdi zmdi-email mr-2"></i>Messages</h5>
            </div>
            <div class="card-body">
                <!-- Navigation Tabs -->
                <ul class="nav nav-tabs" id="messageTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="inbox-tab" data-toggle="tab" href="#inbox" role="tab">
                            @if(auth()->user()->role === 'admin')
                                User Messages
                            @else
                                Inbox
                            @endif
                            @if($inbox->where('is_read', false)->count() > 0)
                                <span class="badge badge-danger ml-1" style="background-color: #dc3545; color: white;">{{ $inbox->where('is_read', false)->count() }}</span>
                            @endif
                        </a>
                    </li>
                    @if(auth()->user()->role !== 'admin')
                        <li class="nav-item">
                            <a class="nav-link" id="sent-tab" data-toggle="tab" href="#sent" role="tab">
                                Sent
                            </a>
                        </li>
                    @endif
                </ul>

                <!-- Tab Content -->
                <div class="tab-content mt-3" id="messageTabsContent">
                    <!-- Inbox Tab -->
                    <div class="tab-pane fade show active" id="inbox" role="tabpanel">
                        @if($inbox->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            @if(auth()->user()->role === 'admin')
                                                <th>From User</th>
                                            @else
                                                <th>From</th>
                                            @endif
                                            <th>Subject</th>
                                            <th>Message</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($inbox as $message)
                                        <tr class="{{ $message->is_read ? '' : 'table-warning' }}" style="{{ $message->is_read ? '' : 'background-color: #fff3cd; color: #000;' }}">
                                            <td>
                                                <strong>{{ $message->sender->first_name }} {{ $message->sender->last_name }}</strong>
                                                <br><small class="text-muted">{{ $message->sender->email }}</small>
                                            </td>
                                            <td>
                                                <strong>{{ $message->subject }}</strong>
                                            </td>
                                            <td>
                                                {{ Str::limit($message->message, 100) }}
                                            </td>
                                            <td>
                                                {{ $message->created_at->format('M j, Y g:i A') }}
                                            </td>
                                            <td>
                                                @if($message->is_read)
                                                    <span class="badge badge-success" style="background-color: #28a745; color: white;">Read</span>
                                                @else
                                                    <span class="badge badge-warning" style="background-color: #ffc107; color: #212529;">Unread</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('messages.show', $message->id) }}"
                                                       class="btn btn-primary btn-sm">
                                                        <i class="zmdi zmdi-eye"></i>
                                                    </a>
                                                    @if(!$message->is_read)
                                                        <form action="{{ route('messages.mark-read', $message->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm">
                                                                <i class="zmdi zmdi-check"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <form action="{{ route('messages.delete', $message->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Are you sure you want to delete this message?')">
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
                                {{ $inbox->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="zmdi zmdi-email text-muted" style="font-size: 4rem;"></i>
                                @if(auth()->user()->role === 'admin')
                                    <h5 class="mt-3 text-muted">No user messages</h5>
                                    <p class="text-muted">No users have sent messages yet.</p>
                                @else
                                    <h5 class="mt-3 text-muted">No messages in inbox</h5>
                                    <p class="text-muted">You don't have any messages yet.</p>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Sent Tab -->
                    <div class="tab-pane fade" id="sent" role="tabpanel">
                        @if($sent->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>To Admin</th>
                                            <th>Subject</th>
                                            <th>Message</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sent as $message)
                                        <tr style="{{ $message->is_read ? '' : 'background-color: #fff3cd; color: #000;' }}">
                                            <td>
                                                <strong>{{ $message->receiver->first_name }} {{ $message->receiver->last_name }}</strong>
                                                <br><small class="text-muted">{{ $message->receiver->email }}</small>
                                            </td>
                                            <td>
                                                <strong>{{ $message->subject }}</strong>
                                            </td>
                                            <td>
                                                {{ Str::limit($message->message, 100) }}
                                            </td>
                                            <td>
                                                {{ $message->created_at->format('M j, Y g:i A') }}
                                            </td>
                                            <td>
                                                @if($message->is_read)
                                                    <span class="badge badge-success" style="background-color: #28a745; color: white;">Read</span>
                                                @else
                                                    <span class="badge badge-warning" style="background-color: #ffc107; color: #212529;">Unread</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('messages.show', $message->id) }}"
                                                       class="btn btn-primary btn-sm">
                                                        <i class="zmdi zmdi-eye"></i>
                                                    </a>
                                                    <form action="{{ route('messages.delete', $message->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Are you sure you want to delete this message?')">
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
                                {{ $sent->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="zmdi zmdi-email text-muted" style="font-size: 4rem;"></i>
                                <h5 class="mt-3 text-muted">No sent messages</h5>
                                <p class="text-muted">You haven't sent any messages to admin yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
