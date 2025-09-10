@extends('layouts.admin-layout')

@section('title', 'SkaPeople - Noticias')

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
    <h1>Noticias</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('/') }}"></a>Inicio</li>
            <li class="breadcrumb-item">Noticias</li>
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Noticias</h5>
                    <p>En la siguiente tabla encontrará todos las Noticias de {{ $info_admins->empresa }}.</p>
                    <div class="mb-3 text-end">
                        <a href="{{route('noticias.create')}}" class="btn btn-primary btn-sm" title="Nuevo">
                            <i class="bi bi-plus-circle"></i> Nueva Noticia
                        </a>
                    </div>
                    <!-- Table with stripped rows -->
                    <div class="table-responsive">
                        <table class="table datatable table-striped table-bordered table-sm table-responsive">
                            <thead>
                                <tr>
                                    <th>Titulo</th>
                                    <th>Contenido</th>
                                    <th>Imagen</th>
                                    <th>Inicio</th>
                                    <th>Fin</th>
                                    <th>Editar</th>
                                    <th>Borrar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($noticias as $noticia)
                                <tr>
                                    <td> {{$noticia->titulo }} </td>
                                    <td> {{$noticia->contenido }} </td>
                                    <td> {{$noticia->imagen }} </td>
                                    <td> {{$noticia->fecha_inicio }} </td>
                                    <td> {{$noticia->fecha_fin }} </td>
                                    <td class="text-center">
                                        <a href="{{ route('noticias.edit', $noticia->id_noticia) }}" class="btn btn-outline-primary btn-sm" title="Editar">
                                            <i class="bi bi-pencil"></i></a>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('noticias.show', $noticia->id_noticia) }}" class="btn btn-outline-danger btn-sm" title="Eliminar"
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
            text: "No podrás recuperar esta noticia.",
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