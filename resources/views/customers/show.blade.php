@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Customer <span>(#{{ $customer->id }})</span></div>

                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <span class="fw-bold me-2 badge bg-secondary text-capitalize">id</span>
                            {{ $customer->id }}
                        </li>

                        <li class="list-group-item">
                            <span class="fw-bold me-2 badge bg-secondary text-capitalize">username</span>
                            {{ $customer->username }}
                        </li>

                        <li class="list-group-item">
                            <span class="fw-bold me-2 badge bg-secondary text-capitalize">first name</span>
                            {{ $customer->first_name }}
                        </li>

                        <li class="list-group-item">
                            <span class="fw-bold me-2 badge bg-secondary text-capitalize">last name</span>
                            {{ $customer->last_name }}
                        </li>

                        <li class="list-group-item">
                            <span class="fw-bold me-2 badge bg-secondary text-capitalize">email</span>
                            {{ $customer->email }}
                        </li>

                        <li class="list-group-item">
                            <span class="fw-bold me-2 badge bg-secondary text-capitalize">phone</span>
                            {{ $customer->phone }}
                        </li>

                        <li class="list-group-item">
                            <span class="fw-bold me-2 badge bg-secondary text-capitalize">created at</span>
                            {{ $customer->created_at }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
