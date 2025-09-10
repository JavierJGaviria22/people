@extends('layouts.admin-layout')

@section('title', 'SkaPeople - Contratos')

@section('content')

<style>
    td {
        font-size: 13px;
    }
</style>

<!-- Titulo de pagina -->
<div class="pagetitle">
    <h1>Contratos</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('/admin') }}">Inicio</li></a>
            <li class="breadcrumb-item">Contratos por vencer</li>
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Contratos por vencer</h5>
                    <p>En la siguiente tabla encontrará todos los Contratos que expiran en mes {{ $info_admins->empresa }}.</p>
                    <div class="mb-3 text-end">
                        <a href="{{route('contratos.create')}}" class="btn btn-primary btn-sm" title="Nuevo">
                            <i class="bi bi-plus-circle"></i> Boton
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
                                    <th>Renovar</th>
                                    <th>Terminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contratosPorVencer as $contrato)
                                <tr>
                                    <td> {{$contrato->id_contrato }} </td>
                                    <td> {{$contrato->nombre }} </td>
                                    <td> {{$contrato->tipo_contrato }} </td>
                                    <td> {{$contrato->cargo }} </td>
                                    <td> {{$contrato->salario }} </td>
                                    <td class="text-center">
                                        <a href="{{route('contratos.edit', $contrato->id_contrato)}}" class="btn btn-outline-success btn-sm" title="Renovar" data-bs-toggle="modal" data-bs-target="#actuarModal" onclick="setPermisoId('')">
                                            <i class="bi bi-file-earmark-text"></i></a>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{route('contratos.show', $contrato->id_contrato)}}" class="btn btn-outline-warning btn-sm" title="Terminar"
                                            data-bs-toggle="modal" data-bs-target="#actuarModal" onclick="setPermisoId('')">
                                            <i class="bi bi-file-earmark-text"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Inicio Modal -->
                        <div class="modal fade" id="actuarModal" tabindex="-1" aria-labelledby="actuarModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title font-weight-bold" id="actuarModalLabel">RENOVACION DE CONTRATO</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p id="empleadoNombre"></p> <!-- Lugar para el nombre del empleado -->
                                        <p id="tipoPermiso"></p> <!-- Lugar para el tipo de permiso -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="remuneradoCheck">
                                            <label class="form-check-label" for="remuneradoCheck">Tiempo de renovación</label>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success" onclick="aprobarPermiso('aprobar')">Renovar</button>
                                        <button type="button" class="btn btn-danger" onclick="aprobarPermiso('declinar')" data-bs-dismiss="modal">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fin Modal -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Table with stripped rows -->
</section>
<script>
    // Variable global para almacenar el ID del permiso
    window.currentPermisoId = null;

    // Función para establecer el ID del permiso
    function setPermisoId(id, nombreEmpleado, tipoPermiso) {
        window.currentPermisoId = id; // Almacena el ID en la variable global

        // Actualiza el modal con la información del empleado y tipo de permiso
        document.getElementById('empleadoNombre').innerHTML = `<strong>Empleado:</strong> ${nombreEmpleado}`;
        document.getElementById('tipoPermiso').innerHTML = `<strong>Tipo de Permiso:</strong> ${tipoPermiso}`;
    }

    function aprobarPermiso(accion) {
        const remunerado = document.getElementById('remuneradoCheck').checked ? 1 : 0;
        const idPermiso = window.currentPermisoId; // Recupera el ID del permiso

        fetch(`actuar-permiso/${idPermiso}/procesar`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    accion: accion,
                    remunerado: remunerado
                })
            }).then(response => response.json()) // Convertir la respuesta en JSON
            .then(data => {
                $('#actuarModal').modal('hide');
                alert(data.message); // Mostrar el mensaje de éxito o error
                location.reload(); // Recargar la vista
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error de conexión.'); // Mensaje de error
            });
    }
</script>

@endsection