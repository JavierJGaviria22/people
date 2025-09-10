@extends('layouts.admin-layout')

@section('title', 'SkaPeople - Horarios')

@section('content')
<!-- Titulo de pagina -->
<div class="pagetitle">
    <h1>Editar Horario</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('/') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('mis-permisos') }}">Horarios</a></li>
            <li class="breadcrumb-item"><a href="{{ route('nuevo-permiso') }}">Editar Horario</a></li>
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-body ">
                    <form action="{{route('horarios.actualizar')}}" method="POST">
                        @csrf
                        <div class=" d-flex align-items-baseline justify-content-between mt-3">
                            <h5 class="card-title">Horario para editar a <strong> {{$nombre_empleado->nombre}} {{$nombre_empleado->apellido}}</strong></h5>
                            <div class="d-flex gap-2 align-items-baseline justify-content-end">
                                <h6 class="card-title"><strong>Total a Trabajar:</strong></h4>
                                    <!-- <span class="card-title" id="totalSumado">0</span> -->
                                    <input name="totalFinal" class="form-control" style="width: 18%;" id="totalSumado" required readonly>
                                    <input type="hidden" name="intervalo" value="{{$intervalo}}" required>
                                    <input type="hidden" name="id_empleado" value="{{$nombre_empleado->id_empleado}}" required>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-4 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
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
                            <table class="table table-bordered table-sm">
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
                                @php $i=0; @endphp
                                    @foreach($horarios as $horario)
                                    
                                        <tr>
                                            <td class="text-center">{{ \Carbon\Carbon::parse($horario->fecha_h)->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</td>
                                            <input type="hidden" name="fecha{{$i}}" value="{{ \Carbon\Carbon::parse($horario->fecha_h)}}" required>
                                            <td class="text-center"><input name="entrada{{$i}}" class="form-control hora1" type="time" id="hora" value="{{$horario->entrada_h}}" required {{$horario->id_permiso == null || $horario->id_permiso == 6 ? '' : 'disabled'}}></td>
                                            <td class="text-center"><input name="salida{{$i}}" class="form-control hora2" type="time" id="hora2" value="{{$horario->salida_h}}" required {{$horario->id_permiso == null || $horario->id_permiso == 6 ? '' : 'disabled'}}></td>
                                            <td class="text-center"><input name="lunch{{$i}}" class="form-control lunch" type="number" id="cantidad" name="cantidad" min="0" step="any" value="{{$horario->tiempo_fuera}}" required {{$horario->id_permiso == null || $horario->id_permiso == 6 ? '' : 'disabled'}}></td>
                                            <td class="text-center"> <select style="width: auto;" id="sede" name="sede{{$i}}" class="form-select" aria-label="Default select example" required {{$horario->id_permiso == null || $horario->id_permiso == 6 ? '' : 'disabled'}}>
                                                    <option value="" {{ $horario->id_sede == null ? 'selected' : '' }} disabled>Seleccionar</option>
                                                    @foreach($sedes as $sede)
                                                    <option value="{{ $sede->id_sede }}" {{ $horario->id_sede == $sede->id_sede ? 'selected' : '' }}>
                                                        {{ $sede->nombre }}
                                                    </option>
                                                    @endforeach
                                                </select></td>
                                            <td class="text-center"><input name="total{{$i}}" class="form-control resultado" id="resultado" value="{{$horario->total}}" required readonly {{$horario->id_permiso == null || $horario->id_permiso == 6 ? '' : 'disabled'}}></td>
                                            <td class="text-center"><select style="width: auto;" id="novedad" name="novedad{{$i}}" class="form-select" aria-label="Default select example">
                                                    <option value="" {{ $horario->id_permiso ? '' : 'selected' }}>Sin Novedad</option>
                                                    @foreach($novedades as $novedad)
                                                    <option value="{{ $novedad->id_tipo_permiso }}" {{ $horario->id_permiso == $novedad->id_tipo_permiso ? 'selected' : '' }}>
                                                        {{ $novedad->permiso }}
                                                    </option>
                                                    @endforeach
                                                </select></td>
                                        </tr>
                                        @php $i++; @endphp
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    // Obtener todas las referencias a los elementos del DOM con las clases correspondientes
    const horas1Inputs = document.querySelectorAll('.hora1');
    const horas2Inputs = document.querySelectorAll('.hora2');
    const lunchInputs = document.querySelectorAll('.lunch');
    const resultadoInputs = document.querySelectorAll('.resultado');

    // Iterar sobre cada conjunto de inputs
    horas1Inputs.forEach((hora1Input, index) => {
        const hora2Input = horas2Inputs[index];
        const lunchInput = lunchInputs[index];
        const resultadoInput = resultadoInputs[index];

        // Escuchar cambios en los inputs de hora y lunch para cada conjunto
        hora1Input.addEventListener('input', calcularDiferencia);
        hora2Input.addEventListener('input', calcularDiferencia);
        lunchInput.addEventListener('input', calcularDiferencia);

        function calcularDiferencia() {
            const hora1 = hora1Input.value;
            const hora2 = hora2Input.value;
            const lunch = parseFloat(lunchInput.value); // Convertir a número decimal

            // Verificar que haya valores en ambos inputs
            if (hora1 && hora2) {
                // Convertir las cadenas de hora a objetos Date
                const date1 = new Date(`2000-01-01T${hora1}`);
                const date2 = new Date(`2000-01-01T${hora2}`);

                // Calcular la diferencia en milisegundos
                let diferencia_ms = date2 - date1;

                // Convertir la diferencia a horas
                let diferencia_horas = diferencia_ms / (1000 * 60 * 60);

                // Restar el tiempo de descanso
                diferencia_horas -= lunch;

                // Mostrar el resultado en el input de resultado
                resultadoInput.value = diferencia_horas.toFixed(2); // Mostrar dos decimales
            }
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Obtener todos los selects de novedad
        const novedadesSelects = document.querySelectorAll('#novedad');

        // Iterar sobre cada select de novedad
        novedadesSelects.forEach((novedadSelect, index) => {
            // Obtener todos los inputs de la fila correspondiente
            const fila = novedadSelect.closest('tr');
            const inputsDeFila = fila.querySelectorAll('input, select'); // Seleccionamos todos los inputs y selects de la fila

            // Obtener el input de fecha correspondiente (por su nombre)
            const fechaInput = fila.querySelector(`input[name="fecha${index}"]`);

            // Agregar un evento para cuando el usuario cambie la opción de novedad
            novedadSelect.addEventListener('change', function() {
                // Verificamos si la opción seleccionada no es "Sin Novedad" (o su valor 5)
                if (novedadSelect.value !== "" && novedadSelect.value !== "5" && novedadSelect.value !== "6") { // "5" es el valor de Sin Novedad
                    // Deshabilitar todos los inputs de la fila excepto el select de novedad y el input de fecha
                    inputsDeFila.forEach(input => {
                        if (input !== novedadSelect && input !== fechaInput) { // No deshabilitar el select de novedad ni el input de fecha
                            input.disabled = true; // Deshabilitar el input
                            input.value = ""; // Borrar el valor del input
                        }
                    });
                } else {
                    // Habilitar todos los inputs de la fila si es "Sin Novedad" o valor 5
                    inputsDeFila.forEach(input => {
                        if (input !== novedadSelect && input !== fechaInput) { // No habilitar el select de novedad ni el input de fecha
                            input.disabled = false; // Habilitar el input
                        }
                    });
                }
            });
        });
    });
</script>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Función para calcular la suma de la columna Total
        function calcularSumaTotal() {
            let total = 0;

            // Obtener todos los inputs de la columna Total (clase .resultado)
            const resultados = document.querySelectorAll('.resultado');

            // Recorrer todos los inputs y sumarlos
            resultados.forEach(input => {
                const valor = parseFloat(input.value); // Convertir el valor del input a número
                if (!isNaN(valor)) { // Verificar que el valor sea un número válido
                    total += valor; // Sumar al total
                }
            });

            // Mostrar el total en el contenedor con id 'totalSumado'
            document.getElementById('totalSumado').value = total.toFixed(2); // Mostrar el total con dos decimales
        }

        // Obtener todas las referencias a los elementos del DOM con las clases correspondientes
        const horas1Inputs = document.querySelectorAll('.hora1');
        const horas2Inputs = document.querySelectorAll('.hora2');
        const lunchInputs = document.querySelectorAll('.lunch');
        const resultadoInputs = document.querySelectorAll('.resultado');

        // Iterar sobre cada conjunto de inputs
        horas1Inputs.forEach((hora1Input, index) => {
            const hora2Input = horas2Inputs[index];
            const lunchInput = lunchInputs[index];
            const resultadoInput = resultadoInputs[index];

            // Escuchar cambios en los inputs de hora y lunch para cada conjunto
            hora1Input.addEventListener('input', function() {
                calcularDiferencia(index);
                calcularSumaTotal(); // Actualizar la suma cada vez que se recalculen los resultados
            });
            hora2Input.addEventListener('input', function() {
                calcularDiferencia(index);
                calcularSumaTotal(); // Actualizar la suma cada vez que se recalculen los resultados
            });
            lunchInput.addEventListener('input', function() {
                calcularDiferencia(index);
                calcularSumaTotal(); // Actualizar la suma cada vez que se recalculen los resultados
            });

            function calcularDiferencia() {
                const hora1 = hora1Input.value;
                const hora2 = hora2Input.value;
                const lunch = parseFloat(lunchInput.value); // Convertir a número decimal

                // Verificar que haya valores en ambos inputs
                if (hora1 && hora2) {
                    // Convertir las cadenas de hora a objetos Date
                    const date1 = new Date(`2000-01-01T${hora1}`);
                    const date2 = new Date(`2000-01-01T${hora2}`);

                    // Calcular la diferencia en milisegundos
                    let diferencia_ms = date2 - date1;

                    // Convertir la diferencia a horas
                    let diferencia_horas = diferencia_ms / (1000 * 60 * 60);

                    // Restar el tiempo de descanso
                    diferencia_horas -= lunch;

                    // Mostrar el resultado en el input de resultado
                    resultadoInput.value = diferencia_horas.toFixed(2); // Mostrar dos decimales
                }
            }
        });

        // Inicializar la suma total cuando se carga la página
        calcularSumaTotal();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#hora", {
            enableTime: true, // Habilitar la selección de tiempo
            noCalendar: true, // Ocultar el calendario
            dateFormat: "H:i", // Formato de hora que se va a mostrar y guardar
            time_24hr: false, // Usar formato de 24 horas

        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#hora2", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: false,
        });
    });
</script>
@endsection