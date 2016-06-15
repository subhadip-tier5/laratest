@extends('admin::layouts.default')
@section('content')
    <div class="row">
        <div class="header-content">
            <h1>Admin Dashboard</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-3">
            <div class="col-xs-12">
                <div class="col-xs-6 text-uppercase">
                    <h4>Sales</h4>
                </div>
                <div class="col-xs-6">
                    <div class="btn btn-blue rounded btn-xs">VIEW REPORT</div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-7">Recurring Sales</div>
                <div class="col-xs-5">{!! $recurring_sales !!}</div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-7">New Sales</div>
                <div class="col-xs-5">{!! $new_sales !!}</div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-7">Gross Daily Sales</div>
                <div class="col-xs-5">{!! $gross_daily_sales !!}</div>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="col-xs-12">
                <div class="col-xs-6 text-uppercase">
                    <h4>
                        CUSTOMERS
                    </h4>
                </div>
                <div class="col-xs-6">
                    <div class="btn btn-blue rounded btn-xs">VIEW REPORT</div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-7">Active Customers</div>
                <div class="col-xs-5">{!! $active_customers !!}</div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-7">Inactive Customers</div>
                <div class="col-xs-5">{!! $inactive_customers !!}</div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-7">Total Customers</div>
                <div class="col-xs-5">{!! $total_customers !!}</div>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="col-xs-12">
                <div class="col-xs-6 text-uppercase">
                    <h4>FUTURE REOCCURING SALES</h4>
                </div>
            </div>
            <div class="col-xs-12">
                @todoAdd graph
            </div>
        </div>
    </div>
@stop
