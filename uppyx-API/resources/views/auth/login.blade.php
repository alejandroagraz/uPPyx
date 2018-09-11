@extends('layouts.auth')

@section('content')
<div class="container-fluid container-login">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-login">
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/login2') }}">
                {{ csrf_field() }}
                <div class="form-group text-center logo-group">
                    <img src="{{ asset('images/logo.png') }}" alt="uPPyx" class="img-responsive">
                </div>
                    @if (session('status'))
                        <p class="colorRedFont font-light text-center">
                            {{ session('status') }}
                        </p>
                    @endif
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}
                    {{ session('status') ? ' has-error' : '' }}">
                        <div class="col-md-offset-3 col-md-6">
                            {{Form::email('email', old('email'), ['class' => 'form-control input-login', 'id' => 'email',
                             'placeholder' => 'Email', 'required' => true])}}
                            @if ($errors->has('email'))
                                <p class="colorRedFont font-light">
                                    {{ $errors->first('email') }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <div class="col-md-offset-3 col-md-6">
                            {{Form::password('password', ['class' => 'form-control input-login', 'id' => 'password',
                             'placeholder' => 'Contraseña', 'required' => true])}}
                            @if ($errors->has('password'))
                                <p class="colorRedFont font-light">
                                    {{ $errors->first('password') }}
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
    <div class="col-md-12 text-center">
        <a class="btn btn-link" href="{{ url('/password/reset') }}">
            ¿Olvidó su contraseña?
        </a>
    </div>
</div>
@endsection