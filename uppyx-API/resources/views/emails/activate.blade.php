@extends('layouts.mail')

@section('contentMail')
    @if($lang == 'en')
        <div style="position: relative; min-height: 1px;padding-right: 15px;padding-left: 15px;">
            <div style="font-family: 'Open Sans', sans-serif;font-weight: normal;font-style: normal;font-stretch: normal; text-rendering: optimizeLegibility !important;-webkit-font-smoothing: antialiased !important;-moz-osx-font-smoothing: grayscale;">
                <p style="text-align: center; font-size: 23px; color: #4a4a4a;font-family: 'Open Sans Bold', sans-serif !important; font-weight: bold !important;font-style: normal;font-stretch: normal;">Welcome to uPPyx, {{$name}}</p>
                <p style="font-weight: normal; text-align: center; font-size: 17px; color: #4a4a4a;">Your account is ready to use.</p>
            </div>
        </div>
    @else
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td>
                    <p style="text-align: center; font-size: 23px; color: #4a4a4a;font-family: 'Open Sans Bold', sans-serif !important; font-weight: bold !important;font-style: normal;font-stretch: normal;">Bienvenido a uPPyx, {{$name}}</p>
                    <p style="font-weight: normal; text-align: center; font-size: 17px; color: #4a4a4a;">Tu cuenta está lista para usarse.</p>
                </td>
            </tr>
        </table>
    @endif
@endsection