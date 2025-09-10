

<?php $__env->startSection('title', 'SkaPeople - Permisos'); ?>

<?php $__env->startSection('content'); ?>
<!-- Titulo de pagina -->
<div class="pagetitle">
  <h1>Permisos</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo e(route('/')); ?>"></a>Inicio</li>
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
            <a href="<?php echo e(route('nuevo-permiso')); ?>" class="btn btn-primary btn-sm" title="Nuevo">
              <i class="bi bi-plus-circle"></i> Nuevo Permiso
            </a>
          </div>

          <?php if(session('success')): ?>
          <div class="alert alert-success">
            <?php echo e(session('success')); ?>

          </div>
          <?php endif; ?>

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
                <?php $__currentLoopData = $info_permisos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permiso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                  <td class="text-center"> <?php echo e($permiso->permiso); ?> </td>
                  <td class="text-center"> <?php echo e(\Carbon\Carbon::parse($permiso->fecha_solicitud)->format('Y-m-d h:i A')); ?> </td>
                  <td class="text-center"> <?php echo e(\Carbon\Carbon::parse($permiso->fecha_inicio)->format('Y-m-d h:i A')); ?> </td>
                  <td class="text-center"> <?php echo e(\Carbon\Carbon::parse($permiso->fecha_fin)->format('Y-m-d h:i A')); ?> </td>
                  <td class="text-center"> <?php echo e($permiso->dias); ?> </td>
                  <td class="text-center"> <?php echo e($permiso->horas); ?> </td>
                  <td class="text-center"> <?php echo e($permiso->minutos); ?> </td>
                  <td class="text-center <?php if($permiso->estado === 'Aprobado'): ?> table-success 
                           <?php elseif($permiso->estado === 'Declinado'): ?> table-danger 
                           <?php else: ?> table-warning 
                           <?php endif; ?>"> <?php echo e($permiso->estado); ?>

                  </td>
                  <td class="text-center"><?php if($permiso->estado === 'Pendiente'): ?>
                    <a href="<?php echo e(route('editar-permiso', $permiso->id_permiso)); ?>" class="btn btn-outline-primary btn-sm" title="Editar">
                      <i class="bi bi-pencil"></i>
                      <?php else: ?> -
                      <?php endif; ?>
                    </a>
                  </td>
                  <td class="text-center"><?php if($permiso->estado === 'Pendiente'): ?>
                    <a href="<?php echo e(route('eliminar-permiso', $permiso->id_permiso)); ?>" class="btn btn-outline-danger btn-sm" title="Eliminar"
                      onclick="return confirmDelete(event, this);">
                      <i class="bi bi-trash"></i>
                      <?php else: ?> -
                      <?php endif; ?>
                    </a>
                  </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/backup/public_html/people/resources/views/usuarios/mis-permisos.blade.php ENDPATH**/ ?>