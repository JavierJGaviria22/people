@extends('layouts.admin-layout')

@section('title', 'SkaPeople - Reportes')

@section('content')

<style>
    td {
        font-size: 13px;
    }

    label {
        padding: 0 0 17px 0;
    }
</style>

<!-- Titulo de pagina -->
<div class="pagetitle">
    <h1>Reportes</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('/') }}"></a>Inicio</li>
            <li class="breadcrumb-item">Reportes e Informes</li>
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Reporte de horas trabajadas</h5>
                    <p>Horas trabajadas por día de cada empleado</p>
                   
                    <!-- Table with stripped rows -->
                    <div class="table-responsive">
                        <div class="tb-filtro d-flex justify-content-end">
                            <table border="0" cellspacing="5" cellpadding="5">
                                <tbody>
                                <tr>
                                    <td>Desde:</td>
                                    <td><input type="date" id="min" name="min"></td>
                                </tr>
                                <tr>
                                    <td>Hasta:</td>
                                    <td><input type="date" id="max" name="max"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Mostrar los totales al final de la tabla -->
    <div class="p-0 m-0 d-flex gap-3" style="width: 90%;">
        <div class="col-md-6 d-flex justify-content-end p-0">
            <strong class="border p-3" id="totalTrabajadoSum" style="color: #012970">Total Trabajado: 0.00</strong>
        </div>
        <div class="col-md-6 d-flex justify-content-start p-0">
            <strong class="border p-3" style="color: #012970" id="totalAsignadoSum">Total Asignado: 0.00</strong>
        </div>
    </div>
                        <br>
                        <table class="table datatable table-striped table-bordered table-sm table-responsive text-center" id="example">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Empleado</th>
                                    <th>Fecha</th>
                                    <th>Total Trabajado</th>
                                    <th>Total Asignado</th>
                                    <th>Notas</th>
                                    <th>Observaciones</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @foreach ($inconsistencias as $info)
                                <tr>
                                    <td> {{$i}} </td>
                                    <td> {{$info->empleado }} </td>
                                    <td> {{$info->fecha }} </td>
                                    <td> {{ number_format($info->total_trabajado, 2) }} </td>
                                    <td> {{$info->total_asignado }} </td>
                                    <td> {{$info->notas }} </td>
                                    <td> {{$info->observaciones }} </td>

                                    <td class="text-center">
                                        <a href="{{ route('nomina.edit', ['id_empleado' => $info->id_empleado, 'fecha' => $info->fecha]) }}" class="btn btn-outline-primary btn-sm" title="Editar" target="_blank" rel="noopener noreferrer">
                                            <i class="bi bi-box-arrow-in-up-right"></i></a>
                                    </td>
                                </tr>
                                @php $i++; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Table with stripped rows -->

    
</section>

<!-- Script completo -->
<script>
   $(document).ready(function () {
        var table = $('#example').DataTable();

        // Event listener to the two date filtering inputs to redraw on input
        $('#min, #max').change(function () {
            table.draw();
        });

        // Custom filtering function for date range
        $.fn.dataTable.ext.search.push(
            function (settings, data, dataIndex) {
                var minDate = $('#min').val();
                var maxDate = $('#max').val();
                var fecha = data[2]; // La fecha está en la columna 3 (índice 2)

                // Convertimos las fechas del filtro y la fecha de la tabla al formato Date
                var date = new Date(fecha); // Fecha en la tabla
                var startDate = minDate ? new Date(minDate) : null; // Fecha mínima
                var endDate = maxDate ? new Date(maxDate) : null; // Fecha máxima

                // Verificar si la fecha está dentro del rango
                if (
                    (startDate && date < startDate) || 
                    (endDate && date > endDate)
                ) {
                    return false; // No mostrar la fila si está fuera del rango
                }

                return true; // Mostrar la fila si está dentro del rango
            }
        );

        // Llamar al filtro cuando cambian los valores de fecha
        table.on('draw', function () {
            updateSums();
        });

        // Función para actualizar las sumas de las columnas
        function updateSums() {
            var totalTrabajadoSum = 0;
            var totalAsignadoSum = 0;

            // Iterar sobre las filas visibles
            table.rows({ filter: 'applied' }).every(function () {
                var data = this.data();
                totalTrabajadoSum += parseFloat(data[3].replace(/,/g, '')) || 0; // Columna Total Trabajado (Índice 3)
                totalAsignadoSum += parseFloat(data[4].replace(/,/g, '')) || 0;  // Columna Total Asignado (Índice 4)
            });

            // Actualizar los valores de las sumas en el DOM
            $('#totalTrabajadoSum').text('Total Trabajado: ' + totalTrabajadoSum.toFixed(2));
            $('#totalAsignadoSum').text('Total Asignado: ' + totalAsignadoSum.toFixed(2));
        }

        // Inicializamos las sumas al cargar la tabla
        updateSums();
    });
</script>

@endsection