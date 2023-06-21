@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
          </div>
        </div>
    </div>
</section>


<!-- CREACION  -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
              <div class="card-header border-1">
                <h4 class="card-title">Cambiar Clave</h4>
                <div class="card-tools">
                  <a href="{{ route('home') }}" class="btn btn-tool btn-sm">
                    <i class="fas fa-arrow-left"></i> Volver
                  </a>
                </div>
              </div>
              <div class="card-body">
                <!-- inicio -->
                        <form class="form-horizontal" method="POST" action="{{ route('changePassword') }}">
                            {{ csrf_field() }}



                            <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                <label for="new-password" class="col-md-4 control-label">Contraseña Actual</label>

                                <div class="col-md-6 input-group" id="show_hide_password">
                                    <input id="current-password" type="password" data-toggle="password" class="form-control" name="current-password" required>
                                    <div class="input-group-append">
                                            <span class="input-group-text">
                                              <i class="fa fa-eye"></i>
                                            </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                                <label for="new-password" class="col-md-4 control-label">Nueva Contraseña</label>

                                <div class="col-md-6 input-group" id="show_hide_password">
                                    <input id="new-password" type="password" data-toggle="password" class="form-control" name="new-password" required>
                                    <div class="input-group-append">
                                            <span class="input-group-text">
                                              <i class="fa fa-eye"></i>
                                            </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="new-password-confirm" class="col-md-4 control-label">Confirmar Contraseña</label>

                                <div class="col-md-6 input-group" id="show_hide_password">
                                    <input id="new-password-confirm" type="password" data-toggle="password" class="form-control" name="new-password-confirm" required>

                                    <div class="input-group-append">
                                            <span class="input-group-text">
                                              <i class="fa fa-eye"></i>
                                            </span>
                                    </div>
                                </div>
                            </div>



                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        Cambiar Clave
                                    </button>
                                </div>
                            </div>
                        </form>

              </div>
            </div>
        </div>
    </div>
</div>
@endsection