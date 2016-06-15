@extends('admin::layouts.default')
@section('content')

    <div class="row">
        <div class="header-content">
            <h1>Search Customers</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="col-xs-offset-2 col-xs-10">
                <div class="col-xs-2">
                    <h5>Search Customers</h5>
                </div>
                <div class="col-xs-2">
                    <span>{!! $customers->firstItem() !!} - {!! $customers->lastItem() !!} ({!! $customers->toArray()['total'] !!})</span>
                </div>
                {!!Form::open(array('route' => 'admin.user.index','method' => 'get')) !!}
                <div class="col-xs-2">
                    <input class="rounded" type="text" name="search[user][equal][firstname]" placeholder="First Name">
                </div>
                <div class="col-xs-2">
                    <input class="rounded" type="text" name="search[user][equal][lastname]" placeholder="Last Name">
                </div>
                <div class="col-xs-3">
                    {!! Form::select('type', array('all' => 'All', 'orange' => 'Orange Customers')) !!}
                </div>
                <div class="pull-right">
                    <input class="btn btn-orange rounded" type="submit" value="Search">
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <table class="table table-borderless">
                <thead>
                <th>Customer Name</th>
                <th>Country</th>
                <th>Subscription Level</th>
                <th>Status</th>
                <th>Customer Since</th>
                <th>Account</th>
                </thead>
                <tbody>
                @foreach($customers as $customer)
                    <tr>
                        <td>
                            <a onclick="toggleCustomerDisplay({!! $customer->id !!})">{!! $customer->full_name !!}</a>
                        </td>
                        <td>
                            {!! $customer->country !!}
                        </td>
                        <td>
                            {!! $customer->subscriptionLevel !!}
                        </td>
                        <td>
                            {!! $customer->status !!}
                        </td>
                        <td>
                            {!! $customer->created_at !!}
                        </td>
                        <td>
                            <a href="{!! route('admin.user.loginas',[$customer->id]) !!}">Login As</a>
                        </td>
                    </tr>
                    <tr id="customer-edit-{!!$customer->id!!}">
                        <td colspan="7">
                            <div class="col-xs-12">
                                {!!Form::open(array('route' => ['admin.user.update',$customer->id],'method' => 'PATCH')) !!}
                                <div class="col-xs-6">
                                    <div class="col-xs-12">
                                        <h5>Customer Info</h5>
                                    </div>
                                    <div class="col-xs-12">
                                        <div onclick="toggleCustomerField(this,'full_name','{!! $customer->full_name !!}')" id="customer-edit-{!! $customer->id !!}-full_name" class="col-xs-6">Name: {!! $customer->full_name !!} (edit)</div>
                                        <div onclick="toggleCustomerField(this,'telephone','{!! $customer->telephone !!}')" id="customer-edit-{!! $customer->id !!}-telephone" class="col-xs-6">Telephone: {!! $customer->telephone !!} (edit)</div>
                                        <div onclick="toggleCustomerField(this,'street1','{!! $customer->street1 !!}')" id="customer-edit-{!! $customer->id !!}-street1" class="col-xs-6">Address1: {!! $customer->street1 !!} (edit)</div>
                                        <div onclick="toggleCustomerField(this,'email','{!! $customer->email !!}')" id="customer-edit-{!! $customer->id !!}-email" class="col-xs-6">Email: {!! $customer->email !!} (edit)</div>
                                        <div onclick="toggleCustomerField(this,'city','{!! $customer->city !!}')" id="customer-edit-{!! $customer->id !!}-city" class="col-xs-6">City: {!! $customer->city !!} (edit)</div>
                                        <div onclick="toggleCustomerField(this,'website','{!! $customer->website !!}')" id="customer-edit-{!! $customer->id !!}-website" class="col-xs-6">Website: {!! $customer->website !!} (edit)</div>
                                        <div onclick="toggleCustomerField(this,'state','{!! $customer->state !!}')" id="customer-edit-{!! $customer->id !!}-state" class="col-xs-6">State: {!! $customer->state !!} (edit)</div>
                                        <div onclick="toggleCustomerField(this,'postal','{!! $customer->postal !!}')" id="customer-edit-{!! $customer->id !!}-postal" class="col-xs-6">Postal: {!! $customer->postal !!} (edit)</div>
                                        <div onclick="toggleCustomerField(this,'country','{!! $customer->country !!}')" id="customer-edit-{!! $customer->id !!}-country" class="col-xs-6">Country: {!! $customer->country !!} (edit)</div>
                                        <div class="col-xs-6">
                                            <div class="col-xs-6">
                                                <div class="btn btn-small btn-apple">Cancel</div>
                                            </div>
                                            <div class="col-xs-6">
                                                <input class="btn btn-orange rounded" type="submit" value="Update">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                                {!!Form::open(array('route' => ['admin.user.update.password',$customer->id],'method' => 'PUT')) !!}
                                <div class="col-xs-3">
                                    <div class="col-xs-12">
                                        <h5>Reset Account Password</h5>
                                    </div>
                                    <div class="col-xs-12">
                                        <div class="col-xs-12">
                                            <input class="rounded" type="text" name="password" placeholder="New Password">
                                            <input class="rounded" type="text" name="password_confirmation" placeholder="Repeat Password">
                                        </div>
                                    </div>
                                    <div class="col-xs-12">
                                        <div class="col-xs-8">
                                            <div class="col-xs-6">
                                                <div class="btn btn-s btn-apple">Cancel</div>
                                            </div>
                                            <div class="col-xs-4">
                                                <input class="btn btn-orange btn-s rounded" type="submit" value="Update">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                                {!!Form::open(array('route' => ['admin.user.update.card',$customer->id],'method' => 'PUT')) !!}
                                <div class="col-xs-3">
                                    <div class="col-xs-12">
                                        <h5>Payment Info</h5>
                                    </div>
                                    <div class="col-xs-12">
                                        <div onclick="toggleCustomerField(this,'card_number','{!! $customer->card_number !!}')" id="customer-edit-{!! $customer->id !!}-card_number" class="col-xs-12 cursor-pointer">Visa: xxxx xxxx xxxx 1992</div>
                                        <div onclick="toggleCustomerField(this,'card_expiry','{!! $customer->card_expiry !!}')" id="customer-edit-{!! $customer->id !!}-card_expiry" class="col-xs-12 cursor-pointer">Expiry: 10/20</div>
                                        <div onclick="toggleCustomerField(this,'card_cvv','{!! $customer->card_expiry !!}')" id="customer-edit-{!! $customer->id !!}-card_cvv" class="col-xs-12 cursor-pointer">CVV/CVC xxx</div>
                                    </div>
                                    <div class="col-xs-12">
                                        <div class="col-xs-6">
                                            <div class="col-xs-8">
                                                <div class="btn btn-apple">Cancel</div>
                                            </div>
                                            <div class="col-xs-4">
                                                <input class="btn btn-orange rounded" type="submit" value="Update">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script type="text/javascript">

                                    window.onload = function() {

                                    };
                                    var toggleCustomerField = function(element,input_name,default_value)
                                    {
                                        if(!$('#'+$(element).attr('id')+'-input').length)
                                        {
                                            $(element).html('<input id="'+$(element).attr('id')+'-input" type="text" name="'+input_name+'" value="'+default_value+'"/>');
                                            $('#'+$(element).attr('id')+'-input').focus();
                                        }
                                    }
                                    var toggleCustomerDisplay = function(customer_id)
                                    {
                                        $('#customer-edit-'+customer_id).toggle();
                                    }




                                </script>
                                {!! Form::close() !!}
                            </div>
                            <div class="col-xs-12">
                                <div class="col-xs-12">
                                    Subscription information for {!! $customer->fullName !!}
                                </div>
                                <div class="col-xs-12">
                                    @todo logic behind active or inactive
                                    <div class="col-xs-12">
                                        <div class="col-xs-1 btn btn-danger rounded btn-small">Deactivate</div>
                                        <div class="col-xs-1 btn btn-apple rounded btn-small">Activate</div>
                                    </div>
                                    <div class="col-xs-12">
                                        <div class="col-xs-1 btn btn-apple rounded btn-small">Deactivate</div>
                                        <div class="col-xs-1 btn btn-green rounded btn-small">Activate</div>
                                    </div>


                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
