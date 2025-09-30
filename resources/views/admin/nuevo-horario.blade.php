@extends('layouts.admin-layout')

@section('title', 'SkaPeople - Horarios')

@section('content')
    <!-- Titulo de pagina -->
    <div class="pagetitle">
        <h1>{{ $accion }} Horario</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('/') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('mis-permisos') }}">Horarios</a></li>
                <li class="breadcrumb-item"><a href="{{ route('nuevo-permiso') }}">{{ $accion }} Horario</a></li>
            </ol>
        </nav>
    </div> <!-- Fin titulo de pagina -->

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-body ">
                        <h5 class="card-title">Seleccion de empleado y rango de fechas</h5>

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            
                                @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                                @endforeach
                           
                        </div>
                        @endif

                        @if (session('errores'))
                        <div class="alert alert-danger">
                           
                                @foreach (session('errores') as $error)
                                <p style="margin: 0">{{ $error }}</p>
                                @endforeach
                            
                        </div>
                        @endif

                        <!-- General Form Elements -->
                        <form action="{{ route('horarios.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="accion" value="{{ $accion }}">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Empleado</label>
                                <div class="col-sm-10">
                                    <select name="empleado[]" class="form-select" id="empleadoSelect" multiple="multiple"
                                        required>
                                        @foreach ($empleados as $empleado)
                                            <option value="{{ $empleado->id_empleado }}"
                                                {{ in_array($empleado->id_empleado, old('empleado', [])) ? 'selected' : '' }}>
                                                {{ $empleado->nombre }} {{ $empleado->apellido }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Puedes seleccionar hasta 3 empleados.</small>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="datetime2" class="col-sm-2 col-form-label">Fecha Inicio</label>
                                <div class="col-sm-10">
                                    <input type="text" id="datetime2" name="fecha_inicio" class="form-control"
                                        value="{{ old('fecha_inicio') }}" placeholder="" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="datetime" class="col-sm-2 col-form-label">Fecha Fin</label>
                                <div class="col-sm-10">
                                    <input type="text" id="datetime" name="fecha_fin" class="form-control"
                                        value="{{ old('fecha_fin') }}" placeholder="" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- <label class="col-sm-2 col-form-label"></label> -->
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Asignar</button>
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
                dateFormat: "Y-m-d",
                time_24hr: false,
                defaultDate: false,

            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#datetime2", {
                dateFormat: "Y-m-d",
                time_24hr: false,
                defaultDate: false,
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#empleadoSelect').select2({
                placeholder: "",
                maximumSelectionLength: 3,
                width: '100%',
                language: {
                    maximumSelected: function(args) {
                        return "Solo puedes seleccionar hasta 3 empleados";
                    }
                }
            });
        });
    </script>
@endsection
