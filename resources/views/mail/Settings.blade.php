@extends('layouts.app')
@section('title', __('CONFIGURACIÓN CORREO'))
@section('content')
<div class="container-fluid">
<div class="row justify-content-center">
   <div class="col-md-12">
      <div class="card">
         <div class="card-header"><h5><span class="text-center fa fa-envelope"></span> @yield('title')</h5></div>
         <div class="card-body">

            {!! Form::model($settings, ['route' => ['mail.settings.update'],'method' => 'PUT','enctype' =>'multipart/form-data', 'files'=>true]) !!}


               <div class="form-row">
                 <div class="form-group col-md-12">
                   <label for="from_address">Mail From</label>
                   <input type="text" class="form-control" name="from_address" id="from_address" value="{{ $settings[0]->from_address }}">
                 </div>
                 <div class="form-group col-md-12">
                   <label for="from_name">Name From</label>
                   <input type="text" class="form-control" name="from_name" id="from_name" value="{{ $settings[0]->from_name }}">
                 </div>
               </div>

               <div class="form-row">
                 <div class="form-group col-md-2">
                   <label for="mailer">Mailer</label>
                   <input type="text" class="form-control" name="mailer" id="mailer" value="{{ $settings[0]->mailer }}">
                 </div>
                 <div class="form-group col-md-6">
                   <label for="host">Host</label>
                   <input type="text" class="form-control" name="host" id="host" value="{{ $settings[0]->host }}">
                 </div>
                 <div class="form-group col-md-2">
                   <label for="encryption">Encryption</label>
                   <input  type="text" class="form-control" name="encryption" id="encryption" value="{{ $settings[0]->encryption }}">
                 </div>
                 <div class="form-group col-md-2">
                   <label for="port">Port</label>
                   <input onkeypress= "return soloNumeros(event);" maxlength="4" type="text" class="form-control" id="port" name="port" value="{{ $settings[0]->port }}">
                 </div>
               </div>


               <div class="form-row">
                 <div class="form-group col-md-12">
                   <label for="Username">Username</label>
                   <input type="text" class="form-control" name="Username" id="Username" value="{{ $settings[0]->username }}">
                 </div>
                 <div class="form-group col-md-12">
                   <label for="password">Password</label>
                   <input type="text" class="form-control" name="password" id="password" value="{{ $settings[0]->password }}">
                 </div>
               </div>


                <div class="form-group row mt-3">
                    <div class="col-md-12 col-md-offset-4 text-md-left">
                        <button type="submit" class="btn btn-primary btn-block" value="Actualizar">
                            Actualizar
                        </button>
                    </div>
                </div>

               {!! Form::close() !!}
         </div>
      </div>
   </div>
</div>
</div>


<script type="text/javascript">

        function soloNumeros(e)
        {
            
        var keynum = window.event ? window.event.keyCode : e.which;
        if ((keynum == 8) || (keynum == 46))
        return true;
        return /\d/.test(String.fromCharCode(keynum));
        }
</script>

@endsection
