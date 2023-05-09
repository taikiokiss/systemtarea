@extends('layouts.login')

@section('content')
  <main>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6 login-section-wrapper">
          <div class="login-wrapper my-auto">
          <div class="brand-wrapper mb-5" style="text-align: center;">
            <img src="/assets1/images/logo-m.svg" height="100%" alt="logo" class="logo">
          </div>
            <h1 class="login-title">Restablece tu contraseña</h1>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
              @csrf

                <input type="hidden" name="token" value="{{ $token }}">


                <div class="form-group row">
                    <label for="email" class="col-md-12 col-form-label">{{ __('Correo Electrónico') }}</label>

                    <div class="col-md-12">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="Ingresa tu correo electrónico">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="password_confirm" class="col-form-label text-md-right">{{ __('Código de seguridad') }}</label>
                    </div>

                    <div class="col-md-12">
                        <input id="password_confirm" type="number" class="form-control @error('password_confirm') is-invalid @enderror" name="password_confirm" minlength="0" maxlength="999999" required autocomplete="password_confirm">

                        @if (Session::has('error'))
                            <span class="invalid-feedback" style="display: block;" role="alert">
                                <strong>{!! Session::get('error') !!}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-12 col-form-label">{{ __('Contraseña') }}</label>

                    <div class="col-md-12">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password-confirm" class="col-md-12 col-form-label">{{ __('Confirmar Contraseña') }}</label>

                    <div class="col-md-12">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-12 offset-md-12">
                        <a href="{{ url('login') }}" class="btn btn-block login-btn">Atras</a>
                        <input class="btn btn-block back-btn" type="submit" value="Restablecer Contraseña">
                    </div>
                </div>
              
            </form>
          </div>

        </div>
        <div class="col-sm-6 px-0 d-none d-sm-block">
          <img src="/assets1/images/HDC-200.jpg" alt="login image" class="login-img">
        </div>
      </div>
    </div>
  </main>       
@endsection