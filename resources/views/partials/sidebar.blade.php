<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4 sidebar-light-success">
    <!-- Brand Logo -->
    <a href="@auth{{ route('dashboard') }}@else{{ route('pages.vision_mission') }}@endauth" class="brand-link text-sm">
        <img src="{{ asset('images/logo.png') }}" alt="BSF" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">BSF SSG Management</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        @auth
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset(Auth::user()->avatar()) }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">
                    @if (Auth::user()->student)
                        {{ Auth::user()->student->student->first_name }}
                        {{ Auth::user()->student->student->last_name }}
                    @elseif (Auth::user()->faculty)
                        @if(Auth::user()->role->role_id == 1 || Auth::user()->role->role_id == 2)
                        Administrator
                        @else
                        {{ Auth::user()->faculty->faculty->first_name }}
                        {{ Auth::user()->faculty->faculty->last_name }}
                        @endif
                    @endif
                </a>
            </div>
        </div>
        @endauth
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
                @guest
                    <li class="nav-item">
                        <a href="{{ route('pages.vision_mission') }}" class="nav-link">
                            <i class="nav-icon fas fa-dot-circle"></i>
                            <p>
                                Vision/Mission
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pages.achievements') }}" class="nav-link">
                            <i class="nav-icon fas fa-trophy"></i>
                            <p>
                                Achievements
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pages.officers') }}" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Officers
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link">
                            <i class="nav-icon fas fa-sign-in-alt"></i>
                            <p>
                                Login
                            </p>
                        </a>
                    </li>
                @endguest
                @auth
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pages.officers') }}" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Officers
                            </p>
                        </a>
                    </li>
                    @can('achievements.index')
                    <li class="nav-item">
                        <a href="{{ route('achievements.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-trophy"></i>
                            <p>
                                Achievements
                            </p>
                        </a>
                    </li>
                    @endcan
                    @can('announcements.index')
                    <li class="nav-item">
                        <a href="{{ route('announcements.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-bullhorn"></i>
                            <p>
                                Announcements
                            </p>
                        </a>
                    </li>
                    @endcan
                    @can('elections.index')
                    <li class="nav-item">
                        <a href="{{ route('elections.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-poll-people"></i>
                            <p>
                                Elections
                            </p>
                        </a>
                    </li>
                    @endcan
                    @can('votes.index')
                    <li class="nav-item">
                        <a href="{{ route('votes.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-box-ballot"></i>
                            <p>
                                Votes
                            </p>
                        </a>
                    </li>
                    @endcan
                    @can('results.index')
                    <li class="nav-item">
                        <a href="{{ route('elections.results') }}" class="nav-link">
                            <i class="nav-icon fas fa-poll"></i>
                            <p>
                                Results
                            </p>
                        </a>
                    </li>
                    @endcan
                    @can('tasks.index')
                    @if(Auth::user()->hasrole('System Administrator') || Auth::user()->isOfficer())
                    <li class="nav-item">
                        <a href="{{ route('tasks.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-list"></i>
                            <p>
                                Tasks
                            </p>
                        </a>
                    </li>
                    @endif
                    @endcan
                    @can('partylists.index')
                    <li class="nav-item">
                        <a href="{{ route('partylists.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-users-class"></i>
                            <p>
                                Partylists
                            </p>
                        </a>
                    </li>
                    @endcan
                    @can('students.index')
                    <li class="nav-item">
                        <a href="{{ route('students.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-users-class"></i>
                            <p>
                                Students
                            </p>
                        </a>
                    </li>
                    @endcan
                    @can('faculties.index')
                    <li class="nav-item">
                        <a href="{{ route('faculties.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-chalkboard-teacher"></i>
                            <p>
                                Faculties
                            </p>
                        </a>
                    </li>
                    @endcan
                    @can('users.index')
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-user-lock"></i>
                            <p>
                                Users
                            </p>
                        </a>
                    </li>
                    @endcan
                    @canany([
                        'sections.index',
                        'positions.index',
                        'roles.index'
                    ])
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>
                                Configuration
                                <i class="fas fa-angle-left right"></i>
                                {{-- <span class="badge badge-info right">6</span> --}}
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('sections.index')
                            <li class="nav-item">
                                <a href="{{ route('sections.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Sections</p>
                                </a>
                            </li>
                            @endcan
                            @can('positions.index')
                            <li class="nav-item">
                                <a href="{{ route('positions.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Positions</p>
                                </a>
                            </li>
                            @endcan
                            @can('roles.index')
                            <li class="nav-item">
                                <a href="{{ route('roles.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Roles/Permissions</p>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @endcanany
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="nav-icon fas fa-sign-out"></i>
                            <p>
                                Logout
                            </p>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li> --}}
                @endauth
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>