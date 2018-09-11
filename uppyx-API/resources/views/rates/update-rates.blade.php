@extends('layouts.app')

@section('content')
    <div class="container">
        <input type="hidden" value="{{url('city-configurations')}}" id="url-configurations">
        <ol class="breadcrumb">
            <li><a href="{{ route('rates.index') }}">Listar rental rates</a></li>
            <li><a href="{{ route('rates.create') }}">Registrar nuevo rate</a><li>
            <li class="active">Actualizar Rate</li>
        </ol>

        @if (session('status'))
            <p class="padding-top-msj msj-{{ Session::get('message_type') }}"><i class="fa fa-check-circle msj-{{ Session::get('message_type') }}" aria-hidden="true"></i> {{ Session::get('status') }}</p>
        @endif

        @if ($errors->has('exist'))
            <p class="colorRedFont">
                {{ $errors->exists->first() }}
            </p>
        @endif

        <div class="panel">
            <div class="panel-body">
                <div class="form-group col-md-offset-3 col-md-6">
                    <form class="form-horizontal" method="POST" action="{{ route('rates.update', $rate) }}">
                        <input type="hidden" name="_method" value="PUT"/>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-group{{ $errors->rateError->has('name') ? ' has-error' : '' }}">
                            <div class="col-sm-12">
                                <input type="hidden" name="id" value="{{$rate->id}}"/>
                                <select class="form-control border-correct" id="car" name="car" disabled="disabled">
                                    <option selected="selected" disabled>Seleccione un Tipo de Vehículo</option>
                                    @foreach($carTypes as $car)
                                        <option value="{{ $car->id }}" {{ ($rate->car_classification_id == $car->id) ? "selected" : "" }}>{{ $car->description }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->rateError->has('car_classification_id'))
                                    <p class="colorRedFont">
                                        {{ $errors->rateError->first('car_classification_id') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="hidden" name="from" id="from" value="{{ $rate->valid_from }}">
                                <input type="hidden" name="to" id="to" value="{{ $rate->valid_to }}">
                                <input class="form-rate" type="text" id="daterange" name="daterange"  disabled="disabled" value="{{ date("d-m-Y", strtotime($rate->valid_from)) }} - {{ date("d-m-Y", strtotime($rate->valid_to)) }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="row">
                                    <input type="hidden" id="min" name="min" value="{{$rate->days_from}}">
                                    <input type="hidden" id="max" name="max" value="{{$rate->days_to}}">
                                    <div class="col-md-1">
                                        <label class="slider-legend slider-legend-left-update" id="label-min">{{$rate->days_from}}d</label>
                                    </div>
                                    <div class="col-md-9 slider-update">
                                        <input id="slider-uppyx" type="text" data-slider-min="1" data-slider-max="21"
                                               data-slider-step="1" data-slider-value="[{{$rate->days_from}},{{$rate->days_to}}]" data-slider-tooltip="always" data-slider-enabled="false"/>
                                    </div>
                                    <div class="col-md-1">
                                        <label class="slider-legend slider-legend-right-update" id="label-max">{{$rate->days_to}}d</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="number" class="form-control form-rate" id="amount" name="amount" placeholder="Costo" value="{{$rate->amount}}" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <select class="form-control border-correct" id="country_id" name="country_id" disabled="disabled">
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ ($rate->country_id == $country->id) ? "selected" : "" }}>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->rateError->has('country_id'))
                                    <p class="colorRedFont">
                                        {{ $errors->rateError->first('country_id') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <select class="form-control border-correct" id="city_id" name="city_id">
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ ($rate->city_id == $city->id) ? "selected" : "" }}>{{ $city->name }}</option>
                                    @endforeach
                                    <option value="0" {{ ($rate->country_id == null) ? "selected" : "" }}>Todas las Ciudades</option>
                                </select>
                                @if ($errors->rateError->has('city_id'))
                                    <p class="colorRedFont">
                                        {{ $errors->rateError->first('city_id') }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group text-center">
                            <div class="col-md-6 col-md-offset-3">
                                <button class="btnSend" type="submit">
                                    <img src="{{ asset('images/send-uPPyx.png') }}" alt="uPPyx">
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts-extras')
    @include('layouts.partials.scriptalert')

    <script type="text/javascript">
        var country;

        $(document).ready(function () {
            country = $('#country_id').val();
            getCity(country);

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
                val = element.value;
//                console.log(val);

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

            $(function() {
                $('input[name="daterange"]').daterangepicker({
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
                    $.each(data, function(index, value){
                        $('#city_id').append('<option value="'+value.id+'">'+value.name+'</option>');
                    });
                    $('#city_id').append('<option value="0">Todas las Ciudades</option>');
                });
            }

            /*
             *Función para controlar los selectores de rango de días.
             */
            var minB = document.getElementById('min'),
                maxB = document.getElementById('max');

            function setLimits(limit, opts, lower, upper) {
                for (var i = 0; i < limit; ++i) {
                    opts[i].disabled = lower;
                }
                for (var i = limit; i < opts.length; ++i) {
                    opts[i].disabled = upper;
                }
            }

            function setLowerLimit(limit, elem) {
                var opts = elem.getElementsByTagName('option');
                setLimits(limit, opts, 'disabled', false);
            }

            function setUpperLimit(limit, elem) {
                var opts = elem.getElementsByTagName('option');
                setLimits(limit+1, opts, false, 'disabled');
            }

            // TODO: modern method (addEventListener/attachEvent, wrapped in a convenience function to make it work across browsers....

            minB.onchange = function() {
                setLowerLimit(minB.selectedIndex, maxB);
            };
            maxB.onchange = function() {
                setUpperLimit(maxB.selectedIndex, minB);
            };
        })
    </script>
@endsection