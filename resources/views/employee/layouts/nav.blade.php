<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <a href="javascript:void()" onclick="$('#logout-form').submit();" class="btn btn-danger">
                    <i class="fas fa-arrow-right" aria-hidden="true"></i> Sign Out
                </a>
            </form>
        </li>
    </ul>
</nav>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('employee.dashboard') }}" class="brand-link">
        <img src="{{ asset('design/dist/img/AdminLTELogo.png') }}" alt="User Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Leave Management</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('design/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>


        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('employee.dashboard') }}" class="nav-link">
                        <i class="nav-icon far fa-circle text-info"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Leaves Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('employee.leave-requests.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create a Leave Request</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('employee.leave-requests.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>My Leave Request Lists</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>

</aside>
