@extends('layouts.app')

@section('content')
    <div class="container">
        <input type="hidden" value="{{url('city-configurations')}}" id="url-configurations">
        <ol class="breadcrumb">
            <li><a href="{{ route('charges.index') }}">Listar cargos</a></li>
            <li><a href="{{ route('charges.create') }}">Registrar nuevo cargo</a><li>
            <li class="active">Actualizar Configuración</li>
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
                    <form class="form-horizontal" method="POST" action="{{ route('charges.update', $charge) }}">
                        <input type="hidden" name="_method" value="PUT"/>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                        <input type="hidden" name="id" value="{{$charge->id}}">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <select class="form-control" id="configuration_id" name="configuration_id">
                                    @foreach($configTypes as $cargo)
                                        <option value="{{ $cargo->id }}" {{ ($charge->configuration_id == $cargo->id) ? "selected" : "" }}>{{ $cargo->name }}</option>
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
                                <select class="form-control" id="car_classification" name="car_classification">
                                    @foreach($carClassification as $car)
                                        <option value="{{ $car->id }}" {{ ($car->id == $charge->car_classification_id) ? "selected" : "" }}>{{ $car->description }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->config->has('country_id'))
                                    <p class="colorRedFont">
                                        {{ $errors->config->first('country_id') }}
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
        var table_data = [];
        var country;

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
        })
    </script>
@endsection