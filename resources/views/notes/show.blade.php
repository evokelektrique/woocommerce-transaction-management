@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Note <span>order(#{{ $order->order_id }})</span></div>

                <div class="card-body">
                    notes:
                    <br>
                    @foreach ($order->notes as $note)
                        TYPE: {{ $note->type }} - CONTENT: {{ $note->content }} - DATE: {{ $note->created_at }}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
