@extends('layouts.layout')

@section('title', 'SkaPeople - Permisos')

@section('content')
<!-- Titulo de pagina -->
<div class="pagetitle">
  <h1>Permisos</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('/') }}"></a>Inicio</li>
      <li class="breadcrumb-item">Mis Permisos</li>
    </ol>
  </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section dashboard">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Mis Permisos</h5>
          <p>En la siguiente tabla encontrará todos los permisos que ha solicitado y el estado actual de este.</p>
          <div class="mb-3 text-end">
            <a href="{{route('nuevo-permiso')}}" class="btn btn-primary btn-sm" title="Nuevo">
              <i class="bi bi-plus-circle"></i> Nuevo Permiso
            </a>
          </div>

          @if (session('success'))
          <div class="alert alert-success">
            {{ session('success') }}
          </div>
          @endif

          <!-- Table with stripped rows -->
          <div class="table-responsive">
            <table class="table table-bordered table-sm table-hover">
              <thead>
                <tr>
                  <th class="text-center">Permiso</th>
                  <th class="text-center" style="min-width: 130px;">Fecha Solicitud</th>
                  <th class="text-center" style="min-width: 104px;" data-type="date" data-format="YYYY/DD/MM">Fecha Inicio</th>
                  <th class="text-center" data-type="date" data-format="YYYY/DD/MM">Fecha Fin</th>
                  <th class="text-center">Días</th>
                  <th class="text-center">Horas</th>
                  <th class="text-center">Minutos</th>
                  <th class="text-center">Estado</th>
                  <th class="text-center">Editar</th>
                  <th class="text-center">Borrar</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($info_permisos as $permiso)
                <tr>
                  <td class="text-center"> {{$permiso->permiso }} </td>
                  <td class="text-center"> {{ \Carbon\Carbon::parse($permiso->fecha_solicitud)->format('Y-m-d h:i A') }} </td>
                  <td class="text-center"> {{ \Carbon\Carbon::parse($permiso->fecha_inicio)->format('Y-m-d h:i A') }} </td>
                  <td class="text-center"> {{ \Carbon\Carbon::parse($permiso->fecha_fin)->format('Y-m-d h:i A') }} </td>
                  <td class="text-center"> {{$permiso->dias }} </td>
                  <td class="text-center"> {{$permiso->horas }} </td>
                  <td class="text-center"> {{$permiso->minutos }} </td>
                  <td class="text-center @if($permiso->estado === 'Aprobado') table-success 
                           @elseif($permiso->estado === 'Declinado') table-danger 
                           @else table-warning 
                           @endif"> {{$permiso->estado }}
                  </td>
                  <td class="text-center">@if($permiso->estado === 'Pendiente')
                    <a href="{{ route('editar-permiso', $permiso->id_permiso) }}" class="btn btn-outline-primary btn-sm" title="Editar">
                      <i class="bi bi-pencil"></i>
                      @else -
                      @endif
                    </a>
                  </td>
                  <td class="text-center">@if($permiso->estado === 'Pendiente')
                    <a href="{{ route('eliminar-permiso', $permiso->id_permiso) }}" class="btn btn-outline-danger btn-sm" title="Eliminar"
                      onclick="return confirmDelete(event, this);">
                      <i class="bi bi-trash"></i>
                      @else -
                      @endif
                    </a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Table with stripped rows -->
</section>
<!--Script JS para la alerta de confirmacion de eliminacion de permiso -->
<script>
  function confirmDelete(event, element) {
    event.preventDefault(); // Evitar que el enlace se ejecute inmediatamente

    Swal.fire({
      title: '¿Estás seguro?',
      text: "Una vez eliminado, no podrás recuperar este permiso.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Sí, eliminarlo',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = element.href; // Redirigir a la URL del enlace
      }
    });
  }
</script>
@endsection