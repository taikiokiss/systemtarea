@extends('layouts.login')

@section('content')
  <main>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6 login-section-wrapper">
          <div class="login-wrapper my-auto">
          <div class="brand-wrapper mb-5" style="text-align: center;">
            <img src="/assets1/images/logo.svg" alt="logo" class="logo" style="height: 100px;">
          </div>
            <h1 class="login-title">Restaurar Contraseña</h1>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
              @csrf
              <div class="form-group">
                <label for="email">Correo Electrónico</label>
                  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Ingresa tu correo electrónico">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
              </div>

              <a href="{{ url('login') }}" class="btn btn-block login-btn">Atras</a>
              
              <input name="login" id="login" class="btn btn-block back-btn" type="submit" value="Restablecer contraseña">

            </form>
          </div>

        </div>
        <div class="col-sm-6 px-0 d-none d-sm-block">
          <img src="/assets1/images/fondo1.jpg" alt="login image" style="width: 100%;" class="login-img">
        </div>
      </div>
    </div>
  </main>       
@endsection
