<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'uPPyx') }}</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />

    <!-- Styles -->
    <!-- Bootstrap CDN -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Theme style - Css del Proyecto-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/uppyx.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/uppyx-dashboards.css') }}"/>

    <!-- Bootstrap Slider-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap-slider.css') }}"/>

    <!-- DataTables 1.10.12-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/plugins/datatables/jquery.dataTables.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/plugins/datatables/responsive.dataTables.min.css') }}"/>
    <!-- Disitntos estilos: link rel="stylesheet" type="text/css" href="{{-- asset('/plugins/datatables/dataTables.bootstrap.css') --}}"/-->

    <!-- Date Range Picker -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

    <!-- Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

    <!-- iCheck -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/plugins/icheck/square/grey.css') }}"/>

    <link rel="stylesheet" type="text/css" href="{{ asset('/css/uppyx-custom.css') }}"/>

</head>