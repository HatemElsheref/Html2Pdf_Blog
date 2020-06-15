
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
                        الجريده
                    </a></li>
                <li class="active">
                    تعديل جريده
                </li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- Form column -->
                <div class="col-md-9">

                    <!-- general form elements -->
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                تعديل جريده
                            </h3>
                        </div><!-- /.box-header -->
                    @include('dashboard.layouts.includes.errors')
                    <!-- form start -->
                        <form role="form" method="post" action="{{route('newspapers.update',$newspaper->id)}}" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="name">الاسم</label>
                                    <input type="text" class="form-control" name="name" placeholder="ادخل الاسم" value="{{$newspaper->name}}">
                                </div>
                                <div class="form-group">
                                    <label for="name">الوصف</label>
                                    <input type="text" class="form-control" name="description" placeholder="ادخل وصف الكاتب" value="{{$newspaper->description}}">
                                </div>
                                <div class="form-group">
                                    <label for="photo">الصورة </label>
                                    <input type="file" class="form-control" name="photo" id="photo">
                                </div>
                            </div><!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> حفظ</button>
                            </div>
                        </form>
                    </div><!-- /.box -->
                </div><!--/.col (Form) -->
                <div class="col-md-3">
                    <img src="{{url('storage/newspapers/'.$newspaper->photo)}}" class="img-responsive img-responsive" >
                </div>

            </div>   <!-- /.row -->
        </section><!-- /.content -->
                                 s

@endsection




