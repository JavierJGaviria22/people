

<?php $__env->startSection('title', 'SkaPeople - Permisos'); ?>

<?php $__env->startSection('content'); ?>
<!-- Titulo de pagina -->
<div class="pagetitle">
  <h1>Editar Permiso</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo e(route('/')); ?>">Inicio</a></li>
      <li class="breadcrumb-item"><a href="<?php echo e(route('mis-permisos')); ?>">Mis Permisos</a></li>

    </ol>
  </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Formulario de Permiso</h5>

          <?php if($errors->any()): ?>
          <div class="alert alert-danger">
            <ul>
              <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li><?php echo e($error); ?></li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
          </div>
          <?php endif; ?>

          <?php if(session('success')): ?>
          <div class="alert alert-success">
            <?php echo e(session('success')); ?>

          </div>
          <?php endif; ?>

          <!-- General Form Elements -->
          <form action="<?php echo e(route('editar-permiso', $permiso->id_permiso)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label">Tipo Permiso</label>
              <div class="col-sm-10">
                <select name="id_tipo_permiso" class="form-select" aria-label="Default select example" required>
                  <option value="" disabled>Seleccionar</option>
                  <?php $__currentLoopData = $tiposPermiso; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($permiso->id_tipo_permiso); ?>" <?php echo e($permiso->id_tipo_permiso == $tipo->id_tipo_permiso ? 'selected' : ''); ?>>
                    <?php echo e($tipo->permiso); ?>

                  </option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="">Regresa:</label>
              <div class="col-sm-10">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="regresa" id="gridRadios1" value="1" <?php echo e($permiso->regresa == 1 ? 'checked' : ''); ?>>
                  <label class="form-check-label" for="gridRadios1">
                    Si
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="regresa" id="gridRadios2" value="0" <?php echo e($permiso->regresa == 0 ? 'checked' : ''); ?>>
                  <label class="form-check-label" for="gridRadios2">
                    No
                  </label>
                </div>
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputPassword" class="col-sm-2 col-form-label">Mensaje:</label>
              <div class="col-sm-10">
                <textarea name="descripcion" class="form-control" style="height: 100px" placeholder="Opcional"><?php echo e($permiso->descripcion); ?></textarea>
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputDate" class="col-sm-2 col-form-label">Fecha Inicio</label>
              <div class="col-sm-10">
                <input type="text" id="fecha_inicio" name="fecha_inicio" class="form-control" value="<?php echo e($permiso->fecha_inicio); ?>" placeholder="" required>
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputDate" class="col-sm-2 col-form-label">Fecha Fin</label>
              <div class="col-sm-10">
                <input type="text" id="fecha_fin" name="fecha_fin" class="form-control" value="<?php echo e($permiso->fecha_fin); ?>" placeholder="" required>
              </div>
            </div>

            <div class="row mb-3">
              <!-- <label class="col-sm-2 col-form-label"></label> -->
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Actualizar Permiso</button>
              </div>
            </div>
          </form><!-- End General Form Elements -->
        </div>
      </div>
    </div>
  </div>
</section>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    flatpickr("#fecha_inicio", {
      enableTime: true, // Habilita la selección de tiempo
      dateFormat: "Y-m-d H:i", // Formato de fecha y hora
      time_24hr: false, // Formato de 24 horas
      defaultDate: false, // Fecha por defecto
      minDate: '<?php echo e($permiso->fecha_solicitud); ?>' // No permite seleccionar fechas pasadas
    });
  });

  document.addEventListener('DOMContentLoaded', function() {
    flatpickr("#fecha_fin", {
      enableTime: true, // Habilita la selección de tiempo
      dateFormat: "Y-m-d H:i", // Formato de fecha y hora
      time_24hr: false, // Formato de 24 horas
      defaultDate: false, // Fecha por defecto
      minDate: "today" // No permite seleccionar fechas pasadas
    });
  });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/backup/public_html/people/resources/views/usuarios/editar-permiso.blade.php ENDPATH**/ ?>