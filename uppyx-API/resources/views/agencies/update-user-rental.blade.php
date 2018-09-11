@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <!--li><a href="{{ url('/') }}">Inicio</a></li-->
            <li><a href="{{ url('/list-user-rental') }}">Listar usuarios</a></li>
                <li><a href="{{ url('/register-rental-admin') }}">Registrar usuario</a><li>
            <li class="active">Actualizar Usuario</li>
        </ol>

        @if (session('status'))
            <p class="padding-top-msj msj-{{ Session::get('message_type') }}"><i class="fa fa-check-circle msj-{{ Session::get('message_type') }}" aria-hidden="true"></i> {{ Session::get('status') }}</p>
        @endif

        <div class="panel">
            <div class="panel-body">
                <div class="form-group col-md-offset-3 col-md-6">
                    <form class="form-horizontal" method="POST" action="{{ url('/updated-user-rental') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->rental->has('name') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input type="hidden" name="id" value="{{$user->id}}" />
                                <input type="hidden" name="roleOption" value="{{$user->roles[0]->id}}" />
                                <input id="name" name="name" value="{{$user->name}}" type="text" class="form-control"
                                       onkeypress='return event.keyCode == 8 || event.keyCode == 32 || event.keyCode == 13 || window.event.keyCode == 13
                                       || event.keyCode == 193 || event.keyCode == 201 || event.keyCode == 205
                                       || event.keyCode == 209 || event.keyCode == 211 || event.keyCode == 218
                                       || event.keyCode == 225 || event.keyCode == 233 || event.keyCode == 237
                                       || event.keyCode == 241 || event.keyCode == 243 || event.keyCode == 250
                                       || ( event.charCode >= 65 && event.charCode <= 90) || ( event.charCode >= 97 && event.charCode <= 122)'
                                       placeholder="Nombre del usuario" maxlength="40">
                                @if ($errors->rental->has('name'))
                                    <p class="colorRedFont">
                                        {{ $errors->rental->first('name') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->rental->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input name="email" value="{{$user->email}}" nametype="text" class="form-control" placeholder="Email">
                                @if ($errors->rental->has('email'))
                                    <p class="colorRedFont">
                                        {{ $errors->rental->first('email') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->rental->has('phone') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input name="phone" id='PhoneNumber' value="{{$user->phone}}" type="text" class="form-control"
                                       onkeypress='return event.keyCode == 43 || event.keyCode == 45 || event.keyCode == 8
                                       || ( event.charCode >= 48 && event.charCode <= 57)'
                                       placeholder="Teléfono" maxlength="14">
                                @if ($errors->rental->has('phone'))
                                    <p class="colorRedFont">
                                        {{ $errors->rental->first('phone') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->rental->has('address') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input name="address" value="{{$user->address}}" type="text" class="form-control" maxlength="255" placeholder="Dirección">
                                @if ($errors->rental->has('address'))
                                    <p class="colorRedFont">
                                        {{ $errors->rental->first('address') }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        @if(!empty($user->rental_agency_id))
                            <div class="form-group">
                                <div class="col-md-12">
                                    <select class="form-control border-correct" name="agency_id">
                                        @foreach($agencies as $agency)
                                            <option value="{{ $agency->id }}" {{ ($user->rental_agency_id == $agency->id) ? "selected" : "" }}>{{ $agency->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->rental->has('agency_id'))
                                        <p class="colorRedFont">
                                            {{ $errors->rental->first('agency_id') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endif
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
    <script>
        $(document).ready(function () {

            //Prevenir pegar en el input name
            $('#name').bind("cut copy paste",function(e) {
                e.preventDefault();
            });
        });
    </script>
    @include('layouts.partials.scriptalert')
@endsection