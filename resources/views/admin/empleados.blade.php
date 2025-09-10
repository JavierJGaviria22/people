@extends('layouts.admin-layout')

@section('title', 'SkaPeople - Empleados')

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
    <h1>Empleados</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('/') }}"></a>Inicio</li>
            <li class="breadcrumb-item">Empleados</li>
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Empleados</h5>
                    <p>En la siguiente tabla encontrará todos los Empleados de {{ $info_admins->empresa }}.</p>
                    <div class="mb-3 text-end">
                        <a href="{{route('nuevo-empleado')}}" class="btn btn-primary btn-sm" title="Nuevo">
                            <i class="bi bi-plus-circle"></i> Nuevo Empleado
                        </a>
                    </div>
                    <!-- Table with stripped rows -->
                    <div class="table-responsive">
                        <table class="table datatable table-striped table-bordered table-sm table-responsive">
                            <thead>
                                <tr>
                                    <th>Sede</th>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Genero</th>
                                    <th>Correo</th>
                                    <th>Celular</th>
                                    <th>Cargo</th>
                                    <th>Dpto</th>
                                    <th>Acciones</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($info_empleados as $empleado)
                                <tr>
                                    <td> {{$empleado->sede }} </td>
                                    <td> {{$empleado->cedula }} </td>
                                    <td> {{$empleado->nombre }} {{$empleado->apellido}}</td>
                                    <td> {{$empleado->genero }} </td>
                                    <td> {{$empleado->correo }} </td>
                                    <td> {{$empleado->celular }} </td>
                                    <td> {{$empleado->cargo }} </td>
                                    <td> {{$empleado->departamento }} </td>
                                    <td class="text-center">
                                        <a href="" class="btn btn-outline-success btn-sm" title="Ver">
                                            <i class="bi bi-eye"></i></a>
                                        
                                        <a href="{{ route('editar-empleado', $empleado->id_empleado) }}" class="btn btn-outline-primary btn-sm" title="Editar">
                                            <i class="bi bi-pencil"></i></a>
                                    
                                        <a href="{{ route('eliminar-empleado', $empleado->id_empleado) }}" class="btn btn-outline-danger btn-sm" title="Eliminar"
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