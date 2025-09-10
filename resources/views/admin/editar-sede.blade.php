@extends('layouts.admin-layout')

@section('title', 'SkaPeople - Sedes')

@section('content')
<!-- Titulo de pagina -->
<div class="pagetitle">
    <h1>Editar Sede</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('/admin') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('sedes.index') }}">Sedes</a></li>
            <li class="breadcrumb-item"><a href="{{ route('sedes.edit', $sede->id_sede) }}">Editar Sede</a></li>
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Crear Sede</h5>

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
                    <form action="{{route('sedes.update', $sede->id_sede)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label for="nombre" class="col-sm-2 col-form-label">Nombre:</label>
                            <div class="col-sm-10">
                                <input type="text" id="nombre" name="nombre" class="form-control" value="{{ $sede->nombre }}" placeholder="Ej: Ska - USA" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="direccion" class="col-sm-2 col-form-label">Direccion:</label>
                            <div class="col-sm-10">
                                <input type="text" id="direccion" name="direccion" class="form-control" value="{{ $sede->direccion }}" placeholder="Ej: Carrera 29c..." required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="correo" class="col-sm-2 col-form-label">Correo:</label>
                            <div class="col-sm-10">
                                <input type="email" id="correo" name="correo" class="form-control" value="{{ $sede->correo }}" placeholder="Ej: correo@correo.com" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="telefono" class="col-sm-2 col-form-label">Telefono:</label>
                            <div class="col-sm-10">
                                <input type="text" id="telefono" name="telefono" class="form-control" value="{{ $sede->telefono }}" placeholder="Ej: 3125974103" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="zonah" class="col-sm-2 col-form-label">zonah:</label>
                            <div class="col-sm-10">
                                <select id="zonah" name="zonah" class="form-select" aria-label="Default select example" required>
                                    <option value="" {{ old('zonah') ? '' : 'selected' }} disabled>Seleccionar</option>
                                    @foreach($zonas as $zona)
                                    <option value="{{ $zona->id_zona_horaria }}" {{ $zona->id_zona_horaria == $sede->id_zona_horaria ? 'selected' : '' }}>
                                        {{ $zona->zona_horaria }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- <label class="col-sm-2 col-form-label"></label> -->
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Actualizar Sede</button>
                            </div>
                        </div>
                    </form><!-- End General Form Elements -->
                </div>
            </div>
        </div>
    </div>
</section>
   
@endsection