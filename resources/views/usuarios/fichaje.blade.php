@extends('layouts.layout')

@section('title', 'Inicio')

@section('content')
<?php

use Carbon\Carbon; ?>

<style>
    .dropdown-el {
        /* margin-top: 20vh; */
        min-width: 12em;
        position: relative;
        display: inline-block;
        margin-right: 1em;
        min-height: 2em;
        max-height: 2em;
        overflow: hidden;
        top: 0.5em;
        cursor: pointer;
        text-align: left;
        white-space: nowrap;
        color: #444;
        outline: none;
        border: 0.06em solid transparent;
        border-radius: 1em;
        background-color: rgba(54, 148, 215, 0.25);
        /* mix($color,#fff,25%) */
        transition: 0.3s all ease-in-out;
        /* $timing */

    }

    .dropdown-el input {
        width: 1px;
        height: 1px;
        display: inline-block;
        position: absolute;
        opacity: 0.01;
    }

    .dropdown-el label {
        border-top: 0.06em solid #d9d9d9;
        display: block;
        height: 2em;
        line-height: 2em;
        padding-left: 1em;
        padding-right: 3em;
        cursor: pointer;
        position: relative;
        transition: 0.3s color ease-in-out;
        /* $timing */
    }

    .dropdown-el label:nth-child(2) {
        margin-top: 2em;
        border-top: 0.06em solid #d9d9d9;
    }

    .dropdown-el input:focus+label {
        background: #def;
    }

    .dropdown-el input:checked+label {
        display: block;
        border-top: none;
        position: absolute;
        top: 0;
        width: 100%;
    }

    .dropdown-el input:checked+label:nth-child(2) {
        margin-top: 0;
        position: relative;
    }

    .dropdown-el::after {
        content: "";
        position: absolute;
        right: 0.8em;
        top: 0.9em;
        border: 0.3em solid #3694d7;
        
        border-color: #3694d7 transparent transparent transparent;
        
        transition: 0.4s all ease-in-out;
    }

    .dropdown-el.expanded {
        border: 0.06em solid #3694d7;
        
        background: #fff;
        border-radius: 0.25em;
        padding: 0;
        box-shadow: rgba(0, 0, 0, 0.1) 3px 3px 5px 0;
        max-height: 15em;
    }

    .dropdown-el.expanded label {
        border-top: 0.06em solid #d9d9d9;
    }

    .dropdown-el.expanded label:hover {
        color: #3694d7;
    }

    .dropdown-el.expanded input:checked+label {
        color: #3694d7;
    }

    .dropdown-el.expanded::after {
        transform: rotate(-180deg);
        top: 0.55em;
    }

    /* Animación para la apertura y cierre del modal */
    .modal.fade .modal-dialog {
        transform: translateY(-50px);
        /* Comienza ligeramente por encima */
        opacity: 0;
        transition: transform 0.3s ease, opacity 0.3s ease;
        /* Desvanecimiento y desplazamiento suave */
    }

    .modal.show .modal-dialog {
        transform: translateY(0);
        /* Vuelve a su posición original */
        opacity: 1;
    }

    /* Opción para un desvanecimiento más lento */
    .modal.fade .modal-content {
        transition: opacity 0.5s ease;
    }
</style>

<!-- Titulo de pagina -->
<div class="pagetitle">
    <h1>Ponchador</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('/') }}">Inicio</a></li>
            <li class="breadcrumb-item">Ponchador</li>
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section">
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '{{session('success')}}',
            showConfirmButton: false, // No mostrar el botón de confirmación
            timer: 1200, // Duración de la alerta en milisegundos
            timerProgressBar: false, // Muestra una barra de progreso mientras la alerta está visible
        });
    </script>
    @endif
    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: '¡UPS!',
            text: '{{session('error')}}',
            showConfirmButton: false, // No mostrar el botón de confirmación
            timer: 1200, // Duración de la alerta en milisegundos
            timerProgressBar: false, // Muestra una barra de progreso mientras la alerta está visible
        });
    </script>
    @endif
    <div class="row">
        <div class="col-lg-4">

            <div class="card" style="background-color: rgb(252,252,255);">
                <div class="card-body">
                    <div class="reloj" style="display: flex; justify-content: space-around; align-items:center">
                        <h3 class="card-title fs-4">{{$info_empleados->sede}}</h3>
                        <img style="width: 90px;; height: 90px;;" src="{{ asset('assets/img/temporizador.gif') }}" alt="roloj">
                    </div>
                    <p class="text-end">{{ \Carbon\Carbon::now()->format('l, d F Y') }}</p>
                </div>
                <!-- boton para ponchar -->
                <form method="POST" id="locationForm">
                    @csrf
                    <div class="d-flex pb-4 justify-content-center">
                        <span class="dropdown-el">
                            @foreach ($estados as $estado)
                            <input type="radio" name="estado-info" value="{{ $estado->id_estado }}" id="sort-{{ $estado->id_estado }}" {{ $loop->first ? 'checked' : '' }}>
                            <label for="sort-{{ $estado->id_estado }}">{{ $estado->estado }}</label>
                            @endforeach
                        </span>
                    </div>

                    <div class="mb-3 d-flex justify-content-center">
                        <input name="nota" class="form-control p-0 w-50 text-center" type="text" placeholder="Nota">
                    </div>

                    <!-- Input hidden para latitud y longitud -->
                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">

                    <div class="mb-3 d-flex justify-content-center">
                        <button type="button" class="btn btn-primary btn-sm" title="Nuevo" onclick="obtenerUbicacion()">
                            <i class="bi bi-check-circle"></i> Marcar
                        </button>
                    </div>
                </form>
            </div>

        </div>

        <div class="col-lg-8">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Ficha de Tiempo</h5>
                    <!-- Default Table -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Hora</th>
                                <th scope="col">Deshacer</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1; @endphp
                            @foreach ($fichaTiempo as $ficha)
                            <tr>
                                <td scope="row">{{$ficha->id_pd_info}}</td>
                                <td style="background-color: {{$ficha->color}};">{{$ficha->estado}}</td>
                                <td>{{ \Carbon\Carbon::parse($ficha->tiempo)->format('h:i A') }}</td>
                                @if($fichaTiempo->isNotEmpty() && $fichaTiempo->last()->id_pd_info == $ficha->id_pd_info && Carbon::parse($ficha->tiempo)->diffInMinutes(Carbon::now()) <= 1)
                                    <td class="">
                                    <a href="{{route('fichaje-deshacer',$ficha->id_pd_info)}}" class="btn btn-outline-danger btn-sm" title="Eliminar">
                                        <i class="bi bi-backspace-fill"></i>
                                    </a>
                                    </td>
                                    @else <td></td>
                                    @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- End Default Table Example -->
                </div>
            </div>

        </div>
    </div>

    <!-- Modal para corrección -->
    <div class="modal fade" id="actuarModal" tabindex="-1" aria-labelledby="actuarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="miFormulario" action="{{route('fichaje.correccion')}}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold" id="actuarModalLabel">No registró salida</h4>
                    </div>
                    <div class="modal-body">
                        <label class="form-check-label pb-3" for=""><strong>Ultimo estado registrado:</strong>
                            <p style="color: {{ $ultimoEstado->color ? $ultimoEstado->color : '#000' }}; font-weight: bold;">
                                {{$ultimoEstado->estado}}
                            </p>
                            <strong>
                                <p class="mb-0">Fecha:</p>
                            </strong>
                            <p>{{ \Carbon\Carbon::parse($ultimoEstado->tiempo)->format('Y-m-d') }}</p>
                            <strong>
                                <p class="mb-0">Hora:</p>
                            </strong>
                            <p class="mb-0">{{ \Carbon\Carbon::parse($ultimoEstado->tiempo)->format('h:i A') }}</p>
                        </label>
                        <!-- Input hidden para latitud y longitud -->
                        <input type="hidden" name="latitudeModal" id="latitudeModal">
                        <input type="hidden" name="longitudeModal" id="longitudeModal">
                        <div class="">
                            <label class="form-check-label pb-3 font-weight-bold" for="datetime"><strong>Ingresa la hora de salida:</strong> </label>
                            <input class="form-control" type="text" id="datetime" name="correccion">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="submitBtn" class="btn btn-success" id="- guardarButton">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Fin de modal de corrección -->

    <!-- Modal para ausencia -->
    <div class="modal fade" id="modalAusencia" tabindex="-1" aria-labelledby="modalAusenciaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{route('fichaje.ausencia')}}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold" id="modalAusenciaLabel">Justificar Ausencias</h4>
                    </div>
                    <div class="modal-body">
                        <label class="form-check-label pb-3" for=""><strong>Cantidad de dias de ausencia:</strong>
                            <p style="font-weight: bold; color:red;">
                                {{$intervaloDias - 1}}
                            </p>
                            <strong>
                                <p class="mb-0">Fecha Inicio:</p>
                            </strong>
                            <input class="form-control" type="text" id="" name="fecha_inicio" value="{{ \Carbon\Carbon::parse($ultimoEstado->tiempo)->addDay()->format('Y-m-d') }}" readonly>
                            <strong>
                                <p class="mb-0">Fecha Fin:</p>
                            </strong>
                            <input class="form-control" type="text" id="datetimeAusencia" name="fecha_fin" require>
                            <strong><label class="col-sm-2 col-form-label">Motivo:</label></strong>
                            <div class="col-sm-10">
                                <select name="motivo" class="form-select" aria-label="Default select example" required>
                                    <option value="" {{ old('id_tipo_permiso') ? '' : 'selected' }} disabled>Seleccionar</option>
                                    @foreach($tiposPermiso as $tipo)
                                    <option value="{{ $tipo->permiso }}" {{ old('id_tipo_permiso') == $tipo->id_tipo_permiso ? 'selected' : '' }}>
                                        {{ $tipo->permiso }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </label>
                        <!-- Input hidden para latitud y longitud -->
                        <input type="hidden" name="latitudeModal" id="latitudeModalAusencia">
                        <input type="hidden" name="longitudeModal" id="longitudeModalAusencia">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="--guardarButton">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Fin de modal de ausencia -->

    <!-- Permisos -->
    @if($permisosHoy->isNotEmpty())
    @foreach ($permisosHoy as $perHoy)
    @if($perHoy->regresa==1 && $perHoy->estado=='Aprobado')
    <div class="row">
        <div class="col-lg-4">

            <div class="card" style="background-color: rgb(252,252,255);">
                <div class="card-body">
                    <div class="reloj" style="display: flex; justify-content: space-around; align-items:center">
                        <h3 class="card-title fs-4">{{$perHoy->permiso}}</h3>
                        <img style="width: 100px;; height: 80px;" src="{{ asset('assets/img/permiso.png') }}" alt="roloj">
                    </div>
                    <p class="text-end">{{ \Carbon\Carbon::now()->format('l, d F Y') }}</p>
                </div>
                <!-- boton para ponchar -->
                <form action="{{route('fichajePermiso')}}" method="POST" id="locationFormPermiso{{$perHoy->id_permiso}}">
                    @csrf
                    <!-- <div class="d-flex pb-4 justify-content-center">
                        <span class="dropdown-el">
                            <input type="radio" name="estado-permiso" value="inicio" id="sort-in" checked>
                            <label for="sort-in">Inicio</label>
                            <input type="radio" name="estado-permiso" value="fin" id="sort-out">
                            <label for="sort-out">Fin</label>
                        </span>
                    </div> -->

                    <div class="d-flex pb-4 justify-content-center">
                        <span class="dropdown-el">
                            <input type="radio" name="estado-permiso" value="{{ $estadosPermiso=='fin' ? 'inicio' : 'fin' }}" id="sort-{{ $estadosPermiso=='fin' ? 'inicio' : 'fin' }}" {{ $loop->first ? 'checked' : '' }}>
                            <label for="sort-{{ $estadosPermiso=='fin' ? 'inicio' : 'fin' }}">{{ $estadosPermiso=='fin' ? 'inicio' : 'fin' }}</label>
                        </span>
                    </div>


                    <div class="mb-3 d-flex justify-content-center">
                        <input name="nota" class="form-control p-0 w-50 text-center" type="text" placeholder="Nota">
                    </div>

                    <!-- Input hidden para latitud y longitud -->
                    <input type="hidden" name="latitudep" id="latitudep{{$perHoy->id_permiso}}">
                    <input type="hidden" name="longitudep" id="longitudep{{$perHoy->id_permiso}}">
                    <input type="hidden" name="id_permiso" value="{{$perHoy->id_permiso}}">

                    <div class="mb-3 d-flex justify-content-center">
                        <button type="button" class="btn btn-primary btn-sm" title="Nuevo" onclick="obtenerUbicacionPermiso()">
                            <i class="bi bi-check-circle"></i> Marcar
                        </button>
                    </div>
                </form>
            </div>

        </div>

        <div class="col-lg-8">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Ficha de Permiso</h5>
                    <!-- Default Table -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Hora</th>
                                <th scope="col">deshacer</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1; @endphp
                            @foreach ($fichaPermiso as $fichap)
                            @if($fichap->id_permiso == $perHoy->id_permiso)
                            <tr>
                                <th scope="row">{{$i++}}</th>
                                <td class="table-secondary">{{ $fichap->estado  }}</td>
                                <td>{{ \Carbon\Carbon::parse($fichap->tiempo)->format('h:i A')}}</td>
                                @if($fichaPermiso->isNotEmpty() && $fichaPermiso->last()->id_pd_info_permisos == $fichap->id_pd_info_permisos && Carbon::parse($fichap->tiempo)->diffInMinutes(Carbon::now()) <= 1)
                                <td class="">
                                    <a href="{{route('fichaje-deshacer-permiso',$fichap->id_pd_info_permisos)}}" class="btn btn-outline-danger btn-sm" title="Editar">
                                        <i class="bi bi-backspace-fill"></i>
                                    </a>
                                    </td>
                                    @else <td></td>
                                    @endif
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                    <!-- End Default Table Example -->
                </div>
            </div>

        </div>
    </div>
    @endif
    @endforeach

</section>

<script>
    function obtenerUbicacionPermiso() {
        if (navigator.geolocation) {
            // Intentamos obtener la posición del usuario
            navigator.geolocation.getCurrentPosition(function(position) {
                // Asignamos la latitud y longitud a los campos hidden
                document.getElementById('latitudep{{$perHoy->id_permiso}}').value = position.coords.latitude;
                document.getElementById('longitudep{{$perHoy->id_permiso}}').value = position.coords.longitude;

                // Ahora, enviamos el formulario con los datos de la ubicación
                document.getElementById('locationFormPermiso{{$perHoy->id_permiso}}').submit();
            }, function(error) {
                alert('No se pudo obtener tu ubicación. Intenta nuevamente.');
            });
        } else {
            alert('Tu navegador no soporta la geolocalización.');
        }
    };
</script>
@endif
<script>
    $('.dropdown-el').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).toggleClass('expanded');
        $('#' + $(e.target).attr('for')).prop('checked', true);
    });
    $(document).click(function() {
        $('.dropdown-el').removeClass('expanded');
    });
    //////////
    function obtenerUbicacion() {
        if (navigator.geolocation) {
            // Intentamos obtener la posición del usuario
            navigator.geolocation.getCurrentPosition(function(position) {
                // Asignamos la latitud y longitud a los campos hidden
                document.getElementById('latitude').value = position.coords.latitude;
                document.getElementById('longitude').value = position.coords.longitude;

                // Ahora, enviamos el formulario con los datos de la ubicación
                document.getElementById('locationForm').submit();
            }, function(error) {
                alert('No se pudo obtener tu ubicación. Intenta nuevamente.');
            });
        } else {
            alert('Tu navegador no soporta la geolocalización.');
        }
    };
</script>

@if($intervaloDias > 1 && ($ultimoEstado->tipo_estado == 'out' || $ultimoEstado->tipo_estado == 'ausencia'))
<script>
    $(document).ready(function() {
        // Abre el modal automáticamente cuando se carga la página
        $('#modalAusencia').modal({
            backdrop: 'static', // Evita que el modal se cierre al hacer clic fuera de él
            keyboard: false // Evita que el modal se cierre con la tecla Esc
        }).modal('show');

        // Cerrar el modal solo al hacer clic en el botón "Guardar"
        $('#guardarButton').on('click', function() {
            $('#modalAusencia').modal('hide'); // Cierra el modal cuando se hace clic en el botón "Guardar"
        });
    });
</script>
@endif

@if($ultimoEstado->tipo_estado == 'in')
<script>
    $(document).ready(function() {
        $('#actuarModal').modal({
            backdrop: 'static',
            keyboard: false
        }).modal('show');

        $('#guardarButton').on('click', function() {
            $('#actuarModal').modal('hide');
        });
    });
</script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#datetime", {
            enableTime: true,
            dateFormat: "H:i",
            noCalendar: true,
            time_24hr: false,
            defaultDate: false,
            minDate: "today"
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#datetimeAusencia", {
            enableTime: false,
            dateFormat: "Y-m-d",
            noCalendar: false,
            time_24hr: false,
            defaultDate: false,
            minDate: "{{$minFechaAusencia}}",
            maxDate: "{{$maxFechaAusencia}}"
        });
    });
</script>

<script>
    navigator.geolocation.getCurrentPosition(function(position) {
        // Asignamos la latitud y longitud a los campos hidden
        document.getElementById('latitudeModal').value = position.coords.latitude;
        document.getElementById('longitudeModal').value = position.coords.longitude;
        // Verifica si los valores se están asignando
        console.log("Latitud:", position.coords.latitude);
        console.log("Longitud:", position.coords.longitude);
    });

    navigator.geolocation.getCurrentPosition(function(position) {
        // Asignamos la latitud y longitud a los campos hidden
        document.getElementById('latitudeModalAusencia').value = position.coords.latitude;
        document.getElementById('longitudeModalAusencia').value = position.coords.longitude;
        // Verifica si los valores se están asignando
        console.log("Latitud:", position.coords.latitude);
        console.log("Longitud:", position.coords.longitude);
    });
</script>

<script>
    document.getElementById('miFormulario').addEventListener('submit', function(event) {
  var boton = document.getElementById('submitBtn');
  
  boton.disabled = true;
});

</script>
@endsection