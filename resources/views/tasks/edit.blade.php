@extends('admin.admin2')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h4 style="display:inline;">Modificar Antena</h4>
                <a href="{{ route('antenas.index') }}" class="btn btn-sm btn-outline-danger float-right">
                    <i class="fas fa-chevron-left"></i> Regresar
                </a> 
          </div>
        </div>
    </div>
</section>


<!-- CREACION  -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
              <div class="card-body">
                <!-- inicio -->
                    {!! Form::model($antenas, ['route' => ['antenas.update', $antenas->id],
                    'method' => 'PUT','enctype' =>'multipart/form-data', 'files'=>true]) !!}

                        @include('antenas.partials.form')
                        
                    {!! Form::close() !!}
              </div>
            </div>
        </div>
    </div>
</div>
@endsection