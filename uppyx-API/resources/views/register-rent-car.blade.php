@extends('layouts.app')

@section('content')
<div class="container">
  <ol class="breadcrumb">
      <!--li><a href="{{ url('/') }}">Inicio</a></li-->
      <li><a href="{{ url('/list-admin-rental') }}">Listar car rental</a><li>
      <li class="active">Registrar car rental</li>
  </ol>

  @if (session('status'))
    <div>
      <p class="padding-top-msj verdeShow"><i class="fa fa-check-circle verdeShow" aria-hidden="true"></i> {{ session('status') }}</p>
    </div>
  @endif

  <div class="panel">
    <div class="panel-body">
      <div class="form-group col-md-offset-3 col-md-6">
        <form class="form-horizontal" method="POST" action="{{ url('/register-rental-car') }}">
          {{ csrf_field() }}
          <div class="form-group{{ $errors->rental->has('name') ? ' has-error' : '' }}">
            <div class="col-md-12">
              <input name="name" value="{{old('name')}}" type="text" class="form-control" placeholder="Nombre del Car Rental" maxlength="40">
              @if ($errors->rental->has('name'))
                <p class="colorRedFont">
                  {{ $errors->rental->first('name') }}
                </p>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->rental->has('address') ? ' has-error' : '' }}">
            <div class="col-md-12">
              <input name="address" value="{{old('address')}}" type="text" class="form-control" maxlength="100" placeholder="Dirección">
              @if ($errors->rental->has('address'))
                <p class="colorRedFont">
                  {{ $errors->rental->first('address') }}
                </p>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->rental->has('phone') ? ' has-error' : '' }}">
            <div class="col-md-12">
              <input name="phone" value="{{old('phone')}}" type="text" class="form-control"
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
          <div class="form-group{{ $errors->rental->has('description') ? ' has-error' : '' }}">
            <div class="col-md-12 height-textarea">
              <textarea class="form-control" rows="4" name="description" maxlength="255" placeholder="Descripción">{{old('description')}}</textarea>
              @if ($errors->rental->has('description'))
                <p class="colorRedFont font-light">
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