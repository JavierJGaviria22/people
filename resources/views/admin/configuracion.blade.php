@extends('layouts.admin-layout')

@section('title', 'SkaPeople - Config')

@section('content')

<!-- Titulo de pagina -->
<div class="pagetitle">
    <h1>Configuración</h1>
    <nav>
        <ol class="breadcrumb">
            <a href="{{ route('/admin') }}">
                <li class="breadcrumb-item">Inicio</li>
            </a>
            <!-- <li class="breadcrumb-item">Inicio</li> -->
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section">
    <div class="row align-items-top">

        <div class="col-lg-3">
            <!-- Card with an image on top -->
            <a href="{{route('departamentos.index')}}">
                <div class="card">
                    <div class="d-flex justify-content-center pt-3">
                        <img style="width: 90px;" src="{{ asset('assets/img/departamentos.png')}}" class="card-img-top text-center" alt="..." onmouseover="this.style.transform='scale(1.1)'"
                            onmouseout="this.style.transform='scale(1)'">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-center">Departamentos</h5>
                        <p class="card-text"></p>
                    </div>
                </div><!-- End Card with an image on top -->
            </a>
        </div>

        <div class="col-lg-3">
            <!-- Card with an image on top -->
            <a href="{{route('festivos.index')}}">
                <div class="card">
                    <div class="d-flex justify-content-center pt-3">
                        <img style="width: 90px;" src="{{ asset('assets/img/festivos.png')}}" class="card-img-top text-center" alt="..." onmouseover="this.style.transform='scale(1.1)'"
                            onmouseout="this.style.transform='scale(1)'">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-center">Festivos</h5>
                        <p class="card-text"></p>
                    </div>
                </div><!-- End Card with an image on top -->
            </a>
        </div>

        <div class="col-lg-3">
            <!-- Card with an image on top -->
            <div class="card">
                <div class="d-flex justify-content-center pt-3">
                    <img style="width: 90px;" src="{{ asset('assets/img/horarios.jpg')}}" class="card-img-top text-center" alt="..." onmouseover="this.style.transform='scale(1.1)'"
                        onmouseout="this.style.transform='scale(1)'">
                </div>
                <div class="card-body">
                    <h5 class="card-title text-center">Horarios</h5>
                    <p class="card-text"></p>
                </div>
            </div><!-- End Card with an image on top -->
        </div>

        <div class="col-lg-3">
            <!-- Card with an image on top -->
            <a href="{{route('sedes.index')}}">
                <div class="card">
                    <div class="d-flex justify-content-center pt-3">
                        <img style="width: 90px;" src="{{ asset('assets/img/sedes.png')}}" class="card-img-top text-center" alt="..." onmouseover="this.style.transform='scale(1.1)'"
                            onmouseout="this.style.transform='scale(1)'">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-center">Sedes</h5>
                        <p class="card-text"></p>
                    </div>
                </div><!-- End Card with an image on top -->
            </a>
        </div>

        <div class="col-lg-3">
            <!-- Card with an image on top -->
            <a href="{{route('tipo-contratos.index')}}">
                <div class="card">
                    <div class="d-flex justify-content-center pt-3">
                        <img style="width: 90px;" src="{{ asset('assets/img/contrato.png')}}" class="card-img-top text-center" alt="..." onmouseover="this.style.transform='scale(1.1)'"
                            onmouseout="this.style.transform='scale(1)'">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-center">Tipos de Contratos</h5>
                        <p class="card-text"></p>
                    </div>
                </div><!-- End Card with an image on top -->
            </a>
        </div>

        <div class="col-lg-3">
            <!-- Card with an image on top -->
            <a href="{{route('tipo-permisos.index')}}">
                <div class="card">
                    <div class="d-flex justify-content-center pt-3">
                        <img style="width: 90px;" src="{{ asset('assets/img/tpermiso.png')}}" class="card-img-top text-center" alt="..." onmouseover="this.style.transform='scale(1.1)'"
                            onmouseout="this.style.transform='scale(1)'">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-center">Tipos de Permisos</h5>
                        <p class="card-text"></p>
                    </div>
                </div><!-- End Card with an image on top -->
            </a>
        </div>

        <div class="col-lg-3">
            <!-- Card with an image on top -->
            <a href="{{route('vacaciones.index')}}">
                <div class="card">
                    <div class="d-flex justify-content-center pt-3">
                        <img style="width: 90px;" src="{{ asset('assets/img/vacaciones.png')}}" class="card-img-top text-center" alt="..." onmouseover="this.style.transform='scale(1.1)'"
                            onmouseout="this.style.transform='scale(1)'">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-center">Paid Time Off</h5>
                        <p class="card-text"></p>
                    </div>
                </div><!-- End Card with an image on top -->
            </a>
        </div>

    </div>
</section>

@endsection