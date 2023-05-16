@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card border-primary">
                    <div class="card-header bg-primary">Token</div>

                    <div class="card-body">
                        Token:&nbsp;<span class="fw-bold text-dark">{{ $token }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
