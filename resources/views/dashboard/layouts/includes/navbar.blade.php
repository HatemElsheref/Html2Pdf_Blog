
<header class="main-header">
    <!-- Logo -->
    <a href="{{route('dashboard')}}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>H</b>M</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>وزارة الاسكان </b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">


                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{asset('storage/users/'.auth()->user()->photo)}}" class="user-image" alt="User Image">
                        <span class="hidden-xs">{{ucwords(auth()->user()->name)}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{asset('storage/users/'.auth()->user()->photo)}}" class="img-circle" alt="User Image">
                            <p>
                               {{auth()->user()->name}}
                                <span class="fa fa-user"></span>
                                {{auth()->user()->roles[0]->description}}
                                <small>تم انشاء الحساب بتاريخ {{auth()->user()->created_at->format('d - m - Y')}}</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-right">
                                <a href="{{route('profile')}}" class="btn btn-default btn-flat">حسابي</a>
                            </div>
                            <div class="pull-left pull-right-en ">
                                <a href="{{route('logout')}}" class="btn btn-default btn-flat"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                                >تسجيل الخروج</a>
                            </div>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li style="display: none">
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
