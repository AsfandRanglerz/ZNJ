<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html"> <img alt="image" src="{{ asset('public/admin/assets/img/logo.png')}}" class="header-logo" /> <span
                    class="logo-name">The Riser</span>
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown {{ (request()->is('admin/dashboard')) ? 'active' : '' }}">
                <a href="{{url('/admin/dashboard')}}" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
            </li>

            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="layout"></i><span>Teams</span></a>
                <ul class="dropdown-menu active">
                    <li><a class="nav-link" href="">common</a></li>

                </ul>
            </li>
            <li class="dropdown {{ (request()->is('admin/Privacy-policy')) ? 'active' : '' }}">
                <a href="{{url('/admin/Privacy-policy')}}" class="nav-link"><i data-feather="monitor"></i><span>Privacy policy</span></a>
            </li>
            <li class="dropdown {{ (request()->is('admin/term-condition')) ? 'active' : '' }}">
                <a href="{{url('/admin/term-condition')}}" class="nav-link"><i data-feather="monitor"></i><span>Term&Condition</span></a>
            </li>
        </ul>
    </aside>
</div>
