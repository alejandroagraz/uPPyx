@extends('layouts.mail')

@section('contentMail')
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td>
                <div>
                    <p style="text-align: center !important; font-size: 23px; color: #4a4a4a;font-family: 'Open Sans Bold', sans-serif !important; font-weight: bold !important;font-style: normal;font-stretch: normal;">Bienvenido a uPPyx, {{$name}}</p>
                    <p style="font-weight: normal; text-align: center; font-size: 17px; color: #4a4a4a;">Tus credenciales para iniciar sesión son:</p>
                    <p style="font-weight: 600; text-align: center; font-size: 20px; font-style: italic; color: #00102d">Correo: {{$email}}</p>
                    <p style="font-weight: 600; text-align: center; font-size: 20px; font-style: italic; color: #00102d">Contraseña: {{$password}}</p>
                </div>
            </td>
        </tr>
    </table>
@endsection