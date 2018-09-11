@extends('layouts.app')

@section('content')
    <div class="container">
        <input type="hidden" value="{{url('city-configurations')}}" id="url-configurations">
        <ol class="breadcrumb">
            <li><a href="{{ route('configurations.index') }}">Listar configuraciones</a></li>
            <li><a href="{{ route('configurations.create') }}">Registrar nueva configuración</a><li>
            <li class="active">Actualizar Configuración</li>
        </ol>

        @if (session('status'))
            <p class="padding-top-msj msj-{{ Session::get('message_type') }}">
                <i class="fa fa-check-circle msj-{{ Session::get('message_type') }}" aria-hidden="true"></i>
                {{ Session::get('status') }}
            </p>
        @endif

        @if ($errors->has('exist'))
            <p class="colorRedFont">
                {{ $errors->exists->first() }}
            </p>
        @endif        

        <div class="panel">
            <div class="panel-body">
                <div class="form-group col-md-offset-3 col-md-6">
                    <form class="form-horizontal" method="POST" action="{{ route('configurations.update', $cfg) }}">
                        <input type="hidden" name="_method" value="PUT"/>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-group{{ $errors->config->has('alias') ? ' has-error' : '' }}">
                            <div class="col-sm-12">
                                <input name="alias" name="alias" type="text" class="form-control" value="{{$cfg->alias}}"
                                       onkeypress='return event.keyCode == 95 || ( event.charCode >= 48 && event.charCode <= 57)
                                                 || ( event.charCode >= 97 && event.charCode <= 122)'
                                       placeholder="Alias" maxlength="100" readonly="readonly">
                                @if ($errors->config->has('alias'))
                                    <p class="colorRedFont">
                                        {{ $errors->config->first('alias') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->config->has('name') ? ' has-error' : '' }}">
                            <div class="col-sm-12">
                                <input type="hidden" name="id" value="{{$cfg->id}}"/>
                                <input type="text" class="form-control form-config" value="{{$cfg->name}}"
                                       id="name" name="name" placeholder="Descripción" maxlength="100" autocomplete="off">
                                @if ($errors->config->has('name'))
                                    <p class="colorRedFont">
                                        {{ $errors->config->first('name') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->config->has('name_en') ? ' has-error' : '' }}">
                            <div class="col-sm-12">
                                <input type="text" class="form-control form-config" value="{{$cfg->name_en}}"
                                       id="name_en" name="name_en" placeholder="Descripción (English)" maxlength="100" autocomplete="off">
                                @if ($errors->config->has('name_en'))
                                    <p class="colorRedFont">
                                        {{ $errors->config->first('name_en') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->config->has('value') ? ' has-error' : '' }}">
                            <div class="col-sm-12">
                                <input type="text" class="form-control form-config" value="{{$cfg->value}}"
                                       id="value" name="value" placeholder="Valor" autocomplete="off">
                                @if ($errors->config->has('value'))
                                    <p class="colorRedFont">
                                        {{ $errors->config->first('value') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <select class="form-control border-correct" id="country_id" name="country_id" disabled="disabled">
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ ($cfg->country_id == $country->id) ? "selected" : "" }}>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->config->has('country_id'))
                                    <p class="colorRedFont">
                                        {{ $errors->config->first('country_id') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <select class="form-control border-correct" id="city_id" name="city_id" disabled="disabled">
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ ($cfg->city_id == $city->id) ? "selected" : "" }}>{{ $city->name }}</option>
                                    @endforeach
                                    <option value="0" {{ ($cfg->country_id == null) ? "selected" : "" }}>Todas las Ciudades</option>
                                </select>
                                @if ($errors->config->has('city_id'))
                                    <p class="colorRedFont">
                                        {{ $errors->config->first('city_id') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <select class="form-control border-correct" id="type" name="type" disabled="disabled">
                                    @foreach($configTypes as $c)
                                        <option value="{{ $c->type }}" {{ ($cfg->type == $c->type) ? "selected" : "" }}>{{ $c->type }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->config->has('type'))
                                    <p class="colorRedFont">
                                        {{ $errors->config->first('type') }}
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
        $(document).ready(function () {
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
//                console.log(val);

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
        })
    </script>
@endsection