@extends('dashboard.layouts.app')

@section('content')


    @push('scripts')


        <script src="https://cdn.tiny.cloud/1/4b2rd40qpdelgfmi3oofgocpnxs28fndbr734f0c12ctqmk0/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
            tinymce.init({
                selector: '#editor1',
                convert_urls: false,
                height:600,
                statusbar: false,

                plugins: 'image code print preview fullpage  searchreplace autolink directionality  visualblocks visualchars fullscreen image link    table charmap hr pagebreak nonbreaking  toc insertdatetime advlist lists textcolor wordcount   imagetools    contextmenu colorpicker textpattern media ',
                toolbar: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat |undo redo | image code| link fontsizeselect  | ',

                image_title: true,
                automatic_uploads: true,
                images_upload_url: '{{url("/articles/upload")}}',
                file_picker_types: 'image',
                file_picker_callback: function(cb, value, meta) {

                    var input = document.createElement('file');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');

                    input.onchange = function() {
                        var file = this.files[0];

                        var reader = new FileReader();
                        reader.readAsDataURL(file);
                        reader.onload = function () {
                            var id = 'blobid' + (new Date()).getTime();
                            var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                            var base64 = reader.result.split(',')[1];
                            var blobInfo = blobCache.create(id, file, base64);
                            blobCache.add(blobInfo);
                            cb(blobInfo.blobUri(), { title: file.name });
                        };
                    };
                    input.click();
                }
            });

            </script>
        <script src="{{asset('dashboard/assets/js/select2.js')}}"></script>
        <script>
            $(".js-example-tokenizer").select2({
                tags: true,
                tokenSeparators: [',', ' ']
            });

                   </script>

        <script>
            $('#newsPapers').on('change',function(){
                $.ajax({
                    url: '{{route('articles.departments')}}',
                    method: 'get',
                    data: {
                        'id':$(this).val()
                    },
                    success : function(data){
                        let d="";
                        for (var i=0;i<data.length;i++){
                            let obj=data[i];
                            d+=addOption(obj.id,obj.name);
                        }
                        if (d.length<10){
                            d="<option>لا توجد اقسام ف هذه الجريده</option>"
                        }
                        $('#departments').prop('disabled',false);
                        $('#departments').html(d);
                    }  ,
                    error:function (data) {
                        alert('invalid newspaper');
                    }
                });

            });
            function addOption(id,value){
                let option="<option value='"+id+"'>"+value+"</option>"
                return option;
            }
        </script>
        @endpush
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Contentlo Header (Page header) -->
            <section class="content-header">
            <h1>
            ادارة المقالات
        <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> لوحة التحكم</a></li>
        <li><a href="{{route('articles.index')}}">المقالات</a></li>
        <li class="active">اضافة مقاله جديده</li>
        </ol>
        </section>
        <!--Main Content-->
        <section class="content">
            <div class="row">

            <div class="col-md-9">
            @include('dashboard.layouts.includes.errors')
            <div class="box box-info">
            <div class="box-header">
            <h3 class="box-title">اضافة مقاله جديده
        <small></small>
        </h3>
        <!-- tools box -->
        <div class="pull-right box-tools">
            <button type="button" class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip"
        title="Collapse">
            <i class="fa fa-minus"></i></button>
        </div>
        <!-- /. tools -->
        </div>
        <!-- /.box-header -->

        <div class="box-body pad">
            <form action="{{route('articles.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
            <label for="title">العنوان الرئيسي</label>
        <input class="form-control" name="title" placeholder="ادخل العنوان الرئيسي"  id="title"  value="{{old('title')}}">
            </div>
                <div class="form-group">
                    <label for="subtitle">العنوان الفرعى</label>
                    <input class="form-control" name="subtitle" placeholder="ادخل العنوان الفرعى"  id="subtitle"  value="{{old('subtitle')}}">
                </div>
                <div class="form-group">
                    <label for="description">الوصف </label>
                    <textarea class="form-control" name="description"   id="description" >{{old('description')}} </textarea>
                </div>
                <div class="form-group">
{{--                    <button  class="btn btn-xs btn-default pull-right " onclick="upload();return false;" >upload image</button>--}}
{{--<br>--}}
{{--<br>--}}

{{--                    <input type="file" id="image-input" hidden style="display: none;" onchange='getImg(event)'>--}}
                    <!-- Input to browse your machine and select image to upload -->
                    <label for="content">المقال</label>
                    {{--                                    <textarea class="form-control" name="description" rows="5" placeholder="ادخل الوصف">{!! old('description') !!}</textarea>--}}
                    <textarea name="content" id="editor1" rows="10" cols="80"></textarea>
                </div>
            <div class="form-group">
            <label for="tags">اختر الكاتب</label>
        <select class="form-control" name="author_id"  style="height: 40px;" >
            <option selected disabled >اختر الكاتب</option>
        @foreach($authors as $author)
        <option value="{{$author->id}}" @if(old('author_id')==$author->id) selected @endif>
        {{$author->name}}
        </option>
        @endforeach
        </select>
        </div>
            <div class="form-group">
            <label for="tags">اختر الجريده</label>
        <select class="form-control" name="newspaper_id"  style="height: 40px;" id="newsPapers">
            <option selected disabled >اختر الجريده</option>
        @foreach($newspapers as $news)
        <option value="{{$news->id}}" @if(old('newspaper_id')==$news->id) selected @endif>
        {{$news->name}}
        </option>
        @endforeach
        </select>
        </div>
        <div class="form-group">
            <label for="tags">اختر القسم</label>
        <select class="form-control" name="department_id"  style="height: 40px;" disabled="" id="departments">
        </select>
        </div>
        <!-- /.form group -->
        <div class="form-group">
            <label for="tags">Tags</label>
            <select class="form-control js-example-tokenizer" id="tags" multiple name="tags[]">

            @foreach ($tags as $tag)
            <option value="{{$tag->id}}" @if(in_array($tag->id,(array)old('tags'))) selected @endif>
        {{$tag->name}}
        </option>
        @endforeach
        </select>
        </div>

            <div class="box-footer">
            <div class="pull-right">
            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> حفظ</button>

            </div>
        </div>
        </form>
        </div>
        </div>
        <!-- /. box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3">
            <a href="{{route('articles.index')}}" class="btn btn-primary btn-block margin-bottom">عرض كل المقالات</a>
        <div class="box box-solid">
            <div class="box-header with-border">
            <h3 class="box-title">الجرائد</h3>

            <div class="box-tools">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            </div>
            </div>
            <div class="box-body no-padding" style="">
            <ul class="nav nav-pills nav-stacked">
            @foreach($newspapers as $newspaper)
            <li style="cursor: none">
            {{--                                            <a href="{{route('newspapers.show',$newspaper->id)}}"><i class="fa fa-bars"></i>--}}
            <a href="{{url('articles/show?newspaper_id='.$newspaper->id.'&filter=بحث')}}" style="cursor: default"><i class="fa fa-bars"></i>
            {{$newspaper->name}}
            <span class="label label-primary pull-left">{{$newspaper->departments->count()}}</span>
            </a>
            </li>
            @endforeach
            </ul>
            </div>
            <!-- /.box-body -->
            </div>
            <!-- /. box -->
            <div class="box box-solid">
            <div class="box-header with-border">
            <h3 class="box-title">الكلمات المفتاحية</h3>

        <div class="box-tools">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding" style="">
            <ul class="nav nav-pills nav-stacked">
            @foreach($tags as $tag)
            <li>
            <a  style="cursor: default;"><i class="fa fa-tags"></i> {{$tag->name}}
                <span class="label label-warning pull-left">
            {{$tag->articles->count()}}
            </span>
            </a>
            </li>
            @endforeach
            </ul>
            </div>
            <!-- /.box-body -->
            </div>
            <!-- /.box -->
            </div>
            <!-- /.col -->
            </div>
            <!-- /.row -->
            </section>
            <!-- /.content -->
            </div>
    <!-- Pop-up Modal to display image URL -->
    <div class="modal fade copy-url-result" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Click below to copy image url</h4>
                </div>
                <div class="modal-body">
                    <!-- returned image url will be displayed here -->
                    <input
                        type="text"
                        id="post_image_url"
                        onclick="return copyUrl()"
                        class="form-control"
                    >
                    <p id="feedback_msg" style="color: green; display: none;"><b>Image url copied to clipboard</b></p>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection

