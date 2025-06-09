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
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('design/dist/img/AdminLTELogo.png') }}" alt="Leave Management"
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

        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="nav-icon far fa-circle text-info"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.leave-requests.index') }}" class="nav-link">
                        <i class="nav-icon far fa-circle text-info"></i>
                        <p> Leave Managements</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link">
                        <i class="nav-icon far fa-circle text-info"></i>
                        <p>Employee Add List</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

</aside>
