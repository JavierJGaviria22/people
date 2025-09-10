@extends('layouts.admin-layout')

@section('title', 'SkaPeople - Departamentos')

@section('content')
<!-- Titulo de pagina -->
<div class="pagetitle">
    <h1>Editar Departamento</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('/admin') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('departamentos.index') }}">Departamentos</a></li>
            <li class="breadcrumb-item"><a href="{{ route('departamentos.create') }}">Editar Departamento</a></li>
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Editar Departamento</h5>

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
                    <form action="{{route('departamentos.update' , $departamento->id_departamento)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label for="nombre" class="col-sm-2 col-form-label">Nombre:</label>
                            <div class="col-sm-10">
                                <input type="text" id="nombre" name="nombre" class="form-control" value="{{ $departamento->nombre }}" placeholder="Ej: Sistemas" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="empleado" class="col-sm-2 col-form-label">Lider:</label>
                            <div class="col-sm-10">
                                <select id="empleado" name="empleado" class="form-select" aria-label="Default select example" required>
                                    <option value="" {{ old('empleado') ? '' : 'selected' }} disabled>Seleccionar</option>
                                    @foreach($empleados as $empleado)
                                    <option value="{{ $empleado->id_empleado }}" {{ $departamento->lider == $empleado->id_empleado ? 'selected' : '' }}>
                                        {{ $empleado->nombre }} {{ $empleado->apellido }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- <label class="col-sm-2 col-form-label"></label> -->
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Actualizar Departamento</button>
                            </div>
                        </div>
                    </form><!-- End General Form Elements -->
                </div>
            </div>
        </div>
    </div>
</section>

@endsection