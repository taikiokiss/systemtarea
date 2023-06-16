@extends('layouts.login')

@section('content')
  <main>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6 login-section-wrapper">
          <div class="login-wrapper my-auto">
          <div class="brand-wrapper text-center">
            <img src="/assets1/images/logo.png" alt="logo" class="logo" style="height: 100px;">
            <!--h1 class="login-title">TAREAS</h1-->
          </div>
            <br><br>
            <h1 class="login-title">Iniciar Sesión</h1>

            <form method="POST" action="{{ route('login') }}">
              @csrf
              <div class="form-group">
                <label for="email">Correo Electrónico o Cédula</label>
                  
                  <input id="login" type="text" class="form-control {{$errors->has('email') || $errors->has('cedula') ? 'is-invalid ': ''}}" name="login" value="{{ old('email') ?: old('cedula') }}" required autofocus placeholder="correo@ejemplo.com">

                  @if ($errors->has('email') || $errors->has('cedula'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('email') ?: $errors->first('cedula') }}</strong>
                      </span>
                  @endif
              </div>
              <div class="form-group">
                <label for="password">Contraseña</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                  @error('password')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>

              <div class="form-group">
                <div class="row">
                  <div class="col-12">                    
                    <button type="submit" class="btn btn-block back-btn">
                        {{ __('Ingresar') }}
                    </button>
                  </div>
                </div>
              </div>

            </form>
          </div>
          

        </div>
        <div class="col-sm-6 px-0 d-none d-sm-block">
          <img src="/assets1/images/login.jpg" alt="login image" style="width: 100%;" class="login-img">
        </div>

      </div>
    </div>
  </main>       
@endsection
