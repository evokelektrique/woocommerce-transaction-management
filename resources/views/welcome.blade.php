@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Home</div>

                <div class="card-body">
                    <a href="{{ route("order.index") }}">Orders</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
