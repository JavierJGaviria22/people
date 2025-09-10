@extends('layouts.admin-layout')

@section('title', 'SkaPeople - Festivos')

@section('content')
<!-- Titulo de pagina -->
<div class="pagetitle">
    <h1>Nuevo Festivo</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('/admin') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('festivos.index') }}">Festivos</a></li>
            <li class="breadcrumb-item"><a href="{{ route('festivos.create') }}">Nuevo Festivo</a></li>
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Crear Festivo</h5>

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

                    @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    <!-- General Form Elements -->
                    <form action="{{route('festivos.store')}}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <label for="nombre" class="col-sm-2 col-form-label">Nombre:</label>
                            <div class="col-sm-10">
                                <input type="text" id="nombre" name="nombre" class="form-control" value="{{ old('nombre') }}" placeholder="Ej: Año Nuevo" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="datetime" class="col-sm-2 col-form-label">Fecha:</label>
                            <div class="col-sm-10">
                                <input type="text" id="datetime" name="fecha" class="form-control" value="{{ old('fecha_fin') }}" placeholder="" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- <label class="col-sm-2 col-form-label"></label> -->
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Agregar Festivo</button>
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
            enableTime: false, // Habilita la selección de tiempo
            dateFormat: "Y-m-d", // Formato de fecha y hora
           // time_24hr: false, // Formato de 24 horas
            defaultDate: false, // Fecha por defecto
            //minDate: "today" // No permite seleccionar fechas pasadas
        });
    });
</script>

@endsection