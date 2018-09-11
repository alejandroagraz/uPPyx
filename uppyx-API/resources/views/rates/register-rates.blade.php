@extends('layouts.app')

@section('content')
    <div class="container">
        <input type="hidden" value="{{url('city-configurations')}}" id="url-configurations">
        <ol class="breadcrumb">
            <li><a href="{{ route('rates.index') }}">Listar rental rates</a></li>
            <li class="active">Registrar nuevo rate<li>
        </ol>

        @if (session('status'))
            <p class="padding-top-msj msj-{{ Session::get('message_type') }}"><i class="fa fa-check-circle msj-{{ Session::get('message_type') }}" aria-hidden="true"></i> {{ Session::get('status') }}</p>
        @endif

        <!-- panel add -->
        <div class="panel-body-custom">
            <div class="panel panel-default panel-rates panel-rates-left col-md-11">
                <input type="hidden" value="{{url('validate-date-ranges')}}" id="url-ajax-ranges" />
                <input type="hidden" value="{{url('load-range-by-car')}}" id="url-load-range" />
                <input type="hidden" value="{{url('remove-rates-by-id')}}" id="url-ajax-remove-rates" />
                <div class="form-horizontal">
                    <div class="form-group">
                        <div class="col-md-4 col-md-4-custom">
                            <select class="form-control select-custom select-custom-left select-custom-moz search-history-rates" id="car" name="car">
                                <option selected="selected" value="" disabled>Tipo de vehículo</option>
                                @foreach($carTypes as $car)
                                    <option value="{{$car->id}}">{{$car->description}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 col-md-4-custom">
                            <select class="form-control select-custom select-custom-center select-custom-moz search-history-rates" id="country_id" name="country_id">
                                <option selected="selected" disabled>País</option>
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 col-md-4-custom">
                            <select class="form-control select-custom select-custom-right select-custom-moz search-history-rates" id="city_id" name="city_id">
                                <option selected="selected" disabled>Ciudad</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4">
                            <div class="row">
                                <input type="hidden" id="min" name="min" value="1">
                                <input type="hidden" id="max" name="max" value="21">
                                <div class="col-md-1">
                                    <label class="slider-legend slider-legend-left" id="label-min">1d</label>
                                </div>
                                <div class="col-md-9">
                                    <input id="slider-uppyx" type="text" data-slider-min="1" data-slider-max="21"
                                           data-slider-step="1" data-slider-value="[1,21]" data-slider-tooltip="always"/>
                                </div>
                                <div class="col-md-1">
                                    <label class="slider-legend slider-legend-right" id="label-max">21d</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <input type="hidden" name="from" id="from" value="">
                            <input type="hidden" name="to" id="to" value="">
                            <input class="date-custom" type="text" id="daterange" name="daterange" value="" />
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-rate input-custom input-custom-moz" id="amount" name="amount" placeholder="Costo" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body-custom">
            <div class="panel panel-default panel-rates panel-rates-right panel-rates-right panel-rates-right-ie col-md-1">
                <div class="form-horizontal">
                    <div class="form-group">
                        <div class="text-center">
                            <a href="#" class="preview-add-button"><i class="btn-circle fa fa-plus-circle"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- panel preview -->
        <div class="panel-table-custom col-md-12">
            <div class="row">
                <div class="col-md-12 padding-custom">
                    <div class="table-responsive">
                        <table class="table preview-table">
                            <thead>
                            <tr>
                            </tr>
                            </thead>
                            <tbody></tbody> <!-- preview content goes here-->
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts-extras')
    <script type="text/javascript">
        var country;

        $(document).ready(function () {

            country = $('#country_id').val();

            //Inicialización del componente Slider
            $('#slider-uppyx').slider({});
            $("#slider-uppyx").on("slide", function(slideEvt) {
                $("#min").val(slideEvt.value[0]);
                $("#max").val(slideEvt.value[1]);

                $("#label-min").text(slideEvt.value[0]+"d");
                $("#label-max").text(slideEvt.value[1]+"d");
            });

            //Prevenir negativos y permitir , o .
            $('#amount').keypress(function (event) {
                return isNumber(event, this)
            });

            function isNumber(evt, element) {

                var charCode = (evt.which) ? evt.which : event.keyCode

                if ((charCode != 46 || $(element).val().indexOf('.') != -1) && (charCode < 48 || charCode > 57)) {
                    if(charCode != 8){
                        return false;
                    }
                }

                var valid = /^\d{0,8}([\.]{1}\d{0,2})?$/.test(element.value)
                var val = element.value;

                if (!valid) {
                    element.value = val.substring(0, val.length - 1);
                    return false;
                }
                else{
                    return true;
                }
            }

            $("#amount").focusout(function(){
                //"" + parseFloat(this.value)
                $("#amount").val(this.value.replace(/^0+/, ''));
            });

            //Prevenir pegar en el input valor
            $('#amount').bind("cut copy paste",function(e) {
                e.preventDefault();
            });

            $('.search-history-rates').change(searchRate);

            function searchRate(){
                if($('#car').val() == null || $('#country_id').val() == null ||$('#city_id').val() == null){
                    return false;
                }
                $('.append').remove();
                val1 = '<tr class="append">';
                val1 += '<td colspan="7" class="text-center">Cargando...</td>';
                val1 += '</tr>';
                $('.preview-table').append(val1);
;
                $.ajax({
                    type: 'POST',
                    url: $('#url-load-range').val(),
                    data: {
                        'car': $('#car').val(),
                        'country_id': $('#country_id').val(),
                        'city_id': $('#city_id').val()
                    },
                    success: function(msg){
                        $('.append').remove();
                        if(msg.message == 'load'){
                            var qty = msg.data.length;
                            for(i=0; i<qty; i++){
                                preloadData(msg.data[i]);
                            }
                        }
                    }
                });
            }

            function preloadData(data){
                var city;
                if(data['city'] != null){
                    city = data['city']['name'];
                }else{
                    city = 'Todas las Ciudades';
                }
                val = '<tr class="id-'+data['id']+' append">';
                val += '<td class="col-sm-2 text-center table-rates">'+data['car_classification']['description']+'</td>';
                val += '<td class="col-sm-2 text-center table-rates">'+data['country']['name']+'</td>';
                val += '<td class="col-sm-2 text-center table-rates">'+city+'</td>';
                val += '<td class="col-sm-1 text-center table-rates">'+data['days_from']+' - '+data['days_to']+' d</td>';
                val += '<td class="col-md-2 text-center table-rates">'+data['valid_from']+' / '+data['valid_to']+'</td>';
                val += '<td class="col-sm-1 text-center table-rates">$'+data['amount']+'</td>';
                val += '<td class="col-sm-1 text-center table-rates"><span class="fa fa-minus-circle input-remove-row" data-value="'+data['id']+'"></span></td>';
                val += '</tr>';
                $('.preview-table').append(val);
            }

            $('.preview-add-button').click(function(){
                if($('#car').val() == null){
                    alert("Todos los campos son obligatorios");
                    return false;
                }
                if($('#daterange').val() === 'Válida desde / hasta'){
                    alert("Todos los campos son obligatorios");
                    return false;
                }
                if($('#amount').val() == ''){
                    alert("Todos los campos son obligatorios");
                    return false;
                }

                $('.preview-add-button').attr('disabled',true);
                $('.btn-circle').removeClass("fa-plus-circle").addClass('fa-cog fa-spin');

                $.ajax({
                    type: 'POST',
                    url: $('#url-ajax-ranges').val(),
                    data: {
                        'car': $('#car').val(),
                        'from': $('#from').val(),
                        'to': $('#to').val(),
                        'min': $('#min').val(),
                        'max': $('#max').val(),
                        'country_id': $('#country_id').val(),
                        'amount': $('#amount').val(),
                        'city_id': $('#city_id').val(),
                    },
                    success: function(msg){
                        $('.preview-add-button').attr('disabled',false);
                        $('.btn-circle').removeClass("fa-spin");
                        $('.btn-circle').removeClass("fa-cog").addClass('fa-plus-circle');
                        if(msg.message=='taken'){
                            alert("El rango de fecha/dias seleccionado genera conflicto.");
                        }else if(msg.message=='available'){
                            preloadData(msg.data);
                        }else{
                            alert(msg.message);
                        }
                    }
                });
                $('.form-rate').val('');
            });

            $(function() {
                $('input[name="daterange"]').daterangepicker({
                    "autoclose": true,
                    "autoApply": true,
                    //"minDate": new Date(),
                    "locale": {
                        "format": "DD/MM/YYYY",
                        "separator": " - ",
                        "applyLabel": "Aplicar",
                        "cancelLabel": "Cancelar",
                        "fromLabel": "Desde",
                        "toLabel": "Hasta",
                        "customRangeLabel": "Custom",
                        "weekLabel": "W",
                        "daysOfWeek": [
                            "Dom",
                            "Lun",
                            "Mar",
                            "Mie",
                            "Jue",
                            "Vie",
                            "Sab"
                        ],
                        "monthNames": [
                            "Enero",
                            "Febrero",
                            "Marzo",
                            "Abril",
                            "Mayo",
                            "Junio",
                            "Julio",
                            "Agosto",
                            "Septiembre",
                            "Octubre",
                            "Noviembre",
                            "Diciembre"
                        ],
                        "firstDay": 1
                    }
                },function(start, end) {
                        $('#from').val(start.format('YYYY-MM-DD'));
                        $('#to').val(end.format('YYYY-MM-DD'));
                    }
                );

                $('input[name="daterange"]').val('Válida desde / hasta');
            });

            $(document).on('click', '.input-remove-row', function(){
                $.ajax({
                    type: 'POST',
                    url: $('#url-ajax-remove-rates').val(),
                    data: {
                        'id': $(this).data("value"),
                    },
                    success: function(msg){
//                        console.log(msg);
                    }
                });

                var tr = $(this).closest('tr');
                tr.fadeOut(200, function(){
                    tr.remove();
                });
            });

            /*
             *Función para controlar los selectores de Pais/Ciudad.
             */
            $('#country_id').on('change',function(e){ //Country change
                var country_id = e.target.value;
                getCity(country_id);
            });

            function getCity(country_id) {
                $.get($('#url-configurations').val()+ '/' + country_id, function(data){
                    $('#city_id').empty();
                    $('#city_id').append('<option selected="selected" disabled>Ciudad</option>');
                    $.each(data, function(index, value){
                        $('#city_id').append('<option value="'+value.id+'">'+value.name+'</option>');
                    });
                    $('#city_id').append('<option value="0">Todas las Ciudades</option>');
                });
            }
        })
    </script>
    @include('layouts.partials.scriptalert')
@endsection