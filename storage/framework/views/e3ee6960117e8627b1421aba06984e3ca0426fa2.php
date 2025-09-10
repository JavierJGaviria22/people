

<?php $__env->startSection('title', 'SkaPeople - Inconsistencias'); ?>

<?php $__env->startSection('content'); ?>
<!-- Titulo de pagina -->
<div class="pagetitle">
    <h1>Corregir Inconsistencias</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('/')); ?>">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('mis-permisos')); ?>">Nomina</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('nuevo-permiso')); ?>">Corregir Inconsistencias</a></li>
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-body ">
                    <h5 class="card-title">Seleccion de rango de fechas</h5>
                    <div class="p-2 mb-3" style="background-color: #D9E4E5; border-radius: 0.7rem;">
                        <p>En esta sección, podrá consultar todas las inconsistencias detectadas en el sistema de fichaje de los empleados. Las inconsistencias ocurren cuando el total de horas trabajadas no coincide con las horas permitidas según el horario autorizado para cada empleado.</p>
                    </div>

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
                    <form id="fechaForm" action="<?php echo e(route('nomina.showInconsistencias',['start_date' => 1, 'end_date' => 1])); ?>" method="GET">

                        <div class="row mb-3">
                            <label for="datetime2" class="col-sm-2 col-form-label">Fecha Inicio</label>
                            <div class="col-sm-10">
                                <input type="text" id="datetime" name="fecha_inicio" class="form-control" value="<?php echo e(old('fecha_inicio')); ?>" placeholder="" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="datetime" class="col-sm-2 col-form-label">Fecha Fin</label>
                            <div class="col-sm-10">
                                <input type="text" id="datetime2" name="fecha_fin" class="form-control" value="<?php echo e(old('fecha_fin')); ?>" placeholder="" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- <label class="col-sm-2 col-form-label"></label> -->
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Revisar</button>
                            </div>
                        </div>
                    </form><!-- End General Form Elements -->
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    document.getElementById('fechaForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevenir el comportamiento por defecto del formulario

        let startDate = document.getElementById('datetime').value;
        let endDate = document.getElementById('datetime2').value;

        let url = 'nomina/inconsistencias/' + startDate + '/' + endDate;
        window.location.href = url;
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#datetime", {
            dateFormat: "Y-m-d",
            time_24hr: false,
            defaultDate: false,

        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#datetime2", {
            dateFormat: "Y-m-d",
            time_24hr: false,
            defaultDate: false,
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/backup/public_html/people/resources/views/admin/inconsistencias.blade.php ENDPATH**/ ?>