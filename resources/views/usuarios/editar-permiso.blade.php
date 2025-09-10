@extends('layouts.layout')

@section('title', 'SkaPeople - Permisos')

@section('content')
<!-- Titulo de pagina -->
<div class="pagetitle">
  <h1>Editar Permiso</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('/') }}">Inicio</a></li>
      <li class="breadcrumb-item"><a href="{{ route('mis-permisos') }}">Mis Permisos</a></li>

    </ol>
  </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Formulario de Permiso</h5>

          @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif

          @if (session('success'))
          <div class="alert alert-success">
            {{ session('success') }}
          </div>
          @endif

          <!-- General Form Elements -->
          <form action="{{route('editar-permiso', $permiso->id_permiso)}}" method="POST">
            @csrf
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label">Tipo Permiso</label>
              <div class="col-sm-10">
                <select name="id_tipo_permiso" class="form-select" aria-label="Default select example" required>
                  <option value="" disabled>Seleccionar</option>
                  @foreach($tiposPermiso as $tipo)
                  <option value="{{ $permiso->id_tipo_permiso }}" {{ $permiso->id_tipo_permiso == $tipo->id_tipo_permiso ? 'selected' : '' }}>
                    {{ $tipo->permiso }}
                  </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="">Regresa:</label>
              <div class="col-sm-10">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="regresa" id="gridRadios1" value="1" {{ $permiso->regresa == 1 ? 'checked' : '' }}>
                  <label class="form-check-label" for="gridRadios1">
                    Si
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="regresa" id="gridRadios2" value="0" {{ $permiso->regresa == 0 ? 'checked' : '' }}>
                  <label class="form-check-label" for="gridRadios2">
                    No
                  </label>
                </div>
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputPassword" class="col-sm-2 col-form-label">Mensaje:</label>
              <div class="col-sm-10">
                <textarea name="descripcion" class="form-control" style="height: 100px" placeholder="Opcional">{{ $permiso->descripcion }}</textarea>
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputDate" class="col-sm-2 col-form-label">Fecha Inicio</label>
              <div class="col-sm-10">
                <input type="text" id="fecha_inicio" name="fecha_inicio" class="form-control" value="{{ $permiso->fecha_inicio }}" placeholder="" required>
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputDate" class="col-sm-2 col-form-label">Fecha Fin</label>
              <div class="col-sm-10">
                <input type="text" id="fecha_fin" name="fecha_fin" class="form-control" value="{{ $permiso->fecha_fin }}" placeholder="" required>
              </div>
            </div>

            <div class="row mb-3">
              <!-- <label class="col-sm-2 col-form-label"></label> -->
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Actualizar Permiso</button>
              </div>
            </div>
          </form><!-- End General Form Elements -->
        </div>
      </div>
    </div>
  </div>
</section>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    flatpickr("#fecha_inicio", {
      enableTime: true, // Habilita la selección de tiempo
      dateFormat: "Y-m-d H:i", // Formato de fecha y hora
      time_24hr: false, // Formato de 24 horas
      defaultDate: false, // Fecha por defecto
      minDate: '{{$permiso->fecha_solicitud}}' // No permite seleccionar fechas pasadas
    });
  });

  document.addEventListener('DOMContentLoaded', function() {
    flatpickr("#fecha_fin", {
      enableTime: true, // Habilita la selección de tiempo
      dateFormat: "Y-m-d H:i", // Formato de fecha y hora
      time_24hr: false, // Formato de 24 horas
      defaultDate: false, // Fecha por defecto
      minDate: "today" // No permite seleccionar fechas pasadas
    });
  });
</script>
@endsection