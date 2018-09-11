@extends('layouts.mail')

@section('contentMail')
    @if($lang == 'en')
        <div style="position: relative; min-height: 1px;padding-right: 15px;padding-left: 15px;">
            <div style="font-family: 'Open Sans', sans-serif;font-weight: normal;font-style: normal;font-stretch: normal;
            text-rendering: optimizeLegibility !important;-webkit-font-smoothing: antialiased !important;-moz-osx-font-smoothing: grayscale;">
                <p style="text-align: center; font-size: 23px; color: #4a4a4a;font-family: 'Open Sans Bold', sans-serif !important;
                    font-weight: bold !important;font-style: normal;font-stretch: normal;">Confirm your account!</p>
                <p style="font-weight: normal; text-align: center; font-size: 17px; color: #4a4a4a;">Welcome to uPPyx, {{$name}}</p>
                <p style="font-weight: normal; text-align: center; font-size: 14px; color: #4a4a4a;">Your credentials for sign in are:</p>
                <p style="font-weight: 600; text-align: center; font-size: 20px; font-style: italic; color: #00102d">{{$email}}</p>
                <p style="text-align: center; padding-top: 10px;">
                    <a href="{{url('/activate-account/')}}/{{base64_encode($email)}}/{{($lang)}}"><img style="width: 80px; height: 80px;"
                                                                                                       src="{{ asset('images/send-uPPyx.png') }}" alt="uPPyx"></a>
                </p>
                <p style="font-weight: normal; text-align: center; font-size: 12px; color: #4a4a4a;">Click to verify your account</p>
            </div>
            <div style="font-family: 'Open Sans', sans-serif;font-weight: normal;font-style: normal;font-stretch: normal;
                text-rendering: optimizeLegibility !important;-webkit-font-smoothing: antialiased !important;-moz-osx-font-smoothing: grayscale;">
                <hr style="width: 50px; height: 1px; background-color: #9b9b9b; ">
            </div>
            <div style="font-family: 'Open Sans', sans-serif;font-weight: normal;font-style: normal;font-stretch: normal;
            text-rendering: optimizeLegibility !important;-webkit-font-smoothing: antialiased !important;-moz-osx-font-smoothing: grayscale;">
                <p style="font-weight: normal; text-align: center; font-size: 13px; color: #9b9b9b;">Trouble clicking? copy an paste this URL into your browser.</p>
                <p style="font-weight: normal; text-align: center; font-size: 13px; color: #9b9b9b;">Copyable link: {{url('/activate-account/')}}/{{base64_encode($email)}}/{{($lang)}}</p>
            </div>
        </div>
    @else
        <div style="position: relative; min-height: 1px;padding-right: 15px;padding-left: 15px;">
            <div>
                <p style="text-align: center; font-size: 23px; color: #4a4a4a;font-family: 'Open Sans Bold', sans-serif !important;
                    font-weight: bold !important;font-style: normal;font-stretch: normal;">Confirme su cuenta!</p>
                <p style="font-weight: normal; text-align: center; font-size: 17px; color: #4a4a4a;">Bienvenido a uPPyx, {{$name}}</p>
                <p style="font-weight: normal; text-align: center; font-size: 14px; color: #4a4a4a;">Sus credeciales para ingresar son:</p>
                <p style="font-weight: 600; text-align: center; font-size: 20px; font-style: italic; color: #00102d">{{$email}}</p>
                <p style="text-align: center; padding-top: 10px;">
                    <a href="{{url('/activate-account/')}}/{{base64_encode($email)}}/{{($lang)}}">
                        <img style="width: 80px; height: 80px;" src="{{ asset('images/send-uPPyx.png') }}" alt="uPPyx"></a>
                </p>
                <p style="font-weight: normal; text-align: center; font-size: 12px; color: #4a4a4a;">Clic para verificar su cuenta</p>
            </div>
            <div>
                <hr style="width: 50px; height: 1px; background-color: #9b9b9b;">
            </div>
            <div>
                <p style="font-weight: normal; text-align: center; font-size: 13px; color: #9b9b9b;">¿Problemas al activar la cuenta? copie y pegue esta URL en la barra de direcciones de su navegador.</p>
                <p style="font-weight: normal; text-align: center; font-size: 13px; color: #9b9b9b;">Hipervínculo: {{url('/activate-account/')}}/{{base64_encode($email)}}/{{($lang)}}</p>
            </div>
        </div>
    @endif

@endsection