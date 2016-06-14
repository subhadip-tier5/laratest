@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Lists</div>

                <div class="panel-body">
                    <p>The customer email is <strong>{{ $customer->email }}</strong></p>
                    <form name="testlist" action="" method="POST">
                        <input type="text" name="title" value="{{ $customer->name }}" />
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <input type="submit" value="Update" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection