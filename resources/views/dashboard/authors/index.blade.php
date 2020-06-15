
@extends('dashboard.layouts.app')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                الكتاب
                <small>
                    <span class="badge btn-danger btn-sm">{{count($authors)}}</span>
                </small>

            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> اللوحة الرئيسيه</a></li>
                <li class="active">الكتاب</li>

            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row mb-4">
                <div class="col-md-7  mr-bottom-10">
                    <form method="get" action="{{route('authors.index')}}">
                        <div class="col-md-7" style="@if(app()->getLocale()=='ar') right:-15px @else left:-15px @endif">
                            <input type="text" name="search" class="form-control"placeholder="بحث" value="{{request()->query('search')}}" >
                        </div>
                        <div class="col-md-5">
                            <button type="submit" class="brn btn-sm btn-primary"><span class="fa fa-search"></span>بحث </button>
                            @if(auth()->user()->hasPermission('create_authors'))
                                <a href="{{route('authors.create')}}" class="brn btn-sm btn-danger"><span class="fa fa-plus"></span> اضافة كاتب جديد </a>
                            @else
                                <a href="#" disabled="" class="brn btn-sm btn-danger"><span class="fa fa-plus"></span> اضافه كاتب جديد </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">جدول الكتاب</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <table class="table table-bordered">

                                <tr>
                                    <th style="width: 10px">التسلسل</th>
                                    <th>الاسم</th>
                                    <th>الوصف</th>
                                    <th>الصوره الشخصية</th>
                                    <th>التحكم </th>
                                </tr>
                                @if($authors->count()==0)
                                    <tr>
                                        <td colspan="7" class="text-center">لا توجد سجلات</td>
                                    </tr>
                                @else

                                    @foreach($authors as $user)
                                        <tr>
                                            <td>{{$user->id}}.</td>
                                            <td>{{$user->name}}</td>

                                            <td>
                                                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-info-{{$user->id}}"
                                                > <i class="fa fa-expand"></i>  وصف الكاتب</button>

                                            </td>
                                            <td style="text-align: center"><img src="{{url('storage/authors/'.$user->photo)}}" style="width: 60px;height: 60px;"></td>
                                            <td>
                                                @if(auth()->user()->hasPermission('delete_authors'))
                                                    <form method="post" id="remove_user_form_{{$user->id}}" action="{{route('authors.destroy',$user->id)}}">
                                                        {{csrf_field()}}
                                                        {{method_field('DELETE')}}
                                                    </form>
                                                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-danger-{{$user->id}}"
                                                    > <i class="fa fa-trash"></i> حذف</button>
                                                    {{--Start Model Of Delete Notification--}}
                                                    <div class="modal modal-danger fade" id="modal-danger-{{$user->id}}" style="display: none;">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">×</span></button>
                                                                    <h4 class="modal-title">حذف كاتب</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>هل تريد تأكيد الحذف</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">الغاء</button>
                                                                    <button type="button" class="btn btn-outline"@if(app()->getLocale()=='en')style="float: right;" @endif
                                                                    onclick="document.getElementById('remove_user_form_{{$user->id}}').submit();"
                                                                    >تأكيد</button>
                                                                </div>
                                                            </div>
                                                            <!-- /.modal-content -->
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                    </div>
                                                    {{--End Model Of Delete Notification--}}

                                                @else
                                                    <button class="btn btn-danger" disabled=""><i class="fa fa-trash"></i>  حذف</button>
                                                @endif
                                                    <div class="modal modal-info fade" id="modal-info-{{$user->id}}" style="display: none;">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">×</span></button>
                                                                    <h4 class="modal-title">تفاصيل  كاتب</h4>
                                                                </div>
                                                                <div class="modal-body">

                                                                    <p>{{$user->description}}</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">اغلاق</button>
                                                                </div>
                                                            </div>
                                                            <!-- /.modal-content -->
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                    </div>

                                                @if(auth()->user()->hasPermission('update_authors'))
                                                    <a href="{{route('authors.edit',$user->id)}}" class="btn btn-sm btn-success"><i class="fa fa-edit"></i> تعديل</a>
                                                @else
                                                    <button class="btn btn-success" disabled=""><i class="fa fa-edit"></i> تعديل</button>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                @endif
                            </table>
                            {!! $authors->appends(['search'=>request()->query('search')])->render() !!}

                        </div><!-- /.box-body -->

                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->


@endsection
