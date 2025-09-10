@extends('layouts.admin-layout')

@section('title', 'SkaPeople - Tipo permiso')

@section('content')
<!-- Titulo de pagina -->
<div class="pagetitle">
    <h1>Editar Tipo permiso</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('/admin') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tipo-permisos.index') }}">Tipo permisos</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tipo-permisos.edit', $tipo->id_tipo_permiso) }}">Editar Tipo permiso</a></li>
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Editar Tipo permiso</h5>

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
                    <form action="{{route('tipo-permisos.update', $tipo->id_tipo_permiso)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label for="nombre" class="col-sm-3 col-form-label">Permiso:</label>
                            <div class="col-sm-9">
                                <input type="text" id="nombre" name="nombre" class="form-control" value="{{ $tipo->permiso }}" placeholder="" required>
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
                                <button type="submit" class="btn btn-primary">Actualizar Tipo permiso</button>
                            </div>
                        </div>
                    </form><!-- End General Form Elements -->
                </div>
            </div>
        </div>
    </div>
</section>

@endsection