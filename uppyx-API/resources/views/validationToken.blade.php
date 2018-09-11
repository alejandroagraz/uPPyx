@extends('layouts.mail')

@section('contentMail')
    @if($lang == 'en')
        <div style="float: left;position: relative;
                 min-height: 1px;padding-right: 15px;padding-left: 15px;">
            <div style="font-family: 'Open Sans', sans-serif;font-weight: normal;font-style: normal;font-stretch: normal;
                text-rendering: optimizeLegibility !important;-webkit-font-smoothing: antialiased !important;-moz-osx-font-smoothing: grayscale;">
                <p style="  text-align: center; font-size: 23px; color: #4a4a4a;font-family: 'Open Sans Bold', sans-serif !important;
                        font-weight: bold !important;font-style: normal;font-stretch: normal;">
                    We have received your request!
                </p>
                <p style="font-weight: normal; text-align: center; font-size: 17px; color: #4a4a4a;">
                    If you didn’t request this, Don’t worry!<br>
                    Your password still safe and you can ignore this email.
                </p>
                <p style="font-weight: 600; font-style: italic; text-align: center; font-size: 17px; color: #4a4a4a;">
                    Otherwise, click to set a new one:
                </p>
                <p style="text-align: center; padding-top: 10px;">
                    <a href="{{url('/password/reset/'.$token)}}"><img style="width: 80px; height: 80px;"
                                                  src="{{ asset('images/pass-uPPyx.png') }}" alt="uPPyx"></a>
                </p>
                <p style="font-weight: normal; text-align: center; font-size: 12px; color: #4a4a4a;">Click to reset your password</p>
            </div>
            <div style="font-family: 'Open Sans', sans-serif;font-weight: normal;font-style: normal;font-stretch: normal;
                text-rendering: optimizeLegibility !important;-webkit-font-smoothing: antialiased !important;-moz-osx-font-smoothing: grayscale;">
                <hr style="width: 50px; height: 1px; background-color: #9b9b9b;">
            </div>
            <div style="font-family: 'Open Sans', sans-serif;font-weight: normal;font-style: normal;font-stretch: normal;
                text-rendering: optimizeLegibility !important;-webkit-font-smoothing: antialiased !important;-moz-osx-font-smoothing: grayscale;">
                <p style="font-weight: normal; text-align: center; font-size: 13px; color: #9b9b9b;">Trouble clicking? copy an paste this URL into your browser.</p>
                <p style="font-weight: normal; text-align: center; font-size: 13px; color: #9b9b9b;">Copyable link: {{url('/password/reset/'.$token)}}</p>
            </div>
        </div>
    @else
        <div style="float: left;position: relative;
                 min-height: 1px;padding-right: 15px;padding-left: 15px;">
            <div style="font-family: 'Open Sans', sans-serif;font-weight: normal;font-style: normal;font-stretch: normal;
                text-rendering: optimizeLegibility !important;-webkit-font-smoothing: antialiased !important;-moz-osx-font-smoothing: grayscale;">
                <p style="  text-align: center; font-size: 23px; color: #4a4a4a;font-family: 'Open Sans Bold', sans-serif !important;
                        font-weight: bold !important;font-style: normal;font-stretch: normal;">
                    Recibimos tu solicitud!
                </p>
                <p style="font-weight: normal; text-align: center; font-size: 17px; color: #4a4a4a;">
                    Si no hiciste esta solicitud, no te preocupes!<br>
                    Tu contraseña sigue segura y puedes ignorar este email.
                </p>
                <p style="font-weight: 600; font-style: italic; text-align: center; font-size: 17px; color: #4a4a4a;">
                    En caso contrario, has clic en la siguiente imagen para establecer una nueva:
                </p>
                <p style="text-align: center; padding-top: 10px;">
                    <a href="{{url('/password/reset/'.$token)}}"><img style="width: 80px; height: 80px;" src="{{ asset('images/pass-uPPyx.png') }}" alt="uPPyx"></a>
                </p>
                <p style="font-weight: normal; text-align: center; font-size: 12px; color: #4a4a4a;">Clic para reestablecer tu contraseña</p>
            </div>
            <div style="font-family: 'Open Sans', sans-serif;font-weight: normal;font-style: normal;font-stretch: normal;
                text-rendering: optimizeLegibility !important;-webkit-font-smoothing: antialiased !important;-moz-osx-font-smoothing: grayscale;">
                <hr style="width: 50px; height: 1px; background-color: #9b9b9b;">
            </div>
            <div style="font-family: 'Open Sans', sans-serif;font-weight: normal;font-style: normal;font-stretch: normal;
                text-rendering: optimizeLegibility !important;-webkit-font-smoothing: antialiased !important;-moz-osx-font-smoothing: grayscale;">
                <p style="font-weight: normal; text-align: center; font-size: 13px; color: #9b9b9b;">¿Problemas al hacer clic en el botón? copie y pegue esta URL en la barra de direcciones de su navegador.</p>
                <p style="font-weight: normal; text-align: center; font-size: 13px; color: #9b9b9b; line-height: 14px;">Hipervínculo: {{url('/password/reset/'.$token)}}</p>
            </div>
        </div>
    @endif
@endsection