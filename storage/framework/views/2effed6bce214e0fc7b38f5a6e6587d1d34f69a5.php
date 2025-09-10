

<?php $__env->startSection('title', 'People - Inconsistencias'); ?>

<?php $__env->startSection('content'); ?>
 
    <style>
        #map {
            width: 100%;
            height: 500px;

        }

    </style>
<!-- Titulo de pagina -->
<div class="pagetitle">
    <h1>Inconsistencias</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('/')); ?>"></a>Inicio</li>
            <li class="breadcrumb-item">Ajsutar Inconsistencias</li>
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Horario Asignado</h5>
                    <p>Este es el horario asigando a <strong><?php echo e($horario->empleado); ?></strong> el dia <strong><?php echo e(\Carbon\Carbon::parse($horario->fecha)->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY')); ?></strong></p>



                    <!-- Table with stripped rows -->
                    <div class="table-responsive col-sm-6 m-auto">
                        <table class="table table-bordered table-sm table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">Entrada</th>
                                    <th class="text-center">Salida</th>
                                    <th class="text-center">Almuerzo</th>
                                    <th class="text-center">Total_asignado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center"><?php echo e(\Carbon\Carbon::parse($horario->entrada)->format('h:i A')); ?></td>
                                    <td class="text-center"><?php echo e(\Carbon\Carbon::parse($horario->salida)->format('h:i A')); ?></td>
                                    <td class="text-center"><?php echo e($horario->almuerzo); ?></td>
                                    <td class="text-center"><?php echo e($horario->total_asignado); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Resumen del dia</h5>
                    <p class="m-0">Ficha de tiempo de <strong><?php echo e($horario->empleado); ?></strong> el dia <strong><?php echo e(\Carbon\Carbon::parse($horario->fecha)->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY')); ?></strong></p>
                    <p><strong>Sede: </strong><?php echo e($horario->sede); ?></p>

                    <?php if(session('success')): ?>

                    <div class="alert alert-success">
                        <?php echo e(session('success')); ?>

                    </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('nomina.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input name="nombre_empleado" type="hidden" value="<?php echo e($horario->empleado); ?>">
                        <!-- Table with stripped rows -->
                        <div class="table-responsive col-sm-8 m-auto">

                            <table class="table table-bordered table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th style="color: #012970;" class="text-center" colspan="5">Total Trabajado</th>
                                        <th style="color: #012970;" class="text-center danger" colspan="2"><?php echo e($horario->total_trabajado); ?></th>
                                    </tr>
                                    <tr>
                                        <th style="color: #012970; width: 20%;" class="text-center">Nueva Hora</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Hora</th>
                                        <th class="text-center">Nota</th>
                                        <th class="text-center">Ubicación</th>
                                        <th class="text-center">Eliminar</th>
                                        <th class="text-center">Observación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; ?>
                                    <?php $__currentLoopData = $estados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="text-center w-10">
                                            <input name="nueva_hora<?php echo e($i); ?>" type="time" class="form-control">
                                            <input name="id_pd_info<?php echo e($i); ?>" type="hidden" value="<?php echo e($estado->id_pd_info); ?>">
                                        </td>
                                        <td class="text-center"><?php echo e($estado->estado); ?></td>
                                        <td class="text-center"><?php echo e(\Carbon\Carbon::parse($estado->hora)->format('h:i A')); ?></td>
                                        <td class="text-center"><?php echo e($estado->notas); ?></td>
                                        <td class="text-center "><a href="#" class="btn btn-outline-primary btn-sm" title="Actuar" data-bs-toggle="modal" data-bs-target="#actuarModal" onclick="setPermisoId('<?php echo e($estado->id_pd_info); ?>', '<?php echo e($estado->latitude); ?>', '<?php echo e($estado->longitude); ?>')">
                                            <i class="bi bi-map"></i>
                                          </a></td>
                                        <td class="text-center">
                                            <a href="<?php echo e(route('nomina.show', $estado->id_pd_info)); ?>" class="btn btn-outline-danger btn-sm" title="Eliminar"
                                                onclick="return confirmDelete(event, this);">
                                                <i class="bi bi-trash"></i></a>
                                        </td>
                                        <td class="text-center ">
                                            <select name="observacion<?php echo e($i); ?>" class="form-control" aria-label="Default select example">
                                                <option value="nulo" <?php echo e($estado->observacion ? '' : 'selected'); ?>></option>
                                                <?php $__currentLoopData = $observaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $observacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($observacion->observacion); ?>" <?php echo e($estado->observacion == $observacion->observacion ? 'selected' : ''); ?>>
                                                    <?php echo e($observacion->observacion); ?>

                                                </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <input type="hidden" name="i" value="<?php echo e($i); ?>">
                                    <input type="hidden" name="fecha" value="<?php echo e($estado->fecha); ?>">
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-8 m-auto d-flex justify-content-between">
                            <a href="" class="btn btn-success" title="Nuevo" data-bs-toggle="modal" data-bs-target="#ModalEstado">
                                <i class="bi bi-plus-circle"></i> Estado
                            </a>
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para agregar estado -->
    <div class="modal fade" id="ModalEstado" tabindex="-1" aria-labelledby="ModalEstadoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?php echo e(route('nomina.agregarEstado')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold" id="ModalEstadoLabel">Agregar Estado</h4>
                    </div>
                    <div class="modal-body">
                        <label class="form-check-label pb-3"><strong>Estado:</strong>
                            <div class="col-sm-10 pb-3">
                                <select name="tipo_estado" class="form-select" required>
                                    <option value="" <?php echo e(old('tipo_estado') ? '' : 'selected'); ?> disabled>Seleccionar</option>
                                    <?php $__currentLoopData = $tipoEstados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipoEstado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($tipoEstado->id_estado); ?>" <?php echo e(old('tipo_estado') == $tipoEstado->id_estado ? 'selected' : ''); ?>>
                                        <?php echo e($tipoEstado->estado); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            
                        <div>
                            <label class="form-check-label font-weight-bold" for="datetime"><strong>Hora:</strong> </label>
                            <input class="form-control" type="time" name="hora" required>
                        </div>
                        <input type="hidden" name="id_empleado" value="<?php echo e($horario->id_empleado); ?>">
                        <input type="hidden" name="fecha" value="<?php echo e($horario->fecha); ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="- guardarButton">Insertar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Fin de modal para agregar estado -->


    <!-- Modal ubicacion -->
    <div class="modal fade" id="actuarModal" tabindex="-1" aria-labelledby="actuarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title font-weight-bold" id="actuarModalLabel">Ubicacion de Empleado</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p id="empleadoNombre"></p>
              <p id="id_pd_info"></p> 
              <div id="map"></div> 
            </div>
          </div>
        </div>
      </div>
    <!-- Fin de modal ubicacion -->

    <!-- End Table with stripped rows -->
</section>



<!--Script JS para la alerta de confirmacion de eliminacion de estado -->
<script>
    function confirmDelete(event, element) {
        event.preventDefault(); // Evitar que el enlace se ejecute inmediatamente

        Swal.fire({
            title: '¿Estás seguro?',
            text: "Una vez eliminado, no podrás recuperar este estado.",
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

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>                        
<script>
    // Variable global para almacenar el ID del permiso
    window.currentPermisoId = null;
  
    // Función para establecer el ID del permiso
    function setPermisoId(id, nombreEmpleado, id_pd_info) {
      window.currentPermisoId = id; // Almacena el ID en la variable global
  
      // Actualiza el modal con la información del empleado y tipo de permiso
      document.getElementById('empleadoNombre').innerHTML = `<strong>Empleado:</strong> ${nombreEmpleado}`;
      document.getElementById('id_pd_info').innerHTML = `<strong>Tipo de Permiso:</strong> ${id_pd_info}`;
    }
  </script>

<script>
    var map = null;
    var markers = []; 
    var selectedLat = null;
    var selectedLng = null;

    function setPermisoId(id, lat, lng) {
        selectedLat = parseFloat(lat);
        selectedLng = parseFloat(lng);
    }

    document.getElementById('actuarModal').addEventListener('shown.bs.modal', function () {
        if (!map) {
            map = L.map('map').setView([4.433549, -77.539301], 16); 
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);
        }

        
        markers.forEach(marker => map.removeLayer(marker));
        markers = [];

        
        if (selectedLat && selectedLng) {
            var selectedMarker = L.marker([selectedLat, selectedLng]).addTo(map)
                .bindPopup("<?php echo e($estado->empleado); ?>")
                .openPopup();
            markers.push(selectedMarker);
            map.setView([selectedLat, selectedLng], 20);
        }

        var locations = [
            { lat: 40.6594293041125, lng: -74.20437146147381, title: "Elizabeth" },
            { lat: 40.66925613629364, lng: -74.21760828846158, title: "Morris" },
            { lat: 40.55642730256506, lng: -74.2973852749729, title: "Woodbridge" },
            { lat: 40.660215163032895, lng: -74.23229727496785, title: "Elmora" },
            { lat: 40.773774019458095, lng: -74.02828965962115, title: "Union City" },
            { lat: 40.79658911755547, lng: -74.01043734121373, title: "Bergeline" },
            { lat: 40.662117819148285, lng: -74.25261877312076, title: "Roselle" },
            { lat: 3.433559330636678, lng: -76.53926501824887, title: "Moda de colombia" },
            
        ];

        var pinkIcon = L.icon({
            iconUrl: 'https://caronshoes.com/people/public/assets/img/store1.png',
            iconSize: [35, 35],
            iconAnchor: [0, 0],
            popupAnchor: [1, 34],
            shadowSize: [41, 41]
        });

        // Agregar marcadores con el icono rosado
        locations.forEach(location => {
            var marker = L.marker([location.lat, location.lng], { icon: pinkIcon }).addTo(map)
                .bindPopup(location.title);
            markers.push(marker);
        });
    });

    // Resetear el mapa al cerrar el modal
    document.getElementById('actuarModal').addEventListener('hidden.bs.modal', function () {
        if (map) {
            map.eachLayer(layer => {
                if (layer instanceof L.Marker) {
                    map.removeLayer(layer);
                }
            });
            markers = [];
        }
    });
</script>





<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/backup/public_html/people/resources/views/admin/ajustar-inconsistencias.blade.php ENDPATH**/ ?>