@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card border-primary">
                    <div class="card-header bg-primary">Home</div>

                    <div class="card-body">
                        <a href="{{ route('order.index') }}" class="btn btn-primary position-relative">
                            Orders
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary text-dark">
                                Total {{$orders_total}}
                                <span class="visually-hidden">Total orders</span>
                            </span>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
