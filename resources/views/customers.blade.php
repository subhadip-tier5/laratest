@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">All Customers</div>

                <div class="panel-body">
                    <ul class="list-group-item">
                        @foreach($customers as $customer)
                        <li><a href="{{ 'customer/'.$customer->id }}">{{ $customer->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection