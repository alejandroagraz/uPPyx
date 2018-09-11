@extends('layouts.app')

@section('content')
    <div class="container">
        <input type="hidden" value="{{url('city-configurations')}}" id="url-configurations">
        <ol class="breadcrumb">
            <li><a href="{{ route('configurations.index') }}">Listar configuraciones</a></li>
            <li class="active">Registrar nueva configuración<li>
        </ol>

        @if (session('status'))
            <p class="padding-top-msj msj-{{ Session::get('message_type') }}"><i class="fa fa-check-circle msj-{{ Session::get('message_type') }}" aria-hidden="true"></i> {{ Session::get('status') }}</p>
        @endif

        <!-- panel add -->
        <div class="panel-body-custom">
            <div class="panel panel-default panel-rates panel-rates-left col-md-11">
                <div class="form-horizontal">
                    <div class="form-group">
                        <div class="col-md-4 col-md-4-custom">
                            <select class="form-control select-custom select-custom-left" id="type" name="type">
                                <option selected="selected" disabled>Tipo de configuración</option>
                                @if(count($configTypes)>0)
                                    @foreach($configTypes as $type)
                                        <option value="{{$type->type}}">{{$type->type}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-4 col-md-4-custom">
                            <select class="form-control select-custom select-custom-center" id="country_id" name="country_id">
                                <option selected="selected" disabled>País</option>
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 col-md-4-custom">
                            <select class="form-control select-custom select-custom-right" id="city_id" name="city_id">
                                <option selected="selected" disabled>Ciudad</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group form-adjust">
                        <div class="col-md-2">
                            <input id="alias" name="alias" type="text" class="form-control form-config input-custom input-custom-safari"
                                   onkeypress='return event.keyCode == 95 || event.keyCode == 8
                                   || ( event.charCode >= 48 && event.charCode <= 57)
                                   || ( event.charCode >= 97 && event.charCode <= 122)'
                                   placeholder="Alias" maxlength="100">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control form-config input-custom input-custom-safari"
                                   id="name" name="name" placeholder="Descripción (ES)" maxlength="100" autocomplete="off">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control form-config input-custom input-custom-safari"
                                   id="name_en" name="name_en" placeholder="Descripción (EN)" maxlength="100" autocomplete="off">
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control form-config input-custom input-custom-safari"
                                   id="value" name="value" placeholder="Valor" autocomplete="off">
                        </div>
                        <div class="col-md-2">
                            <select class="form-control select-custom select-custom-unit" id="unit_id" name="unit_id">
                                <option selected="selected" disabled>Unidad</option>
                                <option value="$">Dolares</option>
                                <option value="%">Porcentaje</option>
                                <option value="d">Dias</option>
                                <option value="min">Minutos</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body-custom">
            <div class="panel panel-default panel-rates panel-config-right panel-edge col-md-1">
                <div class="form-horizontal">
                    <div class="form-group">
                        <div class="text-center">
                            <a href="#" class="preview-add-button"><i class="btn-circle btn-circle-safari fa fa-plus-circle"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- panel preview -->
        <div class="panel-table-custom col-md-12">
            <form class="form-horizontal" id="form-preview" method="POST" action="{{ route('configurations.store') }}">
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

            //Prevenir negativos y permitir , o .
            $('#value').keypress(function (event) {
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
//                    console.log(val);

                if (!valid) {
//                    console.log("Error");
                    element.value = val.substring(0, val.length - 1);
                    return false;
                }
                else{
                    return true;
                }
            }

            $("#value").focusout(function(){
                //"" + parseFloat(this.value)
                $("#value").val(this.value.replace(/^0+/, 0));
            });

            //Prevenir pegar en el input valor
            $('#value').bind("cut copy paste",function(e) {
                e.preventDefault();
            });

            //Prevenir pegar en el input alias
            $('#alias').bind("cut copy paste",function(e) {
                e.preventDefault();
            });

            //Validar que la tabla no esté vacía
            $(function(){
                $('#form-preview').submit(function() {
                    var rows = $('table#preview-table').find('tbody').find('tr').length;
                    if (rows == 0) {
                        alert("Debe ingresar al menos una configuración");
                        return false;
                    };
                });
            });

            //Al hacer clic en Agregar
            $(function(){
                $(".preview-add-button").click(function(){

                    var type = $('#type').val();
                    if(type == null){
                        alert("Todos los campos son obligatorios");
                        return false;
                    }

                    if($('#country_id').val() == null){
                        alert("Todos los campos son obligatorios");
                        return false;
                    }

                    if($('#city_id').val() == null){
                        alert("Todos los campos son obligatorios");
                        return false;
                    }

                    var alias = $('#alias').val();
                    if(alias == ""){
                        alert("Todos los campos son obligatorios");
                        return false;
                    }

                    var name = $('#name').val();
                    if(name == ""){
                        alert("Todos los campos son obligatorios");
                        return false;
                    }

                    var value = $('#value').val();
                    if(value == "" || value == 0){
                        alert("Todos los campos son obligatorios");
                        return false;
                    }

                    if($('#unit_id').val() == null){
                        alert("Todos los campos son obligatorios");
                        return false;
                    }

                    //Validar que no exista ya en la tabla de preview;
                    var newClass = $('#alias').val()+'-'+$('#country_id').val()+'-'+$('#city_id').val();
                    if($('.'+newClass).length > 0){
                        alert("Ya está registrada esa configuración");
                        return false;
                    }

                    else {
                        val = '<tr class="'+newClass+'">';
                        val += '<td class="col-sm-1 text-center table-rates">' + $('#type option:selected').text() + '<input type="hidden" name="type[]" value="' + $('#type').val() + '"/></td>';
                        val += '<td class="col-sm-2 text-center table-rates">' + $('#country_id option:selected').text() + '<input type="hidden" name="country_id[]" value="' + $('#country_id').val() + '"/></td>';
                        val += '<td class="col-sm-2 text-center table-rates">' + $('#city_id option:selected').text() + '<input type="hidden" name="city_id[]" value="' + $('#city_id').val() + '"/></td>';
                        val += '<td class="col-sm-1 table-rates">' + $('#alias').val() + '<input type="hidden" name="alias[]" value="' + $('#alias').val() + '"/></td>';
                        val += '<td class="col-sm-2 table-rates">' + $('#name').val() + '<input type="hidden" name="name[]" value="' + $('#name').val() + '"/></td>';
                        val += '<td class="col-sm-2 table-rates">' + $('#name_en').val() + '<input type="hidden" name="name_en[]" value="' + $('#name_en').val() + '"/></td>';
                        if($('#unit_id').val() == '$') {
                            val += '<td class="col-sm-1 text-center table-rates">'+ $('#unit_id').val() + $('#value').val() +
                                '<input type="hidden" name="unit_id[]" value="' + $('#unit_id').val() + '"/>'+'<input type="hidden" name="value[]" value="' + $('#value').val() + '"/></td>';
                        }else{
                            val += '<td class="col-sm-1 text-center table-rates">'+ $('#value').val() + $('#unit_id').val() +
                                '<input type="hidden" name="unit_id[]" value="' + $('#unit_id').val() + '"/>'+'<input type="hidden" name="value[]" value="' + $('#value').val() + '"/></td>';
                        }
                        val += '<td class="col-sm-3 text-center table-rates"> <span class="fa fa-minus-circle input-remove-row"></span></td>';
                        val += '</tr>';
                        $('.preview-table').append(val);
                        $('.form-config').val('');
                        $('.alias').attr('placeholder', 'Alias');
                        $('.name').attr('placeholder', 'Descripción (ES)');
                        $('.name_en').attr('placeholder', 'Descripción (EN)');
                        $('.value').attr('placeholder', 'Valor');
                    }
                });
            });

            $(document).on('click', '.input-remove-row', function(){
                var tr = $(this).closest('tr');
                tr.fadeOut(200, function(){
                    tr.remove();
                });
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
                });
            }
        })
    </script>
    @include('layouts.partials.scriptalert')
@endsection