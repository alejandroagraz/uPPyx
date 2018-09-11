@extends('layouts.mail')

@section('contentMail')
    @if(isset($lang))
        @if($lang == 'en')
            <div style="float: left;position: relative;
                     min-height: 1px;padding-right: 15px;padding-left: 15px;">
                <div style="font-family: 'Open Sans', sans-serif;font-weight: normal;font-style: normal;font-stretch: normal;
                    text-rendering: optimizeLegibility !important;-webkit-font-smoothing: antialiased !important;-moz-osx-font-smoothing: grayscale;">
                    <p style="text-align: center; font-size: 23px; color: #4a4a4a;font-family: 'Open Sans Bold', sans-serif !important;
                        font-weight: bold !important;font-style: normal;font-stretch: normal;">Hello, {{$name}}</p>
                    @if($totalRequests > 1)
                        <p style="font-weight: normal; text-align: center; font-size: 17px; color: #4a4a4a;">You
                            have {{$totalRequests}} requests pending to assign</p>
                    @else
                        <p style="font-weight: normal; text-align: center; font-size: 17px; color: #4a4a4a;">You
                            have {{$totalRequests}} request pending to assign</p>
                    @endif
                </div>
            </div>
        @else
            <div style="float: left;position: relative;
                     min-height: 1px;padding-right: 15px;padding-left: 15px;">
                <div style="font-family: 'Open Sans', sans-serif;font-weight: normal;font-style: normal;font-stretch: normal;
                    text-rendering: optimizeLegibility !important;-webkit-font-smoothing: antialiased !important;-moz-osx-font-smoothing: grayscale;">
                    <p style="text-align: center; font-size: 23px; color: #4a4a4a;font-family: 'Open Sans Bold', sans-serif !important;
                        font-weight: bold !important;font-style: normal;font-stretch: normal;">Hola, {{$name}}</p>
                    @if($totalRequests > 1)
                        <p style="font-weight: normal; text-align: center; font-size: 17px; color: #4a4a4a;">
                            Tienes {{$totalRequests}} solicitudes pendientes por asignar</p>
                    @else
                        <p style="font-weight: normal; text-align: center; font-size: 17px; color: #4a4a4a;">
                            Tienes {{$totalRequests}} una solicitud pendiente por asignar</p>
                    @endif
                </div>
            </div>
        @endif
    @else
        <div style="float: left;position: relative;
                     min-height: 1px;padding-right: 15px;padding-left: 15px;">
            <div style="font-family: 'Open Sans', sans-serif;font-weight: normal;font-style: normal;font-stretch: normal;
                    text-rendering: optimizeLegibility !important;-webkit-font-smoothing: antialiased !important;-moz-osx-font-smoothing: grayscale;">
                <p style="text-align: center; font-size: 23px; color: #4a4a4a;font-family: 'Open Sans Bold', sans-serif !important;
                        font-weight: bold !important;font-style: normal;font-stretch: normal;">Hola, {{$name}}</p>
                @if($totalRequests > 1)
                    <p style="font-weight: normal; text-align: center; font-size: 17px; color: #4a4a4a;">
                        Tienes {{$totalRequests}} solicitudes pendientes por asignar</p>
                @else
                    <p style="font-weight: normal; text-align: center; font-size: 17px; color: #4a4a4a;">
                        Tienes {{$totalRequests}} una solicitud pendiente por asignar</p>
                @endif
            </div>
        </div>
    @endif
@endsection