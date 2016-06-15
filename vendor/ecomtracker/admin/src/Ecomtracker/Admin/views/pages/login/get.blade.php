@extends('admin::layouts.login')
@section('content')
    <div class="col-lg-12 col-md-12">
        <div class="col-lg-4 col-md-4"></div>
        <div class="col-lg-4 col-md-4">
            <div class="static-content">
                <div class="verticalcenter">
                    {!!Form::open(array('route' => 'admin.login.post','method' => 'POST', 'class' => 'form-horizontal', 'style' => 'margin-bottom: 0px !important')) !!}
                    <div class="panel panel-primary">
                        <div class="panel-body">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                            <input type="text" name="email" placeholder="Password">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                            <input type="text" name="password" placeholder="Password">

                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="panel-footer">
                            <div class="pull-right">
                                <a href="#" class="btn btn-default b-a rounded">Reset</a>
                                <input class="btn btn-orange rounded" type="submit" value="Log In">
                            </div>
                        </div>
                    </div>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4"></div>
    </div>
@stop
