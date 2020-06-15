
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{asset('dashboard/assets/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{asset('dashboard/assets/dist/css/AdminLTE.min.css')}}">
    <link rel="stylesheet" href="{{asset('dashboard/assets/plugins/iCheck/square/blue.css')}}">
    <link rel="stylesheet" href="{{asset('dashboard/assets/css/globalstyle.css')}}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="../../index2.html"><b>اسم الموقع</b></a>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">تسجيل الدخول</p>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group has-feedback">
                <input id="email" type="email" placeholder="ادخل البريد الالكترونى" class="form-control  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback text-danger small" role="alert">
                <strong class="@if(app()->getLocale()=='en') pull-right @endif">خطاء فى البريد الالكترونى او كلمة المرور</strong>
            </span>
                @enderror
                <span class="glyphicon glyphicon-envelope form-control-feedback login-icon"></span>
            </div>
            <div class="form-group has-feedback">
                <span class="glyphicon glyphicon-lock form-control-feedback login-icon"></span>
                <input id="password" placeholder="ادخل كلمة المرور" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                @error('password')
                <span class="invalid-feedback text-danger" role="alert">
                      <strong class="@if(app()->getLocale()=='en') pull-right @endif">خطاء فى البريد الالكترونى او كلمة المرور</strong>
                </span>
                @enderror
            </div>
            <div class="row">
                <div class="col-xs-12">

                    <div class="checkbox icheck @if(app()->getLocale()=='en') pull-right @endif">
                        <label>    تذكرنى

                             <input type="checkbox"  name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        </label>
                    </div>
                </div><!-- /.col -->
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">تسجيل الدخول</button>
                </div><!-- /.col -->
            </div>
        </form>

        <a href="#" class="@if(app()->getLocale()=='en') pull-right @endif">هل نسيت كلمه المرور</a><br>

    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->

<!-- jQuery 2.1.4 -->
<script src="{{asset('dashboard/assets/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
<!-- Bootstrap 3.3.4 -->
<script src="{{asset('dashboard/assets/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- iCheck -->
<script src="{{asset('dashboard/assets/plugins/iCheck/icheck.min.js')}}"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
</body>
</html>

