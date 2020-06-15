
@extends('dashboard.layouts.app')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                ادارة الجرائد
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i>
                        لوحة التحكم
                    </a></li>
                <li class="active"><a href="{{route('newspapers.index')}}">
                        الجرائد
                    </a></li>
                <li class="active">
                    اضافة جريده جديده
                </li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- Form column -->
                <div class="col-md-12">

                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                اضافة جريده جديده
                            </h3>
                        </div><!-- /.box-header -->
                    @include('dashboard.layouts.includes.errors')
                    <!-- form start -->
                        <form role="form" method="post" action="{{route('newspapers.store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="name">الاسم</label>
                                    <input type="text" class="form-control" name="name" placeholder="ادخل الاسم" value="{{old('name')}}">
                                </div>
                                <div class="form-group">
                                    <label for="name">الوصف</label>
                                    <input type="text" class="form-control" name="description" placeholder="ادخل وصف الكاتب" value="{{old('description')}}">
                                </div>
                                <div class="form-group">
                                    <label for="photo">الصورة </label>
                                    <input type="file" class="form-control" name="photo" id="photo">
                                </div>
                            </div><!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> حفظ</button>
                            </div>
                        </form>
                    </div><!-- /.box -->
                </div><!--/.col (Form) -->
            </div>   <!-- /.row -->
        </section><!-- /.content -->


@endsection




