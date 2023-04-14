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

                        <div class="row row-cols-auto">
                            <div class="col-12 col-lg-12">
                                <h1 class="fw-bold text-center my-3">Accounts</h1>

                                @empty($order->metadata['order_dynamic_fields'])
                                    <div class="border p-3 rounded shadow-sm">
                                        Empty
                                    </div>
                                @endempty

                                <div class="row gx-lg-3 gy-3">
                                    @foreach ($order->metadata['order_dynamic_fields'] as $dynamic_fields)
                                        <div class="col-12 g-3">
                                            <div class="border p-3 rounded shadow-sm">
                                                <div class="row row-cols-auto gy-3 gx-lg-3">
                                                    @foreach ($dynamic_fields as $key => $value)
                                                        @empty($value)
                                                            @continue
                                                        @endempty
                                                        <div class="d-flex flex-column h-100">
                                                            <span
                                                                class="user-select-none fs-6">{{ $key }}</span><span
                                                                class="h-100 text-dark fs-5 rounded">{{ $value }}</span>
                                                        </div>
                                                    @endforeach
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
    </div>
@endsection
