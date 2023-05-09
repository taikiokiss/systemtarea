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
                <label for="email">Correo Electrónico</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                  @error('email')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
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
                    <input name="login" id="login" class="btn btn-block back-btn" type="submit" value="Entrar">
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
