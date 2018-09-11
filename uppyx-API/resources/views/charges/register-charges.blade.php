@extends('layouts.app')

@section('content')
    <div class="container">
        <input type="hidden" value="{{url('city-configurations')}}" id="url-configurations">
        <input type="hidden" value="{{url('charge-list')}}" id="url-charges">
        <ol class="breadcrumb">
            <li><a href="{{ url('/list-charges') }}">Listar cargos</a></li>
            <li class="active">Registrar nuevo cargo<li>
        </ol>

    @if (session('status'))
        <p class="padding-top-msj msj-{{ Session::get('message_type') }}"><i class="fa fa-check-circle msj-{{ Session::get('message_type') }}" aria-hidden="true"></i> {{ Session::get('status') }}</p>
    @endif

        <!-- panel add -->
        <div class="panel-body-custom">
            <div class="panel panel-default panel-rates panel-rates-left col-md-11">
                <div class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="col-md-2 col-md-2-custom-charge">
                            <select class="form-control select-custom select-custom-left-charge" id="country_id" name="country_id">
                                <option selected="selected" disabled>País</option>
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 col-md-2-custom-charge">
                            <select class="form-control select-custom select-custom-center-charge" id="city_id" name="city_id">
                                <option selected="selected" disabled>Ciudad</option>
                            </select>
                        </div>
                        <div class="col-md-3 col-md-4-custom-charge">
                            <select class="form-control select-custom select-custom-center-charge" id="car_classification" name="car_classification">
                                <option selected="selected" disabled>Clasificación de vehículo</option>
                                @foreach($carClassification as $cars)
                                    <option value="{{$cars->id}}">{{$cars->description}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 col-md-4-custom-charge">
                            <select class="form-control select-custom select-custom-right-charge" id="charge" name="charge">
                                <option selected="selected" disabled>Tipo de cargo</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body-custom">
            <div class="panel panel-default panel-rates panel-rates-right panel-charge col-md-1 col-md-1-custom-charge">
                <div class="form-horizontal">
                    <div class="form-group">
                        <div class="text-center">
                            <a href="#" class="preview-add-button"><i class="btn-circle btn-charge fa fa-plus-circle"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- panel preview -->
        <div class="panel-table-custom col-md-12">
            <form class="form-horizontal" id="form-preview" method="POST" action="{{ url('/store-charges') }}">
                <div class="row">
                    <div class="col-md-12 padding-custom">
                        <div class="table-responsive">
                            <table class="table preview-table" id="preview-table">
                                <thead>
                                <tr>
                                </tr>
                                </thead>
                                <tbody></tbody> <!-- preview content goes here-->
                            </table>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center">
                    <div class="col-md-6 col-md-offset-3">
                        <button class="btnSend" type="submit">
                            <img class="btnSend70" src="{{ asset('images/send-uPPyx.png') }}" alt="uPPyx">
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts-extras')

<script type="text/javascript">
    var country;

    $(document).ready(function () {
        country = $('#country_id').val();

        $('.preview-add-button').click(function(){

            var car = $('#car_classification').val();
            if(car == null){
                alert("Por favor indique una clasificación de vehículo");
                return false;
            }
            var charge = $('#charge').val();
            if(charge == null){
                alert("Por favor indique un cargo a aplicar");
                return false;
            }

            var newClass = $('#city_id').val()+'-'+$('#car_classification').val()+'-'+$('#charge').val();
            if($('.'+newClass).length > 0){
                alert("Ya está registrado este cargo para esa clasificación");
                return false;
            }
            val = '<tr class="'+newClass+'">';
            val += '<td class="col-sm-3 text-left padding-adjust-left table-rates">'+$('#country_id option:selected').text()+'</td>';
            val += '<td class="col-sm-2 relative-adjust table-rates">'+$('#city_id option:selected').text()+'</td>';
            val += '<td class="col-sm-3 padding-adjust-left text-left table-rates">'+$('#car_classification option:selected').text()+'<input type="hidden" name="car_classification[]" value="'+$('#car_classification').val()+'"/></td>';
            val += '<input type="hidden" name="car_name[]" value="'+$('#car_classification option:selected').text()+'"/>';
            val += '<td class="col-sm-3 padding-adjust-left text-left table-rates">'+$('#charge option:selected').text()+'<input type="hidden" name="configuration_id[]" value="'+$('#charge').val()+'"/></td>';
            val += '<input type="hidden" name="configuration_name[]" value="'+$('#charge option:selected').text()+'"/>';
            val += '<td class="col-sm-1 text-right padding-adjust-right table-rates"><span class="fa fa-minus-circle input-remove-row"></span></td>';
            val += '</tr>';
            $('.preview-table').append(val);
            $('.form-config').val('');
        });

        $(document).on('click', '.input-remove-row', function(){
            var tr = $(this).closest('tr');
            tr.fadeOut(200, function(){
                tr.remove();
            });
        });

        $('#city_id').on('change',function(e){ //Country change
            var country_id = $('#country_id').val();
            var city_id =  e.target.value;
            getCharges(country_id,city_id);
        });

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
                getCharges(country_id,data[0].id);
            });
        }

        function getCharges(countryId,cityId) {
            $.get($('#url-charges').val()+ '/' +countryId+ '/' +cityId, function(data){
                $('#charge').empty();
                $('#charge').append('<option selected="selected" disabled>Tipo de Cargo</option>');
                $.each(data, function(index, value){
                    $('#charge').append('<option value="'+value.id+'">'+value.name+'</option>');
                });
            });
        }

        $(function(){
            $('#form-preview').submit(function() {
                var rows = $('table#preview-table').find('tbody').find('tr').length;
                if (rows == 0) {
                    alert("Debe ingresar al menos un cargo");
                    return false;
                };
            });
        });
    })
</script>
@include('layouts.partials.scriptalert')
@endsection