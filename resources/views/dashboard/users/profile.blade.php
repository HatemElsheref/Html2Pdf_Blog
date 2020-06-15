
@extends('dashboard.layouts.app')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                حسابي
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i>
                        لوحة التحكم
                    </a></li>
                <li class="active"><a href="{{route('users.index')}}">
                        المشرفين
                    </a></li>
                <li class="active">
                    تعديل بياناتى الشخصيه
                </li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- Form column -->
                <div class="col-md-12">

                    <!-- general form elements -->
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                بياناتى
                            </h3>
                        </div><!-- /.box-header -->
                    @include('dashboard.layouts.includes.errors')
                    <!-- form start -->
                        <form role="form" method="post" action="{{route('update.profile')}}" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="name">الاسم</label>
                                    <input type="text" class="form-control" name="name" placeholder="ادخل الاسم" value="{{$user->name}}">
                                </div>
                                <div class="form-group">
                                    <label for="email">البريد الالكترونى</label>
                                    <input type="email" class="form-control" name="email" placeholder="ادخل البريد الالكترونى" value="{{$user->email}}">
                                </div>
                                <div class="form-group">
                                    <label for="photo">الصورة الشخصيه</label>
                                    <input type="file" class="form-control" name="photo" id="photo">
                                </div>
                                <div class="form-group">
                                    <label for="password">كلمة المرور</label>
                                    <input type="password" class="form-control" name="password" placeholder="ادخل كلمة المرور">
                                </div>
                                <div class="form-group">
                                    <label for="confirmationpassword">تأكيد كلمة المرور</label>
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="تأكيد كلمة المرور">
                                </div>

                            </div><!-- /.box-body -->

                            {{--Permissions zone--}}

                            <div class="box-footer">
                                <button type="submit" class="btn btn-success"><i class="fa fa-edit"></i> حفظ</button>
                            </div>
                        </form>
                    </div><!-- /.box -->
                </div><!--/.col (Form) -->
            </div>   <!-- /.row -->
        </section><!-- /.content -->


@endsection




