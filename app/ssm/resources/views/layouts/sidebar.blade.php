<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <style>
        .sidebar-brand-text {
            text-transform: none;
        }
        .sidebar-logo {
            height: 102px;
    margin-top: 130px;
    mix-blend-mode: multiply;
}

        .sidebar-brand-text {
            margin-top: 10px; /* Adjust spacing as needed */
        }
        </style>

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex flex-column align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon">
            <img src="img/logo.png" alt="CenterSync Logo" class="sidebar-logo">
        </div>
        <div class="sidebar-brand-text">Service Simplified</div>
    </a>


    <!-- Divider -->

    <br><br>    <br><br>
    <br><br>

    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ url('/') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">Core item</div>

    <!-- Nav Item - Pages Collapse Menu -->
    @php
        $segment1 = Request::segment(1);
        $pages = array('clients', 'suppliers', 'hsns', 'assoext', 'assoint' );
    @endphp

    @php
        if(Auth::user()->role == 'AD'){
    @endphp

    <li class="nav-item @if(in_array($segment1, $pages)) active @endif">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
           aria-expanded="false" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Master Data</span>
        </a>
        <div id="collapseTwo" class="collapse @if(in_array($segment1, $pages)) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Core Config</h6>
				<a class="collapse-item {{ request()->is('clients') ? 'active' : '' }}" href="{{ url('/clients') }}">Clients</a>
                <a class="collapse-item {{ request()->is('suppliers') ? 'active' : '' }}" href="{{ url('/suppliers') }}">Suppliers</a>
                <a class="collapse-item {{ request()->is('assoext') ? 'active' : '' }}" href="{{ url('/assoext') }}">External Associate</a>
                <a class="collapse-item {{ request()->is('assoint') ? 'active' : '' }}" href="{{ url('/assoint') }}">Internal Associate</a>
                <a class="collapse-item {{ request()->is('hsns') ? 'active' : '' }}" href="{{ url('/hsns') }}">HSN Number</a>


            </div>
        </div>
    </li>
@php
}
@endphp


    <!-- Divider -->


    <hr class="sidebar-divider">
    <div class="sidebar-heading">Product </div>

    @php
    $segment1 = Request::segment(1);
    $pages = array('raw-products', 'finish-products', 'raw-ent', 'fin-ent');
@endphp

<li class="nav-item {{ in_array($segment1, $pages) ? 'active' : '' }}">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProd"
       aria-expanded="{{ in_array($segment1, $pages) ? 'true' : 'false' }}" aria-controls="collapseJobs">
        <i class="fas fa-fw fa-briefcase"></i>
        <span>Product</span>
    </a>
    <div id="collapseProd" class="collapse {{ in_array($segment1, $pages) ? 'show' : '' }}" aria-labelledby="headingJobs" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Product Management:</h6>
            @if(Auth::user()->role == 'AD')
                 <a class="collapse-item {{ request()->is('raw-products') ? 'active' : '' }}" href="{{ url('/rawproducts') }}">Raw Products</a>
                <a class="collapse-item {{ request()->is('finish-products') ? 'active' : '' }}" href="{{ url('/finishproducts') }}">Finish Products</a>
                <a class="collapse-item {{ request()->is('raw-ent') ? 'active' : '' }}" href="{{ url('/stkent') }}">Raw Stock Entry</a>
                <a class="collapse-item {{ request()->is('fin-ent') ? 'active' : '' }}" href="{{ url('/stkfinent') }}">Ready Stock Entry</a>
            @endif
        </div>
    </div>
</li>


    <hr class="sidebar-divider">
    <div class="sidebar-heading">Product </div>

    @php
    $segment1 = Request::segment(1);
    $pages = array('Stockin', 'Stockex', 'Stockinr', 'Stockexr');
@endphp

<li class="nav-item {{ in_array($segment1, $pages) ? 'active' : '' }}">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseJobs"
       aria-expanded="{{ in_array($segment1, $pages) ? 'true' : 'false' }}" aria-controls="collapseJobs">
        <i class="fas fa-fw fa-briefcase"></i>
        <span>Stock Management: </span>
    </a>
    <div id="collapseJobs" class="collapse {{ in_array($segment1, $pages) ? 'show' : '' }}" aria-labelledby="headingJobs" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Stock Management:</h6>
				<a class="collapse-item {{ request()->is('Stockin') ? 'active' : '' }}" href="{{ url('/stkoutint') }}">Inernal Associate Assign </a>
                <a class="collapse-item {{ request()->is('Stockex') ? 'active' : '' }}" href="{{ url('/stkoutext') }}">External Associate Assign </a>
                <a class="collapse-item {{ request()->is('Stockinr') ? 'active' : '' }}" href="{{ url('/stkinint') }}">Inernal Associate Return </a>
                <a class="collapse-item {{ request()->is('Stockexr') ? 'active' : '' }}" href="{{ url('/stkinext') }}">External Associate Return </a>

        </div>
    </div>
</li>
    <hr class="sidebar-divider">

    <div class="sidebar-heading">Finance</div>
    @php
    $segment1 = Request::segment(1);
    $financePages = array('deliverychallan', 'invoiceSrvGst', 'invoiceSrvNonGst','clpay');
@endphp

<li class="nav-item {{ in_array($segment1, $financePages) ? 'active' : '' }}">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFin"
       aria-expanded="{{ in_array($segment1, $financePages) ? 'true' : 'false' }}" aria-controls="collapseFin">
        <i class="fas fa-fw fa-university"></i>
        <span>Finance</span>
    </a>
    <div id="collapseFin" class="collapse {{ in_array($segment1, $financePages) ? 'show' : '' }}" aria-labelledby="headingFin" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Finance Management:</h6>
            <a class="collapse-item {{ request()->is('finsup') ? 'active' : '' }}" href="{{ url('/finsup') }}">Supplier Payment Entry</a>
            <a class="collapse-item {{ request()->is('deliverychallan') ? 'active' : '' }}" href="{{ url('/deliverychallan') }}">Delivery Challan</a>
            {{-- <a class="collapse-item {{ request()->is('invoiceSrvGst') ? 'active' : '' }}" href="{{ url('/invoiceSrvGst') }}">GST Invoice</a>
            <a class="collapse-item {{ request()->is('invoiceSrvNonGst') ? 'active' : '' }}" href="{{ url('/invoiceSrvNonGst') }}">Non GST Invoice</a>
            <a class="collapse-item {{ request()->is('clpay') ? 'active' : '' }}" href="{{ url('/clpay') }}">Client Payment Entry</a> --}}


        </div>
    </div>
</li>






<div class="sidebar-heading">Power tool</div>
@php
$segment1 = Request::segment(1);
$adminPages = array('model', 'password', 'backup');
@endphp

<li class="nav-item {{ in_array($segment1, $adminPages) ? 'active' : '' }}">
<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAdm"
   aria-expanded="{{ in_array($segment1, $adminPages) ? 'true' : 'false' }}" aria-controls="collapseAdm">
   <i class="fa fa-cubes" aria-hidden="true"></i>
   <span>Admin</span>
</a>
<div id="collapseAdm" class="collapse {{ in_array($segment1, $adminPages) ? 'show' : '' }}" aria-labelledby="headingFin" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Admin Area:</h6>
        <a class="collapse-item {{ request()->is('password') ? 'active' : '' }}" href="{{ url('/staffs') }}">Web user</a>
        <a class="collapse-item {{ request()->is('backup') ? 'active' : '' }}" href="{{ url('/util/execute-backup') }}">Backup</a>
    </div>
</div>
</li>



    <!-- Divider -->
    {{-- @php
    if(Auth::user()->role == 'AD'){
@endphp
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Staffs -->
    <li class="nav-item {{ request()->is('staffs') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/staffs') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Staffs</span>
        </a>
    </li>
    @php
}
@endphp --}}
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
