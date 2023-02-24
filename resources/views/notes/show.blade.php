@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <a href="{{ route('order.index') }}" class="btn btn-outline-light me-2">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <span class="fw-bold text-white">
                            Notes order(#{{ $order->order_id }})
                        </span>
                    </div>

                    <div class="card-body">

                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="row g-4">

                            {{-- Customer Notes --}}
                            <div class="col-12 col-md-4">
                                <h3 class="fw-bold mb-3">
                                    Customer Notes
                                </h3>
                                @forelse ($order->notes->where('type', 'customer') as $note)
                                    <div class="card border-secondary mb-4">
                                        <div
                                            class="card-header bg-transparent border-secondary d-flex align-items-center justify-content-between">
                                            <b>#{{ $note->id }}</b>
                                            <form class="d-inline-block" action="{{ route('note.destroy', $note) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="card-body text-dark">
                                            <p class="card-text">
                                                {{ $note->content }}
                                            </p>
                                        </div>
                                        <div class="card-footer bg-transparent border-secondary text-muted">
                                            {{ $note->created_at }}
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center fw-bold text-secondary border rounded py-5 mb-4">Empty</div>
                                @endforelse

                                <form action="{{ route('note.store') }}" method="POST">
                                    @csrf
                                    <textarea class="form-control mb-3" name="content" id="note-content" placeholder="Enter your note content..."></textarea>

                                    <button type="submit" class="btn btn-success btn-sm fw-bold w-100">Add</button>

                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                    <input type="hidden" name="type" value="customer">
                                </form>
                            </div>

                            {{-- Order Notes --}}
                            <div class="col-12 col-md-4">
                                <h3 class="fw-bold mb-3">
                                    Order Notes
                                </h3>
                                @forelse ($order->notes->where('type', 'order') as $note)
                                    <div class="card border-secondary mb-4">
                                        <div
                                            class="card-header bg-transparent border-secondary d-flex align-items-center justify-content-between">
                                            <b>#{{ $note->id }}</b>
                                            <form class="d-inline-block" action="{{ route('note.destroy', $note) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="card-body text-dark">
                                            <p class="card-text">
                                                {{ $note->content }}
                                            </p>
                                        </div>
                                        <div class="card-footer bg-transparent border-secondary text-muted">
                                            {{ $note->created_at }}
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center fw-bold text-secondary border rounded py-5 mb-4">Empty</div>
                                @endforelse

                                <form action="{{ route('note.store') }}" method="POST">
                                    @csrf
                                    <textarea class="form-control mb-3" name="content" id="note-content" placeholder="Enter your note content..."></textarea>

                                    <button type="submit" class="btn btn-success btn-sm fw-bold w-100">Add</button>

                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                    <input type="hidden" name="type" value="order">
                                </form>
                            </div>

                            {{-- Support Notes --}}
                            <div class="col-12 col-md-4">
                                <h3 class="fw-bold mb-3">
                                    Support Notes
                                </h3>
                                @forelse ($order->notes->where('type', 'support') as $note)
                                    <div class="card border-secondary mb-4">
                                        <div
                                            class="card-header bg-transparent border-secondary d-flex align-items-center justify-content-between">
                                            <b>#{{ $note->id }}</b>
                                            <form class="d-inline-block" action="{{ route('note.destroy', $note) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="card-body text-dark">
                                            <p class="card-text">
                                                {{ $note->content }}
                                            </p>
                                        </div>
                                        <div class="card-footer bg-transparent border-secondary text-muted">
                                            {{ $note->created_at }}
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center fw-bold text-secondary border rounded py-5 mb-4">Empty</div>
                                @endforelse

                                <form action="{{ route('note.store') }}" method="POST">
                                    @csrf
                                    <textarea class="form-control mb-3" name="content" id="note-content" placeholder="Enter your note content..."></textarea>

                                    <button type="submit" class="btn btn-success btn-sm fw-bold w-100">Add</button>

                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                    <input type="hidden" name="type" value="support">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
