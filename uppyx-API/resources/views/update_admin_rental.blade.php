@extends('layouts.app')

@section('content')
  <div class="container">
    <ol class="breadcrumb">
        <!--li><a href="{{ url('/') }}">Inicio</a></li-->
        <li><a href="{{ url('/list-admin-rental') }}">Listar car rental</a></li>
        <li><a href="{{ url('/register-rent-car') }}">Registrar car rental</a><li>
        <li class="active">Actualizar Car Rental</li>
    </ol>

    @if (session('status'))
      <p class="padding-top-msj msj-{{ Session::get('message_type') }}"><i class="fa fa-check-circle
      msj-{{ Session::get('message_type') }}" aria-hidden="true"></i> {{ Session::get('status') }}</p>
    @endif

    <div class="panel">
      <div class="panel-body">
          <div class="form-group col-md-offset-3 col-md-6">
            <form class="form-horizontal" method="POST" action="{{ url('/updated_admin_rental') }}">
            {{ csrf_field() }}
              <div class="form-group{{ $errors->rental->has('name') ? ' has-error' : '' }}">
                <div class="col-md-12">
                  <input type="hidden" name="id" value="{{$agency->id}}" />
                  <input name="name" type="text" class="form-control" placeholder="Nombre del Car Rental"
                         value="{{$agency->name}}" maxlength="40">
                  @if ($errors->rental->has('name'))
                    <p class="colorRedFont">
                      {{ $errors->rental->first('name') }}
                    </p>
                  @endif
                </div>
              </div>
              <div class="form-group{{ $errors->rental->has('address') ? ' has-error' : '' }}">
                <div class="col-md-12">
                  <input name="address" nametype="text" class="form-control" maxlength="100" placeholder="Dirección"
                         value="{{$agency->address}}">
                  @if ($errors->rental->has('address'))
                    <p class="colorRedFont">
                      {{ $errors->rental->first('address') }}
                    </p>
                  @endif
                </div>
              </div>
              <div class="form-group{{ $errors->rental->has('phone') ? ' has-error' : '' }}">
                <div class="col-md-12">
                  <input name="phone" type="text" class="form-control form-control-danger"
                         onkeypress='return event.keyCode == 43 || event.keyCode == 45 || event.keyCode == 8
                         || ( event.charCode >= 48 && event.charCode <= 57)'
                         placeholder="Teléfono" value="{{$agency->phone}}" maxlength="14">
                  @if ($errors->rental->has('phone'))
                    <p class="colorRedFont">
                        {{ $errors->rental->first('phone') }}
                    </p>
                  @endif
                </div>
              </div>
              <div class="form-group{{ $errors->rental->has('description') ? ' has-error' : '' }}">
                <div class="col-md-12">
                  <textarea class="form-control" rows="4" name="description" type="text" maxlength="255"
                            placeholder="Descripción">{{$agency->description}}</textarea>
                  @if ($errors->rental->has('description'))
                    <p class="colorRedFont">
                      {{ $errors->rental->first('description') }}
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
@endsection