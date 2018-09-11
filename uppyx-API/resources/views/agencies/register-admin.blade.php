@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="{{ url('/list-user-rental') }}">Listar usuarios</a></li>
            <li class="active">Registrar usuario</li>
        </ol>

        @if (session('status'))
            <p class="padding-top-msj msj-{{ Session::get('message_type') }}"><i class="fa fa-check-circle msj-{{ Session::get('message_type') }}" aria-hidden="true"></i> {{ Session::get('status') }}</p>
        @endif

        <div class="panel">
            <div class="panel-body">
                <div class="form-group col-md-offset-3 col-md-6">
                    <form class="form-horizontal" method="POST" action="{{ url('/register-rental-admin') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="checkValue" id="checkValue" value="{{old('checkValue')}}"/>
                        <div class="form-group form-choice">
                            <h3 class="pull-left font-bold customer-title customer-title-left">Desea registrar un:</h3>
                            <div class="col-md-12 radio radio-primary">
                                <label for="roleOption1" class="radio-inline radio-uppyx">
                                    <input type="radio" name="roleOption" id="roleOption1" value="1"> Admin uPPyx
                                </label>
                                <label for="roleOption2" class="radio-inline radio-uppyx radio-uppyx-left">
                                    <input type="radio" name="roleOption" id="roleOption2" value="2" checked="checked"> Gerente
                                </label>
                            </div>
                        </div>                        
                        <div class="form-group{{ $errors->rental->has('name') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input id="name" name="name" value="{{old('name')}}" type="text" class="form-control"
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
                                <input name="email" value="{{old('email')}}" nametype="text" class="form-control" placeholder="Email">
                                @if ($errors->rental->has('email'))
                                    <p class="colorRedFont">
                                        {{ $errors->rental->first('email') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->rental->has('phone') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input name="phone" id='PhoneNumber' value="{{old('phone')}}" type="text" class="form-control"
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
                                <input name="address" value="{{old('address')}}" type="text" class="form-control" maxlength="100" placeholder="Dirección">
                                @if ($errors->rental->has('address'))
                                    <p class="colorRedFont">
                                        {{ $errors->rental->first('address') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <select class="form-control border-correct" id="agency_id" name="agency_id">
                                    <option value="0" selected="selected" disabled>Seleccionar agencia</option>
                                    @foreach($agency as $agencies)
                                        <option value="{{$agencies->id}}">{{$agencies->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->rental->has('agency_id'))
                                    <p class="colorRedFont msg-agency">
                                        {{ $errors->rental->first('agency_id') }}
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

    <script>
        $(document).ready(function () {

            //Prevenir pegar en el input name
            $('#name').bind("cut copy paste",function(e) {
                e.preventDefault();
            });

            if($("#checkValue").val()==1){
                $('#roleOption1').iCheck('check');
                $('#agency_id').hide();
            }else if($("#checkValue").val()==2){
                $('#roleOption2').iCheck('check');
            }else{
                $('#roleOption2').iCheck('check');
            }

            $('#roleOption1').on('ifChecked', function () {
                $('#agency_id').hide();
                $('.msg-agency').hide();
                $('#checkValue').val($(this).val());
                $('#agency_id option').prop('selected', function() {
                    return this.defaultSelected;
                });
            });

            $('#roleOption2').on('ifChecked', function () {
                $('#agency_id').show();
                $('#checkValue').val($(this).val());
            });

            $('input[type=radio][name=roleOption]').iCheck({
                checkboxClass: 'icheckbox_square-grey',
                radioClass: 'iradio_square-grey'
            });
        });
    </script>
@endsection