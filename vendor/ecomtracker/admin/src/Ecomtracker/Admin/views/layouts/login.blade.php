<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin::includes.head')
</head>
<body class="common-bg">
@include('admin::includes.body.top.nav')
<div class="container" id= "common-wrapper">
    @if(Session::has('flash_message'))
        @if(is_array(Session::get('flash_message')))
            @foreach(Session::get('flash_message')['errors'] as $error)
                <div class="alert alert-success">{{$error->getMessage()}}</div>
            @endforeach
        @else
            <div class="alert alert-success">{!! Session::get('flash_message') !!}</div>
        @endif
    @endif
    @yield('content')
</div>
<footer class="container">
    @include('admin::includes.footer')
</footer>
</body>
</html>