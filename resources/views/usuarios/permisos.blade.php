@extends('layouts.layout')

@section('title', 'SkaPeople - Permisos')

@section('content')

<style>
  td {
    font-size: 13px;
  }
</style>

<!-- Titulo de pagina -->
<div class="pagetitle">
  <h1>Permisos</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('/') }}"></a>Inicio</li>
      <li class="breadcrumb-item">Permisos</li>
    </ol>
  </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section dashboard">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Historial de Permisos</h5>
          <p>En la siguiente tabla encontrará todos los permisos que han solicitado los empleados del departamento de {{ $info_empleados->departamento }} del cual es líder. Puedes aprobar o declinar permisos dando click en la columna Estado.</p>
          <!-- Table with stripped rows -->
          <div class="table-responsive">
            <table class="table datatable table-striped table-bordered table-sm table-responsive">
              <thead>
                <tr>
                  <th>Empleado</th>
                  <th>Permiso</th>
                  <th>Fecha Solicitud</th>
                  <th data-type="date" data-format="YYYY/DD/MM">Fecha Inicio</th>
                  <th data-type="date" data-format="YYYY/DD/MM">Fecha Fin</th>
                  <th>Días</th>
                  <th>Horas</th>
                  <th>Minutos</th>
                  <th>Estado</th>
                  <th>Actuar</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($info_permisos as $permiso)
                <tr>
                  <td> {{$permiso->nombre_empleado }} </td>
                  <td> {{$permiso->permiso }} </td>
                  <td class="text-center"> {{ \Carbon\Carbon::parse($permiso->fecha_solicitud)->format('Y-m-d h:i A') }} </td>
                  <td class="text-center"> {{ \Carbon\Carbon::parse($permiso->fecha_inicio)->format('Y-m-d h:i A') }} </td>
                  <td class="text-center"> {{ \Carbon\Carbon::parse($permiso->fecha_fin)->format('Y-m-d h:i A') }} </td>
                  <td> {{$permiso->dias }} </td>
                  <td> {{$permiso->horas }} </td>
                  <td> {{$permiso->minutos }} </td>
                  <td class="@if($permiso->estado === 'Aprobado') table-success 
                           @elseif($permiso->estado === 'Declinado') table-danger 
                           @else table-warning 
                           @endif"> {{$permiso->estado }}
                  </td>
                  <td class="text-center">
                    @if($permiso->estado === 'Pendiente')
                    <a href="#" class="btn btn-outline-success btn-sm" title="Actuar" data-bs-toggle="modal" data-bs-target="#actuarModal" onclick="setPermisoId('{{ $permiso->id_permiso }}', '{{ $permiso->nombre_empleado }}', '{{ $permiso->permiso }}')">
                      <i class="bi bi-file-earmark-text"></i>
                    </a>
                    @else
                    -
                    @endif
                  </td>

                </tr>
                @endforeach
              </tbody>
            </table>
            <!-- Inicio Modal -->
            <div class="modal fade" id="actuarModal" tabindex="-1" aria-labelledby="actuarModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="actuarModalLabel">DEFINIR PERMISO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <p id="empleadoNombre"></p> <!-- Lugar para el nombre del empleado -->
                    <p id="tipoPermiso"></p> <!-- Lugar para el tipo de permiso -->
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="remuneradoCheck">
                      <label class="form-check-label" for="remuneradoCheck">Marcar si es permiso remunerado</label>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="aprobarPermiso('aprobar')">Aprobar</button>
                    <button type="button" class="btn btn-danger" onclick="aprobarPermiso('declinar')" data-bs-dismiss="modal">Declinar</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- Fin Modal -->
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Table with stripped rows -->
</section>

<script>
  // Variable global para almacenar el ID del permiso
  window.currentPermisoId = null;

  // Función para establecer el ID del permiso 
  function setPermisoId(id, nombreEmpleado, tipoPermiso) {
    window.currentPermisoId = id; // Almacena el ID en la variable global

    // Actualiza el modal con la información del empleado y tipo de permiso
    document.getElementById('empleadoNombre').innerHTML = `<strong>Empleado:</strong> ${nombreEmpleado}`;
    document.getElementById('tipoPermiso').innerHTML = `<strong>Tipo de Permiso:</strong> ${tipoPermiso}`;
  }

  function aprobarPermiso(accion) {
    const remunerado = document.getElementById('remuneradoCheck').checked ? 1 : 0;
    const idPermiso = window.currentPermisoId; // Recupera el ID del permiso

    fetch(`actuar-permiso/${idPermiso}/procesar`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({
          accion: accion,
          remunerado: remunerado
        })
      }).then(response => response.json()) // Convertir la respuesta en JSON
      .then(data => {
        $('#actuarModal').modal('hide');
        alert(data.message); // Mostrar el mensaje de éxito o error
        location.reload(); // Recargar la vista
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Error de conexión.'); // Mensaje de error
      });
  }
</script>
@endsection