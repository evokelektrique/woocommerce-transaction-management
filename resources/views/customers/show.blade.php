@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Customer <span>(#{{ $customer->id }})</span></div>

                <div class="card-body">
                    <div>{{ $customer->id }}</div>
                    <div>{{ $customer->username }}</div>
                    <div>{{ $customer->first_name }}</div>
                    <div>{{ $customer->last_name }}</div>
                    <div>{{ $customer->email }}</div>
                    <div>{{ $customer->phone }}</div>
                    <div>{{ $customer->created_at }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
