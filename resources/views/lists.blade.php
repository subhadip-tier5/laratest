@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Lists</div>

                <div class="panel-body">
                    <ul class="list-group-item">
                        @foreach($lists as $list)
                        <li><a href="{{ 'lists/'.$list->slug }}">{{ $list->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection