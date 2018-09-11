@extends('layouts.auth')

@section('content')
    <div class="container-fluid container-login">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-login">
                <div class="panel-body">
                    {{ csrf_field() }}
                    <div class="form-group text-center logo-group">
                        <img src="{{ asset('images/logo.png') }}" alt="uPPyx" class="img-responsive">
                    </div>
                    <div class="row text-center">
                        @if (session('error'))
                            <p class="colorRedFont font-light text-center">
                                {{ session('error') }}
                            </p>
                        @elseif(session('success'))
                            @php
                                $split = explode('.', session('success'))
                            @endphp
                            <h2 class="message">{{ $split[0] }}</h2>
                            <h3 class="message">{{ $split[1] }}</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection