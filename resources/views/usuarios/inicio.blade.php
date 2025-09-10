@extends('layouts.layout')

@section('title', 'SkaPeople - Dashboard')

@section('content')

<!-- Titulo de pagina -->
<div class="pagetitle">
  <h1>Dashboard</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('/') }}"></a>Inicio</li>
      <!-- <li class="breadcrumb-item">Inicio</li> -->
    </ol>
  </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section dashboard">
  <div class="row">

    <!-- Left side columns -->
    <div class="col-lg-8">
      <div class="row">

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-6">
          <div class="card info-card sales-card">



            <div class="card-body">
              <h5 class="card-title">PTO Disponible<span> | Hoy</span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-tsunami"></i>
                </div>
                <div class="ps-3">
                  <h6>{{ $info_empleados->vacaciones_disponibles; }} {{$info_empleados->formato;}}</h6>
                  <span class="text-primary small pt-1 fw-bold">{{ $info_empleados->vacaciones_acumuladas; }}</span>
                  <span class="text-muted small pt-2 ps-1">acumulados</span>
                </div>
              </div>
            </div>

          </div>
        </div><!-- End Sales Card -->

        <!-- Revenue Card -->
        <div class="col-xxl-4 col-md-6">
          <div class="card info-card revenue-card">



            <div class="card-body">
              <h5 class="card-title">Permisos Aprobados <span> | Este Mes</span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-clipboard-check"></i>
                </div>
                <div class="ps-3">
                  <h6>{{ $permisos_aprobados }}</h6>
                  <span class="text-success small pt-1 fw-bold">{{ $permisos > 0 ? round(($permisos_aprobados * 100 / $permisos),1) : 0 }}%</span> <span
                    class="text-muted small pt-2 ps-1">aprobado</span>

                </div>
              </div>
            </div>

          </div>
        </div><!-- End Revenue Card -->

        <!-- Customers Card -->
        <div class="col-xxl-4 col-xl-12">

          <div class="card info-card customers-card">

            <div class="card-body">
              <h5 class="card-title">Permisos Pendientes <span> | Este Mes</span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-hourglass-split"></i>
                </div>
                <div class="ps-3">
                  <h6>{{ $permisos_pendientes }}</h6>
                  <span class="text-danger small pt-1 fw-bold">{{ $permisos > 0 ? round(($permisos_pendientes * 100 / $permisos),1) : 0 }}%</span> <span
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

      <!-- News & Updates Traffic -->
      <div class="card">

        <div class="card-body pb-0">
          <h5 class="card-title">Novedades &amp; Noticias <span> | Hoy</span></h5>

          <!--<div class="news ">
            <div class="post-item clearfix ml-0">
              <img src="assets/img/felizcumpleaños.png" alt="">
              <h4><a href="#">¡Feliz cumpleaños, Aleyda Murillo!</a></h4>
              <p style="margin-left: 0px;">Desde todo el equipo, queremos desearte un día muy especial lleno de alegría y buenos momentos. Apreciamos mucho tu dedicación y el compromiso que demuestras cada día en tu trabajo. Que este nuevo año de vida esté lleno de éxitos personales y profesionales.</p>
            </div>
            
          </div>
        <hr>-->
          @foreach ($noticias as $noticia)
          <div class="news">

            <div class="post-item clearfix ml-0">
              <!-- <img src="assets/img/felizcumpleaños.png" alt=""> -->
              <h4><a href="#">{{ $noticia->titulo }}</a></h4>
              <p style="margin-left: 0px;">{!! nl2br(e($noticia->contenido)) !!}</p>
            </div>
  
          </div><!-- End sidebar recent posts-->
          @endforeach
        </div>
      </div><!-- End News & Updates -->

    </div><!-- End Right side columns -->

  </div>
  
  <!-- Modal para cambio de password -->
  <div class="modal fade" id="modalPassword" tabindex="-1" aria-labelledby="modalPasswordLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{route('newPass')}}" method="post">
          @csrf
          <div class="modal-header">
            <h4 class="modal-title font-weight-bold" id="modalPasswordLabel">Cambiar Contraseña</h4>
          </div>
          <div class="modal-body">
            <label class="form-check-label pb-3" for=""><strong>Nueva Contraseña:</strong>

              <input class="form-control" type="password" name="newPass" required minlength="6">

            </label>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success" id="--guardarButton">Cambiar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Fin de modal cambio de password -->
</section>

@if($pass === '$2a$04$0O0EPbbB338aEhPk9iIIZeJGfvSLn2eDTC4tHENzFIWzucno1Gg0a')
<script>
  $(document).ready(function() {
      
    $('#modalPassword').modal({
      backdrop: 'static',
      keyboard: false
    }).modal('show');

    $('#guardarButton').on('click', function() {
      $('#modalPassword').modal('hide');
      
    });
  });
</script>
@endif
@endsection