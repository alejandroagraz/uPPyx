@extends('layouts.auth')

<!-- Main Content -->
@section('content')
<div class="container-fluid container-login">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-login">
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                    {{ csrf_field() }}

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group text-center logo-group">
                        <a href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" alt="uPPyx" class="img-responsive"></a>
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <div class="col-md-offset-3 col-md-6">
                            {{Form::email('email', $email or old('email'), array('class' => 'form-control input-login', 'id' => 'email', 'placeholder' => 'Email'))}}
                            @if ($errors->has('email'))
                                <p class="colorRedFont font-light text-center">
                                    {{ $errors->first('email') }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <div class="col-md-offset-3 col-md-6">
                            {{Form::password('password', array('class' => 'form-control input-login', 'id' => 'password', 'placeholder' => 'Contraseña'))}}
                            @if ($errors->has('password'))
                                <p class="colorRedFont font-light text-center">
                                    {{ $errors->first('password') }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <div class="col-md-offset-3 col-md-6">
                            {{Form::password('password_confirmation', array('class' => 'form-control input-login', 'id' => 'password-confirm', 'placeholder' => 'Confirmar Contraseña'))}}
                            @if ($errors->has('password_confirmation'))
                                <p class="colorRedFont font-light text-center">
                                    {{ $errors->first('password_confirmation') }}
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