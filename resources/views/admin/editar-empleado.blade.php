@extends('layouts.admin-layout')

@section('title', 'SkaPeople - Permisos')

@section('content')
<!-- Titulo de pagina -->
<style>
    input::placeholder,
    select::placeholder {
        font-size: 15px;
        text-align: left;
    }
</style>
<div class="pagetitle">
    <h1>Editar Empleado</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('/admin') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('empleados') }}">Empleados</a></li>
            <li class="breadcrumb-item"><a href="{{ route('editar-empleado', $empleado->id_empleado) }}">Editar Empleado</a></li>
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section">
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
    <form action="{{route('editar-empleado', $empleado->id_empleado)}}" method="POST">
        @csrf
        <div class="row">

            <div class="col-lg-6">

                <div class="card">
                    <div class="card-body">

                        <h5 class="card-title">Informacion Personal</h5>

                        <!-- General Form Elements -->
                        <div class="row mb-3">
                            <label for="cedula" class="col-sm-4 col-form-label">Identificacion:</label>
                            <div class="col-sm-8">
                                <input type="text" id="cedula" name="cedula" class="form-control col-sm-1" value="{{ $empleado->cedula }}" placeholder="Ej: Cedula..." required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nombre" class="col-sm-3 col-form-label">Nombres:</label>
                            <div class="col-sm-9">
                                <input type="text" id="nombre" name="nombre" class="form-control col-sm-1" value="{{ $empleado->nombre }}" placeholder="Ej: Marcos..." required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="apellido" class="col-sm-3 col-form-label">Apellidos:</label>
                            <div class="col-sm-9">
                                <input type="text" id="apellido" name="apellido" class="form-control col-sm-1" value="{{ $empleado->apellido }}" placeholder="Ej: Fenix..." required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="datetime" class="col-sm-3 col-form-label">Nacimiento:</label>
                            <div class="col-sm-9">
                                <input type="text" id="datetime" name="nacimiento" class="form-control" value="{{ $empleado->fecha_nacimiento }}" placeholder="Ej: 1995-05-16" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="genero" class="col-sm-3 col-form-label">Genero:</label>
                            <div class="col-sm-9">
                                <select id="genero" name="genero" class="form-select" aria-label="Default select example" required>
                                    <option value="" selected disabled>Seleccionar</option>
                                    <option value="Masculino" {{ $empleado->genero == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                    <option value="Femenino" {{ $empleado->genero == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-sm-3 col-form-label">E-mail:</label>
                            <div class="col-sm-9">
                                <input type="email" id="email" name="email" class="form-control col-sm-1" value="{{ $empleado->correo }}" placeholder="Ej: Corre@gmail.com" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Segunda card -->

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Informacion Laboral</h5>
                        <!-- General Form Elements -->
                        <div class="row mb-3">
                            <label for="datetime2" class="col-sm-3 col-form-label">Ingreso:</label>
                            <div class="col-sm-9">
                                <input type="text" id="datetime2" name="ingreso" class="form-control" value="{{ $empleado->fecha_entrada }}" placeholder="Ej: {{today()->format('Y-m-d')}}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="telefono" class="col-sm-3 col-form-label">Telefono:</label>
                            <div class="col-sm-9">
                                <input type="text" id="telefono" name="telefono" class="form-control col-sm-1" value="{{ $empleado->celular }}" placeholder="Ej: 3216549871" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="estado-civil" class="col-sm-3 col-form-label">Estado Civil:</label>
                            <div class="col-sm-9">
                                <select id="estado-civil" name="estado-civil" class="form-select" aria-label="Default select example" required>
                                    <option value="" selected disabled>Seleccionar</option>
                                    <option value="Soltero" {{ $empleado->estado_civil == 'Soltero' ? 'selected' : '' }}>Soltero/a</option>
                                    <option value="Casado" {{ $empleado->estado_civil == 'Casado' ? 'selected' : '' }}>Casado/a</option>
                                    <option value="Divorciado" {{ $empleado->estado_civil == 'Divorciado' ? 'selected' : '' }}>Divorciado/a</option>
                                    <option value="Viudo" {{ $empleado->estado_civil == 'Viudo' ? 'selected' : '' }}>Viudo/a</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nhijos" class="col-sm-3 col-form-label">Nro Hijos:</label>
                            <div class="col-sm-9">
                                <input type="text" id="nhijos" name="nhijos" class="form-control col-sm-1" value="{{ $empleado->nro_hijos }}" placeholder="Ej: 2" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="dpto" class="col-sm-3 col-form-label">Dpto:</label>
                            <div class="col-sm-9">
                                <select id="dpto" name="dpto" class="form-select" aria-label="Default select example" required>
                                    <option value="" {{$empleado->departamento ? '' : 'selected' }} disabled>Seleccionar</option>
                                    @foreach($selectDepartamentos as $dpto)
                                    <option value="{{ $dpto->id_departamento }}"{{ $empleado->departamento == $dpto->nombre ? 'selected' : '' }}>
                                        {{ $dpto->nombre }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="sede" class="col-sm-3 col-form-label">Sede:</label>
                            <div class="col-sm-9">
                                <select id="sede" name="sede" class="form-select" aria-label="Default select example" required>
                                    <option value="" {{ $empleado->id_sede ? '' : 'selected' }} disabled>Seleccionar</option>
                                    @foreach($selectSedes as $sede)
                                    <option value="{{ $sede->id_sede }}" {{ $empleado->id_sede == $sede->id_sede ? 'selected' : '' }}>
                                        {{ $sede->nombre }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row mb-12 justify-content-end">
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-primary">Actualizar Empleado</button>
                </div>
            </div>
        </div>

    </form>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#datetime", {
            //  enableTime: true, // Habilita la selección de tiempo
            dateFormat: "Y-m-d", // Formato de fecha y hora
            // time_24hr: false, // Formato de 24 horas
            defaultDate: false, // Fecha por defecto
            //  minDate: "today" // No permite seleccionar fechas pasadas
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#datetime2", {
            // enableTime: true, // Habilita la selección de tiempo
            dateFormat: "Y-m-d", // Formato de fecha y hora
            time_24hr: false, // Formato de 24 horas
            defaultDate: false, // Fecha por defecto
            //minDate: "today" // No permite seleccionar fechas pasadas
        });
    });
</script>
@endsection