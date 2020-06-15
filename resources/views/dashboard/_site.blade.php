
@extends('dashboard.layouts.app')

@section('content')

        @push('styles')

            @endpush
        @push('scripts')
            <script src="">
                
            </script>
            https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.js
            https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js
            https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js
            https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js
            @endpush

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                اداره المقالات
                <small>اللوحه العامه</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> لوحه التحكم</a></li>
                <li class="active">الرئيسية</li>
            </ol>
        </section>

            <!-- Main content -->
            <section class="content">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-2 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3>
                                    {{count($articles)}}
                                </h3>
                                <p>المقالات</p>
                            </div>
                            <div class="icon">
                                <i class=" fa fa-file"></i>
                            </div>
                            <a href="{{route('articles.index')}}" class="small-box-footer">عرض المقالات <i class="fa fa-arrow-circle-left"></i></a>
                        </div>
                    </div><!-- ./col -->
                    <div class="col-lg-2 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3>
                                    {{count($newspapers)}}
                                    <sup style="font-size: 20px"></sup></h3>
                                <p>
                                    الجرائد
                                </p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-newspaper-o"></i>
                            </div>
                            <a href="{{route('newspapers.index')}}" class="small-box-footer">عرض الجرائد <i class="fa fa-arrow-circle-left"></i></a>
                        </div>
                    </div><!-- ./col -->
                    <div class="col-lg-2 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-fuchsia-active">
                            <div class="inner">
                                <h3>
                                    {{count($departments)}}
                                    <sup style="font-size: 20px"></sup></h3>
                                <p>
                                    الاقسام
                                </p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-cubes"></i>
                            </div>
                            <a href="{{route('departments.index')}}" class="small-box-footer">عرض الاقسام <i class="fa fa-arrow-circle-left"></i></a>
                        </div>
                    </div><!-- ./col -->
                    <div class="col-lg-2 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <h3>
                                    {{count($authors)}}
                                </h3>
                                <p> الكتاب</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{route('authors.index')}}" class="small-box-footer"> عرض الكتاب <i class="fa fa-arrow-circle-left"></i></a>
                        </div>
                    </div><!-- ./col -->
                    <div class="col-lg-2 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-red">
                            <div class="inner">
                                <h3>
                                    {{count($tags)}}
                                </h3>
                                <p>  الكلمات المفتاحية</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-tags"></i>
                            </div>
                            <a href="{{route('tags.index')}}" class="small-box-footer"> عرض الكلمات المفتاحية <i class="fa fa-arrow-circle-left"></i></a>
                        </div>
                    </div><!-- ./col -->
                    <div class="col-lg-2 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-blue">
                            <div class="inner">
                                <h3>
                                    {{count($users)}}
                                </h3>
                                <p>  المشرفين</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-shield"></i>
                            </div>
                            <a href="{{route('users.index')}}" class="small-box-footer"> عرض المشرفين  <i class="fa fa-arrow-circle-left"></i></a>
                        </div>
                    </div><!-- ./col -->
                </div><!-- /.row -->
                <!-- Main row -->
            </section><!-- /.content -->







@endsection




