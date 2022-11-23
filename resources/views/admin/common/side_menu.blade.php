<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand ">
            <a href="{{ URL::TO('admin/dashboard')}}"><img alt="image" src="{{ asset('public/admin/assets/img/logo.png')}}" class="header-logo"/></a>
        </div>
        <ul class="sidebar-menu">
            <li class="dropdown {{ (request()->is('admin/dashboard')) ? 'active' : '' }}">
                <a href="{{url('/admin/dashboard')}}" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            {{-- <li class="dropdown {{ (request()->is('admin/recruiter*')) ? 'active' : '' }}">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="layout"></i><span>Recruiter</span></a>
                <ul class="dropdown-menu active">
                    <li><a class="nav-link" href="{{url('/admin/recruiter')}}">recruiter</a></li>
                </ul>
            </li>
            <li class="dropdown {{ (request()->is('admin/entertainer*')) ? 'active' : '' }}">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="layout"></i><span>Entertainer</span></a>
                <ul class="dropdown-menu active">
                    <li><a class="nav-link" href="{{url('/admin/entertainer')}}">entertainer</a></li>
                </ul>
            </li> --}}
            <li class="dropdown {{ (request()->is('admin/users/index*')) ? 'active' : '' }}">
                <a href="{{route('admin.user.index')}}" class="nav-link"><i class="fa fa-users"></i><span>Users</span></a>
                {{-- <ul class="dropdown-menu active"> --}}
                {{-- <ul class="dropdown-menu active ">
                    <li><a class="nav-link"  href="{{route('admin.user.index')}}">user</a></li>
                </ul> --}}
            </li>
            {{-- <li class="dropdown {{ (request()->is('admin/Privacy-policy')) ? 'active' : '' }}">
                <a href="{{url('/admin/Privacy-policy')}}" class="nav-link"><i data-feather="monitor"></i><span>Privacy&Policy</span></a>
            </li> --}}

            {{-- <li class="dropdown {{ (request()->is('admin/term-condition')) ? 'active' : '' }}">
                <a href="{{url('/admin/term-condition')}}" class="nav-link"><i data-feather="monitor"></i><span>Term&Condition</span></a>
            </li> --}}
            <li class="dropdown {{ (request()->is('admin/pages/intro-video*')) ? 'active' : '' }}">
                <a class="nav-link" href="{{url('/admin/pages/intro-video')}}" class="nav-link"> <i class="fa fa-play-circle-o"></i><span> Introduction Video</span></a>
            </li>
            <li class="dropdown {{ (request()->is('admin/talent/index*')) ? 'active' : '' }}">
                <a href="{{route('talent.index')}}" class="nav-link"><i class="fa fa-users"></i><span>Talent Category</span></a>
            </li>


            {{-- <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown">
                    <i data-feather="layout"></i><span>Pages</span></a>
                <ul class="dropdown-menu active">

                </ul>

            </li> --}}
        </ul>
        </aside>
</div>
