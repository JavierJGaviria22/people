@extends('layouts.admin-layout')

@section('title', 'SkaPeople - Contratos')

@section('content')
<!-- Titulo de pagina -->
<div class="pagetitle">
    <h1>Nuevo Contrato</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('/admin') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('contratos.index') }}">Contratos</a></li>
            <li class="breadcrumb-item"><a href="{{ route('contratos.create') }}">Nuevo Contrato</a></li>
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Crear Contrato</h5>

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
                    <form action="{{route('contratos.store')}}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <label for="empleado" class="col-sm-3 col-form-label">Empleado:</label>
                            <div class="col-sm-9">
                                <select id="empleado" name="empleado" class="form-select" aria-label="Default select example" required>
                                    <option value="" {{ old('empleado') ? '' : 'selected' }} disabled>Seleccionar</option>
                                    @foreach($empleados as $empleado)
                                    <option value="{{ $empleado->id_empleado }}" {{ old('empleado') == $empleado->id_empleado ? 'selected' : '' }}>
                                        {{ $empleado->nombre }} {{ $empleado->apellido }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tipo_contrato" class="col-sm-3 col-form-label">Tipo de Contrato:</label>
                            <div class="col-sm-9">
                                <select id="tipo_contrato" name="tipo_contrato" class="form-select" aria-label="Default select example" required>
                                    <option value="" {{ old('tipo_contrato') ? '' : 'selected' }} disabled>Seleccionar</option>
                                    @foreach($tipoContratos as $tipo)
                                    <option value="{{ $tipo->id_tipo_contrato }}" {{ old('tipo_contrato') == $tipo->id_tipo_contrato ? 'selected' : '' }}>
                                        {{ $tipo->nombre }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="cargo" class="col-sm-2 col-form-label">Cargo:</label>
                            <div class="col-sm-10">
                                <input type="text" id="cargo" name="cargo" class="form-control" value="{{ old('cargo') }}" placeholder="Ej: Asesora de ventas" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="funciones" class="col-sm-2 col-form-label">Funciones:</label>
                            <div class="col-sm-10">
                                <textarea id="funciones" name="funciones" class="form-control" style="height: 100px" placeholder="Ej: Seguimiento de clientes... ">{{ old('funciones') }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="salario" class="col-sm-2 col-form-label">Salario:</label>
                            <div class="col-sm-10">
                                <input type="text" id="salario" name="salario" class="form-control" value="{{ old('salario') }}" placeholder="Ej: 1500000" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="" class="col-sm-2 col-form-label">Días laborales:</label>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="dias_laborales[]" value="2" id="lunes">
                                    <label class="form-check-label" for="lunes">Lunes</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="dias_laborales[]" value="3" id="martes">
                                    <label class="form-check-label" for="martes">Martes</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="dias_laborales[]" value="4" id="miercoles">
                                    <label class="form-check-label" for="miercoles">Miércoles</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="dias_laborales[]" value="5" id="jueves">
                                    <label class="form-check-label" for="jueves">Jueves</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="dias_laborales[]" value="6" id="viernes">
                                    <label class="form-check-label" for="viernes">Viernes</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="dias_laborales[]" value="7" id="sabado">
                                    <label class="form-check-label" for="sabado">Sábado</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="dias_laborales[]" value="1" id="domingo">
                                    <label class="form-check-label" for="domingo">Domingo</label>
                                </div>
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="datetime" class="col-sm-2 col-form-label">Inicio:</label>
                            <div class="col-sm-10">
                                <input type="text" id="datetime" name="fecha_inicio" class="form-control" value="{{ old('fecha_inicio') }}" placeholder="2024-10-29" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="datetime2" class="col-sm-2 col-form-label">Fecha Fin</label>
                            <div class="col-sm-10">
                                <input type="text" id="datetime2" name="fecha_fin" class="form-control" value="{{ old('fecha_fin') }}" placeholder="2024-10-31" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- <label class="col-sm-2 col-form-label"></label> -->
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Crear Contrato</button>
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
        flatpickr("#datetime", {
            //enableTime: true, // Habilita la selección de tiempo
            dateFormat: "Y-m-d", // Formato de fecha y hora
            time_24hr: false, // Formato de 24 horas
            defaultDate: false, // Fecha por defecto
            minDate: "today" // No permite seleccionar fechas pasadas
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#datetime2", {
            //enableTime: true, // Habilita la selección de tiempo
            dateFormat: "Y-m-d", // Formato de fecha y hora
            time_24hr: false, // Formato de 24 horas
            defaultDate: false, // Fecha por defecto
            minDate: "today" // No permite seleccionar fechas pasadas
        });
    });
</script>
@endsection