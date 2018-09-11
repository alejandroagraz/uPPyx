@extends('layouts.mail')
<?php

$style = [
    /* Layout ------------------------------ */

    'body' => 'margin: 0; padding: 0; width: 100%; background-color: #F2F4F6;',
    'email-wrapper' => 'width: 100%; margin: 0; padding: 0; background-color: #F2F4F6;',

    /* Masthead ----------------------- */

    'email-masthead' => 'padding: 25px 0; text-align: center;',
    'email-masthead_name' => 'font-size: 16px; font-weight: bold; color: #2F3133; text-decoration: none; text-shadow: 0 1px 0 white;',

    'email-body' => 'width: 100%; margin: 0; padding: 0; border-top: 1px solid #EDEFF2; border-bottom: 1px solid #EDEFF2; background-color: #FFF;',
    'email-body_inner' => 'width: auto; max-width: 570px; margin: 0 auto; padding: 0;',
    'email-body_cell' => 'padding: 35px;',

    'email-footer' => 'width: auto; max-width: 570px; margin: 0 auto; padding: 0; text-align: center;',
    'email-footer_cell' => 'color: #AEAEAE; padding: 35px; text-align: center;',

    /* Body ------------------------------ */

    'body_action' => 'width: 100%; margin: 30px auto; padding: 0; text-align: center;',
    'body_sub' => 'margin-top: 25px; padding-top: 25px; border-top: 1px solid #EDEFF2;',

    /* Type ------------------------------ */

    'anchor' => 'color: #3869D4;',
    'header-1' => 'margin-top: 0; color: #2F3133; font-size: 19px; font-weight: bold; text-align: left;',
    'paragraph' => 'margin-top: 0; color: #74787E; font-size: 16px; line-height: 1.5em;',
    'paragraph-sub' => 'margin-top: 0; color: #74787E; font-size: 12px; line-height: 1.5em;',
    'paragraph-center' => 'text-align: center;',

    /* Buttons ------------------------------ */

    'button' => 'display: block; display: inline-block; width: 200px; min-height: 20px; padding: 10px;
                 background-color: #3869D4; border-radius: 3px; color: #ffffff; font-size: 15px; line-height: 25px;
                 text-align: center; text-decoration: none; -webkit-text-size-adjust: none;',

    'button--green' => 'background-color: #22BC66;',
    'button--red' => 'background-color: #dc4d2f;',
    'button--blue' => 'background-color: #3869D4;',
];
?>

<?php $fontFamily = 'font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;'; ?>

@section('contentMail')

        <div style="font-family: 'Open Sans', sans-serif;font-weight: normal;font-style: normal;font-stretch: normal;
            text-rendering: optimizeLegibility !important;-webkit-font-smoothing: antialiased !important;-moz-osx-font-smoothing: grayscale;">
            <p style="text-align: center; font-size: 23px; color: #4a4a4a;font-family: 'Open Sans Bold', sans-serif !important;
                    font-weight: bold !important;font-style: normal;font-stretch: normal;">
                @if (! empty($greeting))
                    {{ $greeting }}
                @else
                    @if ($level == 'error')
                        Whoops!
                    @else
                        Recibimos tu solicitud!
                    @endif
                @endif
            </p>
            <p style="font-weight: normal; text-align: center; font-size: 17px; color: #4a4a4a;">
                Si no hiciste esta solicitud, no te preocupes!<br>
                Tu contraseña sigue segura y puedes ignorar este email.
            </p>
            <p style="font-weight: 600; font-style: italic; text-align: center; font-size: 17px; color: #4a4a4a;">
                En caso contrario, has clic en la siguiente imagen para establecer una nueva:
            </p>

            <p style="text-align: center; padding-top: 25px;">
                <a href="{{$actionUrl}}"><img style="width: 80px; height: 80px;"
                                              src="{{ asset('images/pass-uPPyx.png') }}" alt="uPPyx"></a>
            </p>
            <p style="font-weight: normal; text-align: center; font-size: 12px; color: #4a4a4a;">Clic para reestablecer tu contraseña</p>
        </div>
        <div style="font-family: 'Open Sans', sans-serif;font-weight: normal;font-style: normal;font-stretch: normal;
            text-rendering: optimizeLegibility !important;-webkit-font-smoothing: antialiased !important;-moz-osx-font-smoothing: grayscale;">
            <hr style="width: 50px; height: 1px; border-radius: 100px; background-color: #9b9b9b; border: solid 1px #9b9b9b;">
        </div>
        <div style="font-family: 'Open Sans', sans-serif;font-weight: normal;font-style: normal;font-stretch: normal;
            text-rendering: optimizeLegibility !important;-webkit-font-smoothing: antialiased !important;-moz-osx-font-smoothing: grayscale;">
            <p style="font-weight: normal; text-align: center; font-size: 13px; color: #9b9b9b;">¿Problemas al hacer clic en el botón? copie y pegue esta URL en la barra de direcciones de su navegador.</p>
            <p style="font-weight: normal; text-align: center; font-size: 13px; color: #9b9b9b;">Hipervínculo: {{$actionUrl}}</p>
        </div>
@endsection
