<div class="row">
    <header class="nav-header" id="sectionnav" style="">
        <ul class="nav navbar-nav ">
            <li><a href="{!! route('admin.dashboard') !!}">Admin Dashboard</a></li>
            <li><a href="{!! route('admin.user.index') !!}">Search Customers</a></li>
            <li><a href="{!! route('admin.report.index') !!}">Reports</a></li>
            <li><a href="{!! route('admin.logout') !!}">Log Out</a></li>
        </ul>
        <ul class="nav navbar-nav toolbar">
            <li>
                <div class="btn btn-orange rounded">Search Customers</div>
                <div class="btn btn-orange rounded">Run Reports</div>
            </li>
        </ul>
    </header>
</div>