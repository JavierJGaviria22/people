@extends('layouts.admin-layout')

@section('title', 'SkaPeople - Noticias')

@section('content')
<!-- Titulo de pagina -->
<div class="pagetitle">
    <h1>Editar Noticia</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('/admin') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('noticias.index') }}">Noticias</a></li>
            <li class="breadcrumb-item"><a href="">Editar Noticia</a></li>
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Editar Noticia</h5>

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

                    <!-- General Form Elements -->
                    <form action="{{route('noticias.update', $noticia->id_noticia)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label for="titulo" class="col-sm-2 col-form-label">Titulo:</label>
                            <div class="col-sm-10">
                                <input type="text" id="titulo" name="titulo" class="form-control" value="{{ $noticia->titulo }}" placeholder="Ej: Nuevo Integrante..." required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="contenido" class="col-sm-2 col-form-label">Contenido:</label>
                            <div class="col-sm-10">
                                <textarea id="contenido" name="contenido" class="form-control" style="height: 100px" placeholder="Ej: Le damos la bienvenida a...">{{$noticia->contenido}}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="datetime" class="col-sm-2 col-form-label">Inicio:</label>
                            <div class="col-sm-10">
                                <input type="text" id="datetime" name="fecha_inicio" class="form-control" value="{{$noticia->fecha_inicio}}" placeholder="2024-10-29" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="datetime2" class="col-sm-2 col-form-label">Fecha Fin</label>
                            <div class="col-sm-10">
                                <input type="text" id="datetime2" name="fecha_fin" class="form-control" value="{{ $noticia->fecha_fin }}" placeholder="2024-10-31" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- <label class="col-sm-2 col-form-label"></label> -->
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Actualizar Noticia</button>
                            </div>
                        </div>
                    </form><!-- End General Form Elements -->
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#datetime", {
            //enableTime: true, // Habilita la selección de tiempo
            dateFormat: "Y-m-d", // Formato de fecha y hora
            time_24hr: false, // Formato de 24 horas
            defaultDate: false, // Fecha por defecto
            minDate: "today" // No permite seleccionar fechas pasadas
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#datetime2", {
            //enableTime: true, // Habilita la selección de tiempo
            dateFormat: "Y-m-d", // Formato de fecha y hora
            time_24hr: false, // Formato de 24 horas
            defaultDate: false, // Fecha por defecto
            minDate: "today" // No permite seleccionar fechas pasadas
        });
    });
</script>
@endsection