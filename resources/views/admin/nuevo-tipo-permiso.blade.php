@extends('layouts.admin-layout')

@section('title', 'SkaPeople - permisos')

@section('content')
<!-- Titulo de pagina -->
<div class="pagetitle">
    <h1>Nuevo Tipo Permiso</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('/admin') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tipo-permisos.index') }}">Tipo permiso</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tipo-permisos.create') }}">Nuevo Tipo permiso</a></li>
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Crear Tipo de permiso</h5>
                    <div class="p-2 mb-3" style="background-color: #D9E4E5; border-radius: 0.7rem;">
                        <p>Los permisos de tipo PTO (Paid Time Off) serán los encargados de restar el saldo acumulado de tiempo libre (PTO) de los empleados cuando se tomen días de descanso o vacaciones.</p>
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

                    <!-- General Form Elements -->
                    <form action="{{ route('tipo-permisos.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <label for="nombre" class="col-sm-3 col-form-label">Nombre del Permiso:</label>
                            <div class="col-sm-9">
                                <input type="text" id="nombre" name="nombre" class="form-control" value="{{ old('nombre') }}" placeholder="Ej: Cita Medica" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tipoPermiso" class="col-sm-3 col-form-label">Tipo:</label>
                            <div class="col-sm-9">
                                <select id="" name="tipoPermiso" class="form-select" aria-label="Default select example" required>
                                    <option value="" selected disabled>Seleccionar</option>
                                    <option value="Obligatorio" {{ old('tipoPermiso') == 'Obligatorio' ? 'selected' : '' }}>Obligatorio</option>
                                    <option value="Personal" {{ old('tipoPermiso') == 'Personal' ? 'selected' : '' }}>Personal</option>
                                    <option value="PTO" {{ old('tipoPermiso') == 'PTO' ? 'selected' : '' }}>PTO</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- <label class="col-sm-2 col-form-label"></label> -->
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Crear Tipo de permiso</button>
                            </div>
                        </div>
                    </form><!-- End General Form Elements -->
                </div>
            </div>
        </div>
    </div>
</section>

@endsection