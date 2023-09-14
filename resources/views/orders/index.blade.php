@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card border-primary">
                    <div class="card-header bg-primary">
                        <a href="{{ route('home.index') }}" class="btn btn-outline-light me-2 py-2">
                            <i class="d-flex bi bi-arrow-left"></i>
                        </a>
                        <span class="fw-bold">
                            Orders
                        </span>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{-- Custom filters --}}
                        <div class="custom-filters row row-cols-auto mb-3 border-bottom rounded pb-3">
                            <div class="col-12 col-lg-2">
                                <form id="form-orders-table">
                                    <label for="filter-date-picker" class="form-label d-block">Date Range Picker</label>

                                    <div class="d-flex gap-2">
                                        <input type="text" class="form-control text-center" id="datepicker" name="datepicker"
                                            value="{{ request()->get('datepicker') ?? '' }}">
                                        <button type="submit" class="btn btn-sm btn-outline-success">Apply</button>
                                    </div>
                                </form>
                            </div>

                            <div class="col-12 col-lg-2">

                                <label for="filter-order-status" class="form-label">Order status</label>
                                <select id="filter-order-status" class="form-select">
                                    <option value="">All</option>
                                    <option value="processing" selected>processing</option>
                                    <option value="completed">completed</option>
                                    <option value="on-hold">on-hold</option>
                                    <option value="cancelled">cancelled</option>
                                </select>
                            </div>
                        </div>

                        <div class="table-responsive">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
