@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Lists</div>

                <div class="panel-body">
                    <p>The list title is <strong>{{ $list[0]->title }}</strong></p>
                    <form name="testlist" action="" method="POST">
                        <input type="text" name="title" value="{{ $list[0]->title }}" />
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