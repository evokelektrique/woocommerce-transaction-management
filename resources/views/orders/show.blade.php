@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card border-primary">
                    <div class="card-header bg-primary">
                        <a href="{{ route('order.index') }}" class="btn btn-outline-light me-2 py-2">
                            <i class="d-flex bi bi-arrow-left"></i>
                        </a>
                        <span class="fw-bold">
                            Order ({{ $order->id }})
                        </span>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif


                        <div class="row g-4">

                            {{-- Customer Notes --}}
                            <div class="col-12 col-md-4">
                                <h3 class="fw-bold mb-3">
                                    Customer Notes
                                </h3>
                                @forelse ($order->notes as $note)
                                    <div
                                        class="card position-relative border-{{ $note->is_added_by_user() || $note->is_added_by_system() ? 'primary shadow-sm' : 'secondary' }} mb-4">

                                        @if ($note->is_added_by_system())
                                            <span
                                                class="position-absolute top-0 start-0 translate-middle-y badge rounded bg-primary">
                                                Added by system
                                            </span>
                                        @endif

                                        @if ($note->is_added_by_user())
                                            <span
                                                class="position-absolute top-0 start-0 translate-middle-y badge rounded bg-primary">
                                                Added by customer
                                            </span>
                                        @endif

                                        <div
                                            class="card-header bg-transparent border-{{ $note->is_added_by_user() || $note->is_added_by_system() ? 'primary' : 'secondary' }} d-flex align-items-center justify-content-between">
                                            <b>#{{ $note->id }}</b>
                                            <form class="d-inline-block" action="{{ route('note.destroy', $note) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm py-2 text-white">
                                                    <i class="d-flex bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="card-body text-dark">
                                            <p class="card-text">
                                                {{ $note->content }}
                                            </p>
                                        </div>
                                        <div class="card-footer bg-transparent border-{{ $note->is_added_by_user() || $note->is_added_by_system() ? 'primary' : 'secondary' }} text-muted"
                                            title="{{ $note->created_at }}">
                                            {{ $note->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center fw-bold text-secondary border rounded py-5 mb-4">Empty</div>
                                @endforelse

                                <form action="{{ route('note.store', $order) }}" method="POST">
                                    @csrf
                                    <textarea class="form-control mb-3" name="content" id="note-content" placeholder="Enter your note content..."></textarea>

                                    <button type="submit" class="btn btn-success btn-sm fw-bold w-100">Add</button>
                                </form>
                            </div>

                            {{-- Support Notes and Notifications --}}
                            <div class="col-12 col-md-2 d-flex flex-column">
                                <h3 class="fw-bold mb-3">
                                    Support Notes
                                </h3>
                                <form class='support_note_form d-flex flex-column mb-3' data-id="{{ $order->id }}">
                                    <textarea class="form-control mb-2 fs-5" rows="6" placeholder="Support note ..."
                                        id="support_note_{{ $order->id }}">{{ $order->support_note }}</textarea>
                                    <div id="support_note_status"
                                        class="text-success align-items-center justify-content-start d-flex gap-2"></div>
                                </form>


                                {{-- Notifications --}}
                                <div>
                                    <h3 class="fw-bold mb-3">
                                        Notifications
                                    </h3>
                                    <div class="row g-3 justify-content-between">

                                        @foreach ($order->customer->notifications as $notification)
                                            {{-- Skip notifications that are not 'CustomerAccountExpired' type --}}
                                            @if ($notification->type !== 'App\Notifications\CustomerAccountExpired')
                                                @continue
                                            @endif

                                            <div class="col-12 border p-3 rounded">
                                                {{-- Created at --}}
                                                <div class="text-end" dir="rtl">

                                                    <span class="text-dark fs-6 mb-2 d-block" title="{{ $notification->created_at }}">

                                                        {{ $order->customer->getPattern($notification->data['tokens']) }}
                                                    </span>

                                                    <span class="text-dark fs-6 text-muted" title="{{ $notification->created_at }}">
                                                        {{ $notification->created_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 d-flex flex-column">
                                <h3 class="fw-bold mb-3">
                                    Accounts
                                </h3>
                            @empty($order->metadata['order_dynamic_fields'])
                                <div class="border p-3 rounded shadow-sm">
                                    Empty
                                </div>
                            @endempty
                            <div class="row g-3">
                                @foreach ($order->accounts as $account)
                                    <div class="col-12">
                                        <div class="border p-3 rounded shadow-sm">
                                            <div class="row row-cols-auto gy-3 gx-lg-3 justify-content-between">

                                                {{-- Title --}}
                                                <div class="d-flex flex-column h-100">
                                                    <span class="user-select-none fs-6">Title</span><span
                                                        class="text-dark fs-5">{{ $account->title }}</span>
                                                </div>

                                                {{-- Email --}}
                                                <div class="d-flex flex-column h-100">
                                                    <span class="user-select-none fs-6">Email</span><span
                                                        class="text-dark fs-5">{{ $account->email }}</span>
                                                </div>

                                                {{-- Username --}}
                                                <div class="d-flex flex-column h-100">
                                                    <span class="user-select-none fs-6">Username</span><span
                                                        class="text-dark fs-5">{{ $account->username }}</span>
                                                </div>

                                                {{-- Password --}}
                                                <div class="d-flex flex-column h-100">
                                                    <span class="user-select-none fs-6">Password</span><span
                                                        class="text-dark fs-5">{{ $account->password }}</span>
                                                </div>

                                                {{-- Code --}}
                                                <div class="d-flex flex-column h-100">
                                                    <span class="user-select-none fs-6">Code</span><span
                                                        class="text-dark fs-5">{{ $account->code }}</span>
                                                </div>

                                                {{-- Date --}}
                                                <div class="d-flex flex-column h-100">
                                                    <span class="user-select-none fs-6">Date</span><span
                                                        class="text-dark fs-5"
                                                        title="{{ $account->date }}">{{ $account->date->diffForHumans() }}</span>
                                                </div>

                                                {{-- Expire_days --}}
                                                <div class="d-flex flex-column h-100">
                                                    <span class="user-select-none fs-6">Expire days</span><span
                                                        class="text-dark fs-5">{{ $account->expire_days }}</span>
                                                </div>

                                                {{-- Is_expired --}}
                                                <div class="d-flex flex-column h-100">
                                                    <span class="user-select-none fs-6">Expire Status</span>

                                                    <div
                                                        class="fs-5 d-flex align-items-center justify-content-center gap-2 {{ $account->is_expired() ? 'text-danger' : 'text-success' }}">
                                                        <i
                                                            class="bi bi-{{ $account->is_expired() ? 'exclamation-square' : 'check-square' }}"></i>
                                                        <span
                                                            class="d-flex">{{ $account->is_expired() ? 'Expired' : 'Not Expired' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
