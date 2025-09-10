@extends('layouts.admin-layout')

@section('title', 'People - Auditoria')

@section('content')

<style>
    td {
        font-size: 15px;
    }

    label {
        padding: 0 0 17px 0;
    }
</style>

<!-- Titulo de pagina -->
<div class="pagetitle">
    <h1>Informes de PTO</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('/') }}"></a>Inicio</li>
            <li class="breadcrumb-item">Reportes e informes</li>
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Registro de PTO Acumulados por horas</h5>
                    <p>Consulta aquí los registros de PTO acumulado por horas de cada empleado durante el año en curso.</p>
                    
                    <!-- Table with stripped rows -->
                    <div class="table-responsive">
                        <div class="tb-filtro d-flex justify-content-end">
                            
                        </div>
                        <br>
                        <table class="table datatable table-striped table-bordered table-sm table-responsive text-center" id="example">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Empleado</th>
                                    <th>PTO Acumulado</th>
                                    <th>PTO Utilizado</th>
                                    <th>PTO Disponible</th>
                                    <th>Detalles</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @foreach ($pto as $p)
                                <tr>
                                    <td> {{$i}} </td>
                                    <td> {{$p->nombre}} {{$p->apellido}} </td>
                                    <td> {{$p->vacaciones_acumuladas }}  </td>
                                    <td> {{$p->vacaciones_tomadas }} </td>
                                    <td> {{$p->vacaciones_disponibles}}</td>
                                    <td class="text-center">
                                        <a href="{{route('detalle-pto' , ['id_empleado' => $p->id_empleado])}}" class="btn btn-outline-primary btn-sm" title="Ver" target="_blank" rel="noopener noreferrer">
                                            <i class="bi bi-eye"></i></a>
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

<script>
    $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
            var minDate = $('#min').val();
            var maxDate = $('#max').val();
            var fecha = data[2];

            var date = new Date(fecha);
            var startDate = minDate ? new Date(minDate) : null;
            var endDate = maxDate ? new Date(maxDate) : null;

            if (
                (startDate && date < startDate) || 
                (endDate && date > endDate)
            ) {
                return false;
            }

            return true;
        }
    );

    $(document).ready(function () {
        var table = $('#example').DataTable();

        $('#min, #max').change(function () {
            table.draw();
        });
    });
</script>

@endsection