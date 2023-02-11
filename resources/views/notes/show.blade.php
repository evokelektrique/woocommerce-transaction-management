@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Note <span>order(#{{ $order->order_id }})</span></div>

                    <div class="card-body">

                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <h2 class="fw-bold">Notes</h2>

                        <ul class="list-group">
                            @foreach ($order->notes as $note)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="badge bg-secondary">
                                            TYPE: {{ $note->type }}
                                        </span>
                                        <span class="badge bg-secondary">
                                            CONTENT: {{ $note->content }}
                                        </span>
                                        <span class="badge bg-secondary">
                                            DATE: {{ $note->created_at }}
                                        </span>
                                    </div>

                                    <form class="d-inline-block" action="{{ route('note.destroy', $note) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>

                        <hr>

                        <h2 class="fw-bold">New note</h2>

                        <form action="{{ route('note.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->id }}">

                            <label for="note-type">Note type</label>
                            <select name="type" id="note-type" class="form-select mb-3">
                                <option value="support" selected>support</option>
                                <option value="customer">customer</option>
                                <option value="order">order</option>
                            </select>

                            <label for="note-content">Note content</label>
                            <textarea class="form-control mb-3" name="content" id="note-content" placeholder="Enter your note content..."></textarea>

                            <button type="submit" class="btn btn-success btn-sm fw-bold">submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
