<?php $__env->startSection('title', 'SkaPeople - Horarios'); ?>

<?php $__env->startSection('content'); ?>

<style>
    td {
        font-size: 13px;
    }
</style>

<!-- Titulo de pagina -->
<div class="pagetitle">
    <h1>Horarios</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('/')); ?>"></a>Inicio</li>
            <li class="breadcrumb-item">Horarios</li>
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->


<?php if(session('errores')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php $__currentLoopData = session('errores'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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

<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Historial de Permisos</h5>
                    <p>En la siguiente tabla encontrará todos los horarios creados y asignados a los empleados. Los horarios mostrados aqui tendran una antiguedad de 1 mes como maximo.</p>
                    <div class="botones d-flex justify-content-center gap-4">
                    
                    <div class="mb-3 text-end">
                        <a href="<?php echo e(route('horarios.create')); ?>" class="btn btn-success btn-sm p-2" title="Crear">
                            <i class="bi bi-plus-circle"></i> Crear Horario
                        </a>
                    </div>
                    
                    <div class="mb-3 text-end">
                        <a href="<?php echo e(route('horarios.editar')); ?>" class="btn btn-primary btn-sm p-2" title="Editar">
                            <i class="bi bi-pencil"></i> Editar Horario
                        </a>
                    </div>
                    </div>
                    
                   
                </div>
            </div>
        </div>
    </div>
    <!-- End Table with stripped rows -->
</section>

<!--Script JS para la alerta de confirmacion de eliminacion de horario -->
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
<?php echo $__env->make('layouts.admin-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/backup/public_html/people/resources/views/admin/horarios.blade.php ENDPATH**/ ?>