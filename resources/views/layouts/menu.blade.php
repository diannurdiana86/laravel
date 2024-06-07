<div class="leftside-menu leftside-menu-detached">
    <div class="leftbar-user">
        <a href="javascript: void(0);">
            <img src="{{ url('/') }}/assets/images/users/avatar-1.jpg" alt="user-image" height="42"
                class="rounded-circle shadow-sm">
            <span class="leftbar-user-name">{{ Auth::user()->name }}</span>
        </a>
    </div>

    <ul class="side-nav">
        <li class="side-nav-item">
            <a href="{{ route('home') }}" class="side-nav-link">
                <i class="uil-home-alt"></i>
                <span> Home </span>
            </a>
        </li>

        @canany(['role/index', 'user/index'])
            <li class="side-nav-title side-nav-item">Manajemen User</li>
        @endcanany
        @canany(['role/index'])
            <li class="side-nav-item">
                <a href="{{ route('auth.roles.index') }}" class="side-nav-link">
                    <i class="uil-calender"></i>
                    <span> Manage Roles </span>
                </a>
            </li>
        @endcanany
        @canany(['user/index'])
            <li class="side-nav-item">
                <a href="{{ route('auth.users.index') }}" class="side-nav-link">
                    <i class="uil-calender"></i>
                    <span> Manage Users </span>
                </a>
            </li>
        @endcanany

        <li class="side-nav-title side-nav-item">Master Data</li>
        @canany(['master/products/index'])
            <li class="side-nav-item">
                <a href="{{ route('master.products.index') }}" class="side-nav-link">
                    <i class="uil-calender"></i>
                    <span> Manage Products </span>
                </a>
            </li>
        @endcanany
    </ul>

    <div class="help-box help-box-light text-center">
        <a href="javascript: void(0);" class="btn btn-outline-primary btn-sm">Panduan</a>
    </div>
    <div class="clearfix"></div>
</div>
