<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand ">
            <a href="{{ URL::TO('admin/dashboard')}}"><img alt="image" src="{{ asset('public/admin/assets/img/logo.png')}}" class="header-logo"/></a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown {{ (request()->is('admin/dashboard')) ? 'active' : '' }}">
                <a href="{{url('/admin/dashboard')}}" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            <li class="dropdown {{ (request()->is('admin/recruiter')) ? 'active' : '' }}">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="layout"></i><span>Recruiter</span></a>
                <ul class="dropdown-menu active">
                    <li><a class="nav-link" href="{{url('/admin/recruiter')}}">recruiter</a></li>
                </ul>
            </li>
            <li class="dropdown {{ (request()->is('admin/entertainer')) ? 'active' : '' }}">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="layout"></i><span>Entertainer</span></a>
                <ul class="dropdown-menu active">
                    <li><a class="nav-link" href="{{url('/admin/entertainer')}}">entertainer</a></li>
                </ul>
            </li>
            <li class="dropdown {{ (request()->is('admin/venue')) ? 'active' : '' }}">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="layout"></i><span>Venue</span></a>
                <ul class="dropdown-menu active">
                    <li><a class="nav-link" href="{{url('/admin/venue')}}">venue</a></li>
                </ul>
            </li>
           
            <li class="dropdown {{ (request()->is('admin/term-condition')) ? 'active' : '' }}">
                <a href="{{url('/admin/term-condition')}}" class="nav-link"><i data-feather="monitor"></i><span>Term&Condition</span></a>
            </li>
        </ul>
        </aside>
</div>
