@extends('layouts.auth')

<!-- Main Content -->
@section('content')
<div class="container-fluid container-login">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-login">
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                    {{ csrf_field() }}
                    <div class="form-group text-center logo-group">
                        <a href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" alt="uPPyx" class="img-responsive"></a>
                    </div>
                    @if (session('success'))
                        <p class="padding-top-msj msj-success text-center"><i class="fa fa-check-circle msj-success" aria-hidden="true"></i> {{ Session::get('success') }}</p>
                    @endif
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <div class="col-md-offset-3 col-md-6">
                            {{Form::email('email', old('email'), array('class' => 'form-control input-login', 'id' => 'email', 'placeholder' => 'Email'))}}
                            @if ($errors->has('email'))
                                <p class="colorRedFont font-light text-center">
                                    {{ $errors->first('email') }}
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="row text-center">
                        @if (session('error'))
                            <p class="colorRedFont font-light text-center">
                                {{ session('error') }}
                            </p>
                        @endif
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
        <a class="btn btn-link" href="{{ url('/') }}">
            Iniciar Sesión
        </a>
    </div>
</div>
@endsection

@section('scripts-extras')
    @include('layouts.partials.scriptalert')
@endsection