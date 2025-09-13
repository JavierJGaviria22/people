@php
    $fecha_inicio_original = $fecha_inicio;
@endphp

@extends('layouts.layout')

@section('title', 'SkaPeople - Horarios')

@section('content')
<!-- Titulo de pagina -->

<head>
    <style>
        .form-control {
            padding: 0;
            font-size: 0.8rem;
        }

        .form-select {
            padding: 0 20px 0 0;
            font-size: 0.8rem;
        }

        .novedad {
            width: 8rem;
        }

       .btn-asignar {
            padding: 5px;
            font-size: 0.77rem;
       }
    </style>
</head>

<div class="pagetitle">
    <h1>Crear Horario</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('/') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('mis-permisos') }}">Horarios</a></li>
            <li class="breadcrumb-item"><a href="{{ route('nuevo-permiso') }}">Crear Horario</a></li>
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

@php $j = 0; @endphp
<section class="section" style="font-size: 0.8rem;">
    <div class="row justify-content-center">
        <div class="col-lg-10 d-flex gap-4" style="width: 100%;">
            @foreach ($id_empleado as $emp)
            <div class="card">
                <div class="card-body ">
                    {{-- QUITAMOS EL FORM --}}
                    <div class=" d-flex align-items-baseline justify-content-between mt-3">
                        <h5 class="card-title">Horario para asignar a <strong> {{$nombre_empleado[$j]->nombre}} {{$nombre_empleado[$j]->apellido}}</strong></h5>
                        <div class="d-flex gap-2 align-items-baseline justify-content-end">
                            <h6 class="card-title"><strong>Total a Trabajar:</strong></h6>
                                <input name="totalFinal" class="form-control" style="width: 25%;" id="totalSumado-{{ $j }}" required readonly>
                                <input type="hidden" id="intervalo-{{ $j }}" value="{{$intervalo->days}}" required>
                                <input type="hidden" id="id_empleado-{{ $j }}" value="{{$nombre_empleado[$j]->id_empleado}}" required>
                        </div>
                    </div>
                    <div class="col-sm-12 mb-4 d-flex justify-content-end">
                        <button type="button" class="btn btn-primary btn-asignar" data-index="{{ $j }}">Asignar</button>
                    </div>

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

                    <!-- Table with stripped rows -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm" id="tabla-horario-{{ $j }}">
                            <thead>
                                <tr>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Entrada</th>
                                    <th class="text-center">Salida</th>
                                    <th class="text-center">Almuerzo</th>
                                    <th class="text-center">Sede</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Novedad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                if($j > 0) {
                                    $fecha_inicio = $fecha_inicio->modify("-" . $intervalo->days + 1 . " day");
                                }
                                @endphp
                                
                                @for($i = 0; $i <= $intervalo->days; $i++)
                                    <tr>
                                        <td class="text-center" data-index="{{ $j }}">
                                            {{ \Carbon\Carbon::parse($fecha_inicio)->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                                            <input type="hidden" class="fecha" data-index="{{ $j }}" value="{{ \Carbon\Carbon::parse($fecha_inicio)->toDateString()}}" required>
                                        </td>
                                        <td class="text-center"><input class="form-control hora1" type="time" data-index="{{ $j }}" required></td>
                                        <td class="text-center"><input class="form-control hora2" type="time" data-index="{{ $j }}" required></td>
                                        <td class="text-center"><input class="form-control lunch" type="number" min="0" step="any" data-index="{{ $j }}" required></td>
                                        <td class="text-center">
                                            <select style="width: auto;" class="form-select sede" data-index="{{ $j }}" required>
                                                <option value="" disabled selected>Seleccionar</option>
                                                @foreach($sedes as $sede)
                                                <option value="{{ $sede->id_sede }}">{{ $sede->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="text-center"><input class="form-control resultado" data-index="{{ $j }}" required readonly></td>
                                        <td class="text-center">
                                            <select style="" class="form-select novedad" data-index="{{ $j }}">
                                                <option value="" selected>Sin Novedad</option>
                                                @foreach($novedades as $novedad)
                                                <option value="{{ $novedad->id_tipo_permiso }}">{{ $novedad->permiso }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    @php $fecha_inicio = $fecha_inicio->modify("+1 day"); @endphp
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @php $j = $j + 1; @endphp
            @endforeach
        </div>
    </div>
</section>

{{-- SCRIPTS --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {
    function deshabilitarElementosPorDataIndex(index) {
    $('[data-index="' + index + '"]').filter('input, select, button').prop('disabled', true);
    $('[data-index="' + index + '"]').filter('td').css('background-color', 'chartreuse');
    }
    // Para cada card
    @foreach ($id_empleado as $emp)
    (function(index) {
        // Calcular suma total de la card
        function calcularSumaTotalCard() {
            let total = 0;
            $(`.resultado[data-index='${index}']`).each(function() {
                const valor = parseFloat($(this).val());
                if (!isNaN(valor)) total += valor;
            });
            $(`#totalSumado-${index}`).val(total.toFixed(2));
        }

        // Cálculo de diferencia por fila
        $(`.hora1[data-index='${index}'], .hora2[data-index='${index}'], .lunch[data-index='${index}']`).on('input', function() {
            const row = $(this).closest('tr');
            const hora1 = row.find(`.hora1[data-index='${index}']`).val();
            const hora2 = row.find(`.hora2[data-index='${index}']`).val();
            const lunch = parseFloat(row.find(`.lunch[data-index='${index}']`).val()) || 0;
            if (hora1 && hora2) {
                const date1 = new Date(`2000-01-01T${hora1}`);
                const date2 = new Date(`2000-01-01T${hora2}`);
                let diferencia_horas = (date2 - date1) / (1000 * 60 * 60) - lunch;
                row.find(`.resultado[data-index='${index}']`).val(diferencia_horas.toFixed(2));
            } else {
                row.find(`.resultado[data-index='${index}']`).val('');
            }
            calcularSumaTotalCard();
        });

        // Inicializar suma al cargar
        calcularSumaTotalCard();

        // Novedad: deshabilitar/rehabilitar inputs de la fila
        $(`.novedad[data-index='${index}']`).on('change', function() {
            const row = $(this).closest('tr');
            if ($(this).val() !== "" && $(this).val() !== "5" && $(this).val() !== "6") {
                row.find('input, select').not(this).not('.fecha').prop('disabled', true).val('');
            } else {
                row.find('input, select').not(this).not('.fecha').prop('disabled', false);
            }
        });

        // Enviar por AJAX
        $(`.btn-asignar[data-index='${index}']`).on('click', function() {
            $('[data-index="' + index + '"]').filter('button').prop('disabled', true);
            let data = {
                _token: '{{ csrf_token() }}',
                id_empleado: $(`#id_empleado-${index}`).val(),
                totalFinal: $(`#totalSumado-${index}`).val(),
                intervalo: $(`#intervalo-${index}`).val(),
            };
            // Recorrer filas y agregar datos
            $(`#tabla-horario-${index} tbody tr`).each(function(i) {
                data[`fecha${i}`] = $(this).find('.fecha').val();
                data[`entrada${i}`] = $(this).find('.hora1').val();
                data[`salida${i}`] = $(this).find('.hora2').val();
                data[`lunch${i}`] = $(this).find('.lunch').val();
                data[`sede${i}`] = $(this).find('.sede').val();
                data[`total${i}`] = $(this).find('.resultado').val();
                data[`novedad${i}`] = $(this).find('.novedad').val();
            });
            $.ajax({
                url: '{{ route('horarios.crear') }}',
                method: 'POST',
                data: data,
                success: function(response) {
                    if (response.success == false) {
                        alert('Ya existe un horario en alguna de las fechas o hay campos vacios');
                        $('[data-index="' + index + '"]').filter('input, select, button').prop('disabled', false);
                    } else {
                        deshabilitarElementosPorDataIndex(index);
                        alert('Horario asignado correctamente');
                    }
                },
                error: function(xhr) {
                    alert('Error al asignar horario');
                }
            });
        });
    })({{ $loop->index }});
    @endforeach
});
</script>

{{-- Si usas flatpickr, inicialízalo así para cada input --}}
<script>
$(document).ready(function() {
    @foreach ($id_empleado as $emp)
    $(`.hora1[data-index='{{ $loop->index }}']`).each(function() {
        flatpickr(this, {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: false,
        });
    });
    $(`.hora2[data-index='{{ $loop->index }}']`).each(function() {
        flatpickr(this, {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: false,
        });
    });
    @endforeach
});
</script>
@endsection