@extends('layouts.admin-layout')

@section('title', 'SkaPeople - Contratos')

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
    <h1>Contratos</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('/') }}"></a>Inicio</li>
            <li class="breadcrumb-item">Contratos</li>
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Contratos</h5>
                    <p>En la siguiente tabla encontrará todos los Contratos de {{ $info_admins->empresa }}.</p>
                    <div class="mb-3 text-end">
                        <a href="{{route('contratos.create')}}" class="btn btn-primary btn-sm" title="Nuevo">
                            <i class="bi bi-plus-circle"></i> Nuevo Contrato
                        </a>
                    </div>
                    <!-- Table with stripped rows -->
                    <div class="table-responsive">
                        <table class="table datatable table-striped table-bordered table-sm table-responsive">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Empleado</th>
                                    <th>Tipo</th>
                                    <th>Cargo</th>
                                    <th>Salario</th>
                                    <th>Editar</th>
                                    <th>Borrar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contratos as $contrato)
                                <tr>
                                    <td> {{$contrato->id_contrato }} </td>
                                    <td> {{$contrato->empleado }} </td>
                                    <td> {{$contrato->tipo }} </td>
                                    <td> {{$contrato->cargo }} </td>
                                    <td> {{$contrato->salario }} </td>
                                    <td class="text-center">
                                        <a href="{{route('contratos.edit', $contrato->id_contrato)}}" class="btn btn-outline-primary btn-sm" title="Editar">
                                            <i class="bi bi-pencil"></i></a>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{route('contratos.show', $contrato->id_contrato)}}" class="btn btn-outline-danger btn-sm" title="Eliminar"
                                            onclick="return confirmDelete(event, this);">
                                            <i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
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
            text: "No podrás recuperar este contrato.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, Eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = element.href; // Redirigir a la URL del enlace
            }
        });
    }
</script>

@endsection