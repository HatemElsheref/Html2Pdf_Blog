<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>
        وزارة الاسكان
    </title>

    <meta name="csrf-token" content="{{ csrf_token() }}" />


        <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link rel="stylesheet" href="{{asset('dashboard/assets/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('dashboard/assets/css/dt.css')}}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons 2.0.0 -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dashboard/assets/dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('dashboard/assets/dist/css/skins/_all-skins.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('dashboard/assets/plugins/iCheck/flat/blue.css')}}">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{asset('dashboard/assets/plugins/morris/morris.css')}}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{asset('dashboard/assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css')}}">

    @stack('styles')

    <link rel="stylesheet" href="{{asset('dashboard/assets/dist/fonts/fonts-fa.css')}}">


        <link rel="stylesheet" href="{{asset('dashboard/assets/dist/css/bootstrap-rtl.min.css')}}">
        <link rel="stylesheet" href="{{asset('dashboard/assets/dist/css/rtl.css')}}">
{{--        <link rel="stylesheet" href="{{asset('dashboard/assets/css/ltr-en.css')}}">--}}
    <link rel="stylesheet" href="{{asset('dashboard/assets/css/select2.css')}}">
    <link rel="stylesheet" href="{{asset('dashboard/assets/css/dt.css')}}">

    <link rel="stylesheet" href="{{asset('dashboard/assets/css/globalstyle.css')}}">


<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <![endif]-->
   <style>
       .select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__choice{
           background-color: #0babf3;
       }
       .select2-container{
           width: 100% !important;
       }
       div.dataTables_wrapper div.dataTables_filter label{
           float: right;
       }
       #example1_length{
           float: left;
       }
       .paginate_button{
           background-color: rgb(60, 141, 188);
           color: #Fff;
           padding: 5px;
           cursor: pointer;
           display: inline-block;
           margin: 1px;
           border-radius: 5px;
           border:1px solid #0babf3;
           box-shadow: #0babf3;
       }
       .paginate_button:hover{
           color: #fff;
       }
   </style>

</head>
<body class="skin-blue sidebar-mini ">

<div class="wrapper">
