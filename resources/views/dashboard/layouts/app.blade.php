
@include('dashboard.layouts.includes.header')

@include('dashboard.layouts.includes.navbar')

@include('dashboard.layouts.includes.sidebar')

@include('sweetalert::alert')
   @yield('content')



@include('dashboard.layouts.includes.footer')
