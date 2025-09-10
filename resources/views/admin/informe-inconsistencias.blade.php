@extends('layouts.admin-layout')

@section('title', 'SkaPeople - Incosistencias')

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
    <h1>Inconsistencias</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('/') }}"></a>Inicio</li>
            <li class="breadcrumb-item">Inconsistencias</li>
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Inconsistencias Encontradas</h5>
                    <p>Revisa la posible causa de estas inconsistencias, ten en cuenta las notas de los empleados.</p>
                    
                    <!-- Table with stripped rows -->
                    <div class="table-responsive">
                        <table class="table datatable table-striped table-bordered table-sm table-responsive text-center">
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
<script>
    function confirmDelete(event, element) {
        event.preventDefault(); // Evitar que el enlace se ejecute inmediatamente

        Swal.fire({
            title: '¿Estás seguro?',
            text: "Podrás reactivar este empleado en cualquier momento.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, desactivar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = element.href; // Redirigir a la URL del enlace
            }
        });
    }
</script>

@endsection