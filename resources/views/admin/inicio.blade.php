@extends('layouts.admin-layout')

@section('title', 'SkaPeople - Dashboard')

@section('content')

<!-- Titulo de pagina -->
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
            <a href="{{ route('/admin') }}">
                <li class="breadcrumb-item">Inicio</li>
            </a>
            <!-- <li class="breadcrumb-item">Inicio</li> -->
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section dashboard">
    @if($configurada == 0)
    <script>
       Swal.fire({
            title: 'Alerta',
            text: "Recuerda configurar tu empresa",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ir a configurar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{route('config')}}"; 
            }
        });
    </script>
    @endif

    <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
            <div class="row">

                <!-- Sales Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Vacaciones Aprobadas<span> | Este mes</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-tsunami"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$vacacionesMes}}</h6>
                                    <span class="text-primary small pt-1 fw-bold">{{$vacacionesMes}}</span>
                                    <span class="text-muted small pt-2 ps-1">Totales</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->

                <!-- Revenue Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">Empleados Activos <span> | Hoy</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-clipboard-check"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$empleadosActivos}}</h6>
                                    <span class="text-success small pt-1 fw-bold">{{$empleadostotal}}</span> <span
                                        class="text-muted small pt-2 ps-1">Totales</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Revenue Card -->

                <!-- Customers Card -->
                <div class="col-xxl-4 col-xl-12">
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <a href="{{route('contratos-por-vencer')}}">
                                <h5 class="card-title">Contratos por Vencer <span> | Este Mes</span></h5>
                            </a>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-hourglass-split"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$contratosPorVencer}}</h6>
                                    <span class="text-danger small pt-1 fw-bold">?</span> <span
                                        class="text-muted small pt-2 ps-1">pendiente</span>
                                </div>
                            </div>

                        </div>
                    </div>

                </div><!-- End Customers Card -->


                <!-- Recent Sales -->
                <div class="col-12">
                    <div class="card recent-sales overflow-auto">

                        <div class="card-body">
                            <h5 class="card-title">Proximos cumpleaños <span> | Este Mes</span></h5>

                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Empleado</th>
                                        <th scope="col">Mes</th>
                                        <th scope="col">Día</th>
                                        <th scope="col">Departamento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($cumpleaños as $cumple)
                                    <tr>
                                        <th scope="row"><a href="#">#{{ $i }}</a></th>
                                        <td>{{ $cumple->nombre }} {{$cumple->apellido}}</td>
                                        <!-- Extraer mes de una fecha con Carbon de Laravel -->
                                        <td><a href="#" class="text-primary">{{ \Carbon\Carbon::parse($cumple->fecha_nacimiento)->locale('es')->translatedFormat('F') }}</a></td>
                                        <td>{{ \Carbon\Carbon::parse($cumple->fecha_nacimiento)->locale('es')->day }}</td>
                                        <td><span class="badge bg-primary">{{ $cumple->departamento }}</span></td>
                                    </tr>
                                    @php
                                    $i++;
                                    @endphp
                                    @endforeach
                                </tbody>
                            </table>

                        </div>

                    </div>
                </div><!-- End Recent Sales -->

            </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">
            <!-- Recent Activity -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Actividades de Bienestar <span>| Hoy</span></h5>

                    <div class="activity">

                        <div class="activity-item d-flex">
                            <div class="activite-label">32 min</div>
                            <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                            <div class="activity-content">
                                Quia quae rerum <a href="#" class="fw-bold text-dark">explicabo officiis</a> beatae
                            </div>
                        </div><!-- End activity item-->

                        <div class="activity-item d-flex">
                            <div class="activite-label">56 min</div>
                            <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                            <div class="activity-content">
                                Voluptatem blanditiis blanditiis eveniet
                            </div>
                        </div><!-- End activity item-->

                        <div class="activity-item d-flex">
                            <div class="activite-label">2 hrs</div>
                            <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                            <div class="activity-content">
                                Voluptates corrupti molestias voluptatem
                            </div>
                        </div><!-- End activity item-->

                        <div class="activity-item d-flex">
                            <div class="activite-label">1 day</div>
                            <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
                            <div class="activity-content">
                                Tempore autem saepe <a href="#" class="fw-bold text-dark">occaecati voluptatem</a> tempore
                            </div>
                        </div><!-- End activity item-->

                        <div class="activity-item d-flex">
                            <div class="activite-label">2 days</div>
                            <i class='bi bi-circle-fill activity-badge text-warning align-self-start'></i>
                            <div class="activity-content">
                                Est sit eum reiciendis exercitationem
                            </div>
                        </div><!-- End activity item-->

                        <div class="activity-item d-flex">
                            <div class="activite-label">4 weeks</div>
                            <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
                            <div class="activity-content">
                                Dicta dolorem harum nulla eius. Ut quidem quidem sit quas
                            </div>
                        </div><!-- End activity item-->

                    </div>

                </div>
            </div><!-- End Recent Activity -->
            <div class="card">

                <div class="card-body pb-0">
                    <h5 class="card-title">Novedades &amp; Noticias <span> | Hoy</span></h5>

                    @foreach ($noticias as $noticia)
                    <div class="news">
                        <div class="post-item clearfix">
                            <img src="assets/img/news-1.jpg" alt="">
                            <h4><a href="#">{{ $noticia->titulo }}</a></h4>
                            <p>{{ $noticia->contenido }}</p>
                        </div>
                        @endforeach

                    </div><!-- End sidebar recent posts-->

                </div>
            </div><!-- End News & Updates -->
        </div><!-- End Right side columns -->

    </div>
</section>
@endsection