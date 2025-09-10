@extends('layouts.admin-layout')

@section('title', 'SkaPeople - Contratos')

@section('content')
<!-- Titulo de pagina -->
<div class="pagetitle">
    <h1>Nuevo Tipo Contrato</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('/admin') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tipo-contratos.index') }}">Tipo Contrato</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tipo-contratos.create') }}">Nuevo Tipo Contrato</a></li>
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Crear Tipo de Contrato</h5>

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
                    <form action="{{ route('tipo-contratos.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <label for="nombre" class="col-sm-3 col-form-label">Tipo Contrato:</label>
                            <div class="col-sm-9">
                                <input type="text" id="nombre" name="nombre" class="form-control" value="{{ old('nombre') }}" placeholder="Ej: Termino Fijo" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- <label class="col-sm-2 col-form-label"></label> -->
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Crear Tipo de Contrato</button>
                            </div>
                        </div>
                    </form><!-- End General Form Elements -->
                </div>
            </div>
        </div>
    </div>
</section>

@endsection