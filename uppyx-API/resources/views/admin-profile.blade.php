@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="active">Actualizar datos del perfil</li>
        </ol>
        @if (session('status'))
            <p class="padding-top-msj msj-{{ Session::get('message_type') }}"><i class="fa fa-check-circle msj-{{ Session::get('message_type') }}" aria-hidden="true"></i> {{ Session::get('status') }}</p>
        @endif
        <div class="panel">
            <div class="panel-body">
                <form enctype="multipart/form-data" action="{{ url('/user-profile') }}" method="POST">
                    <input type="hidden" name="id" value="{{$user->id}}" />
                    <h2 class="text-center profile-text">Perfil de {{ $user->name }}</h2>
                    <div class="col-md-6 col-md-offset-3 text-center">
                        @if (isset(Auth::user()->profile_picture))
                            <a href="{{ route('user-profile.destroy', [$user->id, $user->profile_picture]) }}" onclick="return confirm('¿Está seguro que desea eliminar esta Imagen?')"
                                            class="fa fa-times-circle delete-image"></a>
                            @php
                                $url = Storage::disk('s3')->url('userProfile/' . Auth::user()->profile_picture);
                            @endphp
                            <img src="{{ $url }}" id="profile-image" class="profile-img" alt="User Image" style="cursor: pointer;">
                        @else
                            <img src="{{ asset('images/default-300x300.png') }}" class="profile-img" id="profile-image" alt="User Image" style="cursor: pointer;">
                        @endif

                        <div style="display: none;"><input class="input-profile profile-noborder choose-file" type="file" name="picture"></div>
                        @if ($errors->image->has('picture'))
                            <p class="colorRedFont">
                                {{ $errors->image->first('picture') }}
                            </p>
                        @endif
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <input name="email" value="{{$user->email}}" type="text" disabled="disabled" class="form-control input-profile" placeholder="Email">
                        @if ($errors->profile->has('email'))
                            <p class="colorRedFont">
                                {{ $errors->profile->first('email') }}
                            </p>
                        @endif
                        <input name="password" value="" type="password" maxlength="20" class="form-control input-profile" placeholder="Contraseña" autocomplete="off">
                        @if ($errors->profile->has('password'))
                            <p class="colorRedFont font-light text-center">
                                {{ $errors->profile->first('password') }}
                            </p>
                        @endif
                        <input name="password_confirmation" value="" type="password" maxlength="20" class="form-control input-profile" placeholder="Confirmar Contraseña" autocomplete="off">
                        @if ($errors->profile->has('password_confirmation'))
                            <p class="colorRedFont font-light text-center">
                                {{ $errors->profile->first('password_confirmation') }}
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
@endsection

@section('scripts-extras')
    <script>
        $(document).ready(function(){
                $(".delete-image" ).on( "click", function() {
//                    console.log("eliminar imagen");
                });

                $(".profile-img" ).on( "click", function() {
                    //profile-img
                    $('.choose-file').trigger('click');
                });



            $(".choose-file").change(function () {
                readURL(this);
            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('.profile-img').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
        });
    </script>
    @include('layouts.partials.scriptalert')
@endsection