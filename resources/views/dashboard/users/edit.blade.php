
@extends('dashboard.layouts.app')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                ادارة المشرفين
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i>
                        لوحة التحكم
                    </a></li>
                <li class="active"><a href="{{route('users.index')}}">
                        المشرفين
                    </a></li>
                <li class="active">
                    تعديل مشرف جديد
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
                                تعديل مشرف
                            </h3>
                        </div><!-- /.box-header -->
                    @include('dashboard.layouts.includes.errors')
                    <!-- form start -->
                        <form role="form" method="post" action="{{route('users.update',$user->id)}}" enctype="multipart/form-data">
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

                                <div class="form-group">
                                    <label for="permissions">الصلاحيات</label>
                                </div>
                            </div><!-- /.box-body -->

                            {{--Permissions zone--}}

                            @php
                                $models=[
                                'Users'=>'المشرفين',
                                'Authors'=>'الكتاب',
                                'Departments'=>'الاقسام',
                                'Tags'=>'الكلمات المفتاحية',
                                'NewsPaper'=>'الجرائد',
                                'Articles'=>'المقالات'
                                ];
                                $operations=[
                                'Users'=>['c','r','d','u'],
                                'Authors'=>['c','r','d','u'],
                                'Departments'=>['c','r','d','u'],
                                'Tags'=>['c','r','d','u'],
                                'NewsPaper'=>['c','r','d','u'],
                                'Articles'=>['c','r','d','u'],
                                ];
                                $map=[
                                'c'=>'create',
                                'r'=>'read',
                                'u'=>'update',
                                'd'=>'delete',
                                ];
                               $trans=[
                                'c'=>'اضافة',
                                'r'=>'قراءة',
                                'u'=>'تعديل',
                                'd'=>'حذف',
                                ];

                            @endphp
                            <div class="col-md-12">
                                <div class="nav-tabs-custom" >
                                    <ul class="nav nav-tabs">
                                        @foreach($models as $key =>$value)
                                            <li class=" @if($loop->first) active @endif ">
                                                <a href="#{{$key}}" data-toggle="tab" >{{$value}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <span class="clearfix"></span>
                                    <div class="tab-content">
                                        @foreach($operations as $key => $operation)
                                            <div class="tab-pane  @if($loop->first) active @endif " id="{{$key}}">
                                                <div style="margin-right: 0px;padding-right: 0px">
                                                    <div class="row">
                                                        <div class="col-md-12">

                                                            @foreach($operation as $crud_key)
                                                                <div class="form-group pull-right" style="margin-left: 10px">
                                                                    <div class="checkbox-inline">
                                                                        <input type="checkbox" id="{{strtolower($map[$crud_key].'_'.$key)}}$crud_operation.$key}}" value="{{strtolower($map[$crud_key].'_'.$key)}}" name="permissions[]"
                                                                            {{($user->hasPermission(strtolower($map[$crud_key].'_'.$key)))?'checked':''}}>
                                                                        <label for="{{strtolower($map[$crud_key].'_'.$key)}}">
                                                                            {{ucfirst($trans[$crud_key]).' '.$models[$key]}}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                            </div><!-- /.tab-pane -->
                                        @endforeach

                                    </div><!-- /.tab-content -->
                                </div>
                            </div><!-- /.col -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> حفظ</button>
                            </div>
                        </form>
                    </div><!-- /.box -->
                </div><!--/.col (Form) -->
            </div>   <!-- /.row -->
        </section><!-- /.content -->


@endsection




