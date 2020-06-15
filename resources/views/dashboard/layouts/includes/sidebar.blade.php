<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-right image">
                <img src="{{asset('storage/users/'.auth()->user()->photo)}}" class="img-circle" alt="User Image" style="width: 40px;height: 40px;">
            </div>
            <div class="pull-left pull-right-en  info">
                <p>
                    {{auth()->user()->name}}</p>
                <a href="#">
                    <i class="fa fa-circle text-success"></i>
                        اونلاين
                </a>
            </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">لوحة التحكم</li>
            <li class="active treeview">


            </li>
            <li style="cursor:pointer;">
                <a href="{{route('dashboard')}}" >
                    <i class="fa fa-dashboard"></i>
                    <span>الصفحة الرئسية</span>
                </a>
            </li>
            @if(auth()->user()->hasPermission('read_users'))
                <li style="cursor:pointer;">
                    <a href="{{route('users.index')}}" >
                        <i class="fa  fa-shield"></i>
                        <span> المشرفين</span>
                    </a>
                </li>
            @endif
            @if(auth()->user()->hasPermission('read_authors'))
            <li style="cursor:pointer;">
                <a href="{{route('authors.index')}}" >
                    <i class="fa fa-pencil-square-o"></i>
                    <span>الكتاب</span>
                </a>
            </li>
            @endif
            @if(auth()->user()->hasPermission('read_newspaper'))
            <li style="cursor:pointer;">
                <a href="{{route('newspapers.index')}}" >
                    <i class="fa fa-newspaper-o"></i>
                    <span> الجرائد</span>
                </a>
            </li>
            @endif
            @if(auth()->user()->hasPermission('read_departments'))
            <li style="cursor:pointer;">
                <a href="{{route('departments.index')}}" >
                    <i class="fa fa-cubes"></i>
                    <span> الاقسام</span>
                </a>
            </li>
            @endif
            @if(auth()->user()->hasPermission('read_tags'))
            <li style="cursor:pointer;">
                <a href="{{route('tags.index')}}" >
                    <i class="fa fa-tags"></i>
                    <span> الكلمات المفتاحية</span>
                </a>
            </li>
            @endif
            @if(auth()->user()->hasPermission('read_articles'))
            <li style="cursor:pointer;">
                <a href="{{route('articles.index')}}" >
                    <i class="fa  fa-file-word-o"></i>
                    <span>  المقالات</span>
                </a>
            </li>
            @endif
            @if(auth()->user()->hasPermission('read_articles'))
                <li style="cursor:pointer;">
                    <a href="{{route('articles.show')}}" >
                        <i class="fa  fa-file-word-o"></i>
                        <span> فلتر مقالات </span>
                    </a>
                </li>
            @endif


        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
