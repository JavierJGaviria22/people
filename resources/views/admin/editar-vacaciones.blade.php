@extends('layouts.admin-layout')

@section('title', 'SkaPeople - PTO')

@section('content')

<!-- Titulo de pagina -->
<div class="pagetitle">
    <h1>Paid Time Off</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('/') }}"></a>Inicio</li>
            <li class="breadcrumb-item">PTO</li>
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section dashboard d-flex justify-content-center">

    <div class="col-lg-8 ">

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Editar Politica de PTO</h5>
                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <!-- Vertical Form -->
                <form class="row g-3" action="{{ route('vacaciones.update', $config->id_configuracion) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col-12">
                        <label for="obtencion" class="form-label fw-bold">Modelo de Obtención</label>
                        <select id="obtencion" name="obtencion" class="form-select" aria-label="Default select example" required>
                            <option value="" {{ old('obtencion') ? '' : 'selected' }} disabled>Seleccionar</option>
                            <option value="antiguedad" {{ $config->metodo == 'antiguedad' ? 'selected' : '' }}>Antiguedad</option>
                            <option value="asistencia" {{ $config->metodo == 'asistencia' ? 'selected' : '' }}>Asistencia</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="inputEmail4" class="form-label fw-bold">Ganancia PTO</label>
                    </div>
                    <div class="d-flex justify-content-evenly align-items-center">
                        <div class="col-md-1 pe-0">
                            <label for="inputCity" class="form-label ">Por:</label>
                        </div>
                        <div class="col-md-2 pe-0 ps-0">
                            <input type="text" class="form-control" name="por" value="{{ $config->por_esto }}">
                        </div>
                        <div class="col-md-5 pe-0 w-auto">
                            <label id="ganancia1" for="inputCity" class="form-label">Formato</label>
                        </div>
                        <div class="col-md-2 pe-0 ps-0">
                            <input type="text" class="form-control" name="gano" value="{{ $config->obtencion }}">
                        </div>
                        <div class="col-md-1 pe-0">
                            <label id="ganancia2" for="inputCity" class="form-label">Formato</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="prorroga" class="form-label fw-bold">Politica de Prorroga</label>
                        <select id="politicaSelect" name="prorroga" class="form-select" aria-label="Default select example" required>
                            <option value="" {{ old('prorroga') ? '' : 'selected' }} disabled>Seleccionar</option>
                            <option value="Acumulables" {{ $config->renovacion == null ? 'selected' : '' }}>Acumulables</option>
                            <option value="No Acumulables" {{ $config->renovacion !== null ? 'selected' : '' }}>No Acumulables</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="renovacion" class="form-label fw-bold">Periodo de Renovación</label>
                        <!-- <input type="text" name="renovacion" class="form-control" value="{{ $config->renovacion == null ? '' : '$config->renovacion' }}" id="datetime" placeholder="No Aplica" disabled> -->
                        <select id="datetime" name="renovacion" class="form-select" disabled>
                            <option value="{{ old('renovacion') }}" {{ old('renovacion') ? '' : 'selected' }} disabled>Seleccionar</option>
                            <option value="Anual" {{ $config->renovacion != null ? 'selected' : '' }}>Anual</option>
                        </select>
                    </div>

                    <div class="col-12 mb-0">
                        <label for="periodoPrueba" class="form-label fw-bold">Periodo de Prueba</label>
                    </div>
                    <div class="col-md-2 pt-0">
                        <input type="text" name="prueba" class="form-control" value="{{ $config->usables_apartir_de }}" id="periodoPruebaInput" disabled>
                    </div>
                    <div class="col-md-1 pe-0">
                        <label for="inputCity" class="form-label" id="periodoPruebaLabel">Formato</label>
                    </div>

                    <div class="col-12">
                        <label for="inputAddress" class="form-label fw-bold">Maximo Saldo Permitido</label>
                    </div>
                    <div class="col-md-2 pt-0">
                        <input type="text" name="maxsaldo" value="{{ $config->max_saldo }}" class="form-control" id="maxSaldoInput" disabled>
                    </div>
                    <div class="col-md-1 pe-0">
                        <label for="inputCity" class="form-label" id="maxSaldoLabel">Formato</label>
                    </div>

                    <div class="col-12">
                        <label for="inputAddress" class="form-label fw-bold">Aplicar a</label>
                    </div>
                    <div class="d-flex justify-content-evenly align-items-center">
                        <div class="col-md-5 pe-0">
                            <label for="inputCity" class="form-label ">Empleados con antiguedad entre:</label>
                        </div>
                        <div class="col-md-2 pe-0 ps-0">
                            <input type="text" name="desde" value="{{ $config->aplicar_desde_años }}" class="form-control">
                        </div>
                        <div class="col-md-1 pe-0 ps-3">
                            <label for="inputCity" class="form-label"> y </label>
                        </div>
                        <div class="col-md-2 pe-0 ps-0">
                            <input type="text" name="hasta" value="{{ $config->aplicar_hasta_años }}" class="form-control">
                        </div>
                        <div class="col-md-2 pe-0 ps-2">
                            <label for="inputCity" class="form-label"> Años</label>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <!-- <button type="reset" class="btn btn-secondary">Limpiar</button> -->
                    </div>
                </form><!-- Vertical Form -->

            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Obtén las referencias de los elementos
        const selectPolitica = document.getElementById('politicaSelect');
        const inputPeriodo = document.getElementById('datetime');

        if (selectPolitica.value == 'No Acumulables') {
            inputPeriodo.disabled = false; // Habilitar el input
        };

        // Función que verifica la selección y habilita/deshabilita el input
        selectPolitica.addEventListener('change', function() {
            if (selectPolitica.value === "No Acumulables") {
                inputPeriodo.disabled = false; // Habilitar el input
                inputPeriodo.value = "";

            } else {
                inputPeriodo.disabled = true; // Deshabilitar el input
                inputPeriodo.value = ""; // Restablecer a la opción inicial
            }
        })
    });
</script>

<script>
    // No esta en uso, para usar, agregar el id datetime1 a algun input
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#datetime1", {
            //  enableTime: true, // Habilita la selección de tiempo
            dateFormat: "Y-m-d", // Formato de fecha y hora
            // time_24hr: false, // Formato de 24 horas
            defaultDate: false, // Fecha por defecto
            //  minDate: "today" // No permite seleccionar fechas pasadas
        });
    });
</script>

<script>
    // Obtén las referencias de los elementos
    const obtencion = document.getElementById('obtencion');
    const periodoPrueba = document.getElementById('periodoPrueba');

    if (obtencion.value == 'antiguedad') {
        periodoPruebaInput.disabled = false; // Habilitar el input
        periodoPruebaLabel.innerText = "Dias";
        document.getElementById('ganancia1').innerText = "Dias Trabajados,  Ganas ✨";
        document.getElementById('ganancia2').innerText = "Dias";
        document.getElementById('maxSaldoLabel').innerText = "Dias";
        document.getElementById('maxSaldoInput').disabled = false;
    };
    if (obtencion.value == 'asistencia') {
        periodoPruebaInput.disabled = false; // Habilitar el input
        periodoPruebaLabel.innerText = "Horas";
        document.getElementById('ganancia1').innerText = "Horas Trabajadas,  Ganas ✨";
        document.getElementById('ganancia2').innerText = "Horas";
        document.getElementById('maxSaldoLabel').innerText = "Horas";
        document.getElementById('maxSaldoInput').disabled = false;
    };

    // Función que verifica la selección y habilita/deshabilita el input
    obtencion.addEventListener('change', function() {
        if (obtencion.value === "Seleccionar") {
            periodoPruebaInput.disabled = true; // Habilitar el input
            periodoPruebaLabel.innerText = "-";

        }
        if (obtencion.value === "antiguedad") {
            periodoPruebaInput.disabled = false; // Habilitar el input
            periodoPruebaLabel.innerText = "Dias";
            document.getElementById('ganancia1').innerText = "Dias Trabajados,  Ganas ✨";
            document.getElementById('ganancia2').innerText = "Dias";
            document.getElementById('maxSaldoLabel').innerText = "Dias";
            document.getElementById('maxSaldoInput').disabled = false;

        }
        if (obtencion.value === "asistencia") {
            periodoPruebaInput.disabled = false; // Habilitar el input
            periodoPruebaLabel.innerText = "Horas";
            document.getElementById('ganancia1').innerText = "Horas Trabajadas,  Ganas ✨";
            document.getElementById('ganancia2').innerText = "Horas";
            document.getElementById('maxSaldoLabel').innerText = "Horas";
            document.getElementById('maxSaldoInput').disabled = false;
        }
    });
</script>

@endsection