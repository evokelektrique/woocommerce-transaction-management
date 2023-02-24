@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card border-primary">
                <div class="card-header bg-primary">
                    <a href="{{ route("home.index") }}" class="btn btn-outline-light me-2">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <span class="fw-bold text-white">
                        Orders
                    </span>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
