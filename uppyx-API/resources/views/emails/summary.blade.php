@extends('layouts.mail')

@section('contentMail')
    @if($lang == 'en')
        <div style="position: relative; min-height: 1px;padding-right: 15px;padding-left: 15px;">
            <div style="font-family: 'Open Sans', sans-serif;font-weight: normal;font-style: normal;font-stretch: normal; text-rendering: optimizeLegibility !important;-webkit-font-smoothing: antialiased !important;-moz-osx-font-smoothing: grayscale;">
                <p style="text-align: center; font-size: 23px; color: #4a4a4a;font-family: 'Open Sans Bold', sans-serif !important; font-weight: bold !important;font-style: normal;font-stretch: normal;">Hello, {{$managerName}}</p>
                <p style="font-weight: bolder; text-align: center; font-size: 17px; color: #4a4a4a;">Request Detail</p>
                <table cellspacing="0" cellpadding="10" border="1" align="center">
                    <tr>
                        <td width="100" style="font-weight: bolder; text-align: left; font-size: 17px; color: #4a4a4a;">Id</td>
                        <td width="300" style="font-weight: normal; text-align: left; font-size: 17px; color: #4a4a4a;">{{$id}}</td>
                    </tr>
                    <tr>
                        <td width="100" style="font-weight: bolder; text-align: left; font-size: 17px; color: #4a4a4a;">User</td>
                        <td width="300" style="font-weight: normal; text-align: left; font-size: 17px; color: #4a4a4a;">{{$userName}}</td>
                    </tr>
                    <tr>
                        <td width="100" style="font-weight: bolder; text-align: left; font-size: 17px; color: #4a4a4a;">PickUp Date</td>
                        <td width="300" style="font-weight: normal; text-align: left; font-size: 17px; color: #4a4a4a;">{{$pickupDate}}</td>
                    </tr>
                    <tr>
                        <td width="100" style="font-weight: bolder; text-align: left; font-size: 17px; color: #4a4a4a;">DropOff Date</td>
                        <td width="300" style="font-weight: normal; text-align: left; font-size: 17px; color: #4a4a4a;">{{$dropOffDate}}</td>
                    </tr>
                    <tr>
                        <td width="100" style="font-weight: bolder; text-align: left; font-size: 17px; color: #4a4a4a;">Daily Cost</td>
                        <td width="300" style="font-weight: normal; text-align: left; font-size: 17px; color: #4a4a4a;">{{$dailyCostCar}}</td>
                    </tr>
                    <tr>
                        <td width="100" style="font-weight: bolder; text-align: left; font-size: 17px; color: #4a4a4a;">Days</td>
                        <td width="300" style="font-weight: normal; text-align: left; font-size: 17px; color: #4a4a4a;">{{$days}}</td>
                    </tr>
                    <tr>
                        <td width="100" style="font-weight: bolder; text-align: left; font-size: 17px; color: #4a4a4a;">Tax</td>
                        <td width="300" style="font-weight: normal; text-align: left; font-size: 17px; color: #4a4a4a;">{{$tax}}</td>
                    </tr>
                    <tr>
                        <td width="100" style="font-weight: bolder; text-align: left; font-size: 17px; color: #4a4a4a;">Sales Tax</td>
                        <td width="300" style="font-weight: normal; text-align: left; font-size: 17px; color: #4a4a4a;">{{$salesTax}}</td>
                    </tr>
                    <tr>
                        <td width="100" style="font-weight: bolder; text-align: left; font-size: 17px; color: #4a4a4a;">Discount</td>
                        <td width="300" style="font-weight: normal; text-align: left; font-size: 17px; color: #4a4a4a;">$ {{$discount}}</td>
                    </tr>
                    <tr>
                        <td width="100" style="font-weight: bolder; text-align: left; font-size: 17px; color: #4a4a4a;">SubTotal</td>
                        <td width="300" style="font-weight: normal; text-align: left; font-size: 17px; color: #4a4a4a;">$ {{$subTotal}}</td>
                    </tr>
                    <tr>
                        <td width="100" style="font-weight: bolder; text-align: left; font-size: 17px; color: #4a4a4a;">Total</td>
                        <td width="300" style="font-weight: normal; text-align: left; font-size: 17px; color: #4a4a4a;">$ {{$total}}</td>
                    </tr>
                </table>
            </div>
        </div>
    @else
        <div style="position: relative; min-height: 1px;padding-right: 15px;padding-left: 15px;">
            <div style="font-family: 'Open Sans', sans-serif;font-weight: normal;font-style: normal;font-stretch: normal; text-rendering: optimizeLegibility !important;-webkit-font-smoothing: antialiased !important;-moz-osx-font-smoothing: grayscale;">
                <p style="text-align: center; font-size: 23px; color: #4a4a4a;font-family: 'Open Sans Bold', sans-serif !important; font-weight: bold !important;font-style: normal;font-stretch: normal;">Hola, {{$managerName}}</p>
                <p style="font-weight: normal; text-align: center; font-size: 17px; color: #4a4a4a;">Detalles de la solicitud:</p>
                <table cellspacing="0" cellpadding="10" border="1" align="center">
                    <tr>
                        <td width="100" style="font-weight: bolder; text-align: left; font-size: 17px; color: #4a4a4a;">Id</td>
                        <td width="300" style="font-weight: normal; text-align: left; font-size: 17px; color: #4a4a4a;">{{$id}}</td>
                    </tr>
                    <tr>
                        <td width="100" style="font-weight: bolder; text-align: left; font-size: 17px; color: #4a4a4a;">Cliente</td>
                        <td width="300" style="font-weight: normal; text-align: left; font-size: 17px; color: #4a4a4a;">{{$userName}}</td>
                    </tr>
                    <tr>
                        <td width="100" style="font-weight: bolder; text-align: left; font-size: 17px; color: #4a4a4a;">Fecha de entrega</td>
                        <td width="300" style="font-weight: normal; text-align: left; font-size: 17px; color: #4a4a4a;">{{$pickupDate}}</td>
                    </tr>
                    <tr>
                        <td width="100" style="font-weight: bolder; text-align: left; font-size: 17px; color: #4a4a4a;">Fecha de devolución</td>
                        <td width="300" style="font-weight: normal; text-align: left; font-size: 17px; color: #4a4a4a;">{{$dropOffDate}}</td>
                    </tr>
                    <tr>
                        <td width="100" style="font-weight: bolder; text-align: left; font-size: 17px; color: #4a4a4a;">Costo Diario</td>
                        <td width="300" style="font-weight: normal; text-align: left; font-size: 17px; color: #4a4a4a;">{{$dailyCostCar}}</td>
                    </tr>
                    <tr>
                        <td width="100" style="font-weight: bolder; text-align: left; font-size: 17px; color: #4a4a4a;">Dias rentados</td>
                        <td width="300" style="font-weight: normal; text-align: left; font-size: 17px; color: #4a4a4a;">{{$days}}</td>
                    </tr>
                    <tr>
                        <td width="100" style="font-weight: bolder; text-align: left; font-size: 17px; color: #4a4a4a;">Impuesto</td>
                        <td width="300" style="font-weight: normal; text-align: left; font-size: 17px; color: #4a4a4a;">{{$tax}}</td>
                    </tr>
                    <tr>
                        <td width="100" style="font-weight: bolder; text-align: left; font-size: 17px; color: #4a4a4a;">Impuesto de venta</td>
                        <td width="300" style="font-weight: normal; text-align: left; font-size: 17px; color: #4a4a4a;">{{$salesTax}}</td>
                    </tr>
                    <tr>
                        <td width="100" style="font-weight: bolder; text-align: left; font-size: 17px; color: #4a4a4a;">Descuento</td>
                        <td width="300" style="font-weight: normal; text-align: left; font-size: 17px; color: #4a4a4a;">{{$discount}} $</td>
                    </tr>
                    <tr>
                        <td width="100" style="font-weight: bolder; text-align: left; font-size: 17px; color: #4a4a4a;">SubTotal</td>
                        <td width="300" style="font-weight: normal; text-align: left; font-size: 17px; color: #4a4a4a;">{{$subTotal}} $</td>
                    </tr>
                    <tr>
                        <td width="100" style="font-weight: bolder; text-align: left; font-size: 17px; color: #4a4a4a;">Total</td>
                        <td width="300" style="font-weight: normal; text-align: left; font-size: 17px; color: #4a4a4a;">{{$total}} $</td>
                    </tr>
                </table>
            </div>
        </div>
    @endif
    <br>
@endsection