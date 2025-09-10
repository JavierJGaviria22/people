

<?php $__env->startSection('title', 'SkaPeople - Festivos'); ?>

<?php $__env->startSection('content'); ?>
<!-- Titulo de pagina -->
<div class="pagetitle">
    <h1>Nuevo Festivo</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('/admin')); ?>">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('festivos.index')); ?>">Festivos</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('festivos.create')); ?>">Nuevo Festivo</a></li>
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Crear Festivo</h5>

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

                    <?php if(session('error')): ?>
                    <div class="alert alert-danger">
                        <?php echo e(session('error')); ?>

                    </div>
                    <?php endif; ?>

                    <!-- General Form Elements -->
                    <form action="<?php echo e(route('festivos.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="row mb-3">
                            <label for="nombre" class="col-sm-2 col-form-label">Nombre:</label>
                            <div class="col-sm-10">
                                <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo e(old('nombre')); ?>" placeholder="Ej: Año Nuevo" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="datetime" class="col-sm-2 col-form-label">Fecha:</label>
                            <div class="col-sm-10">
                                <input type="text" id="datetime" name="fecha" class="form-control" value="<?php echo e(old('fecha_fin')); ?>" placeholder="" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- <label class="col-sm-2 col-form-label"></label> -->
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Agregar Festivo</button>
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
        flatpickr("#datetime", {
            enableTime: false, // Habilita la selección de tiempo
            dateFormat: "Y-m-d", // Formato de fecha y hora
           // time_24hr: false, // Formato de 24 horas
            defaultDate: false, // Fecha por defecto
            //minDate: "today" // No permite seleccionar fechas pasadas
        });
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/backup/public_html/people/resources/views/admin/nuevo-festivo.blade.php ENDPATH**/ ?>