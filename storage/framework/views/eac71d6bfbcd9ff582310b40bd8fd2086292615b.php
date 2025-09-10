<?php $__env->startSection('title', 'People - Reporte'); ?>

<?php $__env->startSection('content'); ?>
<!-- Titulo de pagina -->
<div class="pagetitle">
    <h1>Detalles de Asistencia</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('/')); ?>"></a>Inicio</li>
            <li class="breadcrumb-item">Detalles de Asistencia</li>
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

                        <input name="nombre_empleado" type="hidden" value="<?php echo e($horario->empleado); ?>">
                        <!-- Table with stripped rows -->
                        <div class="table-responsive col-sm-8 m-auto">

                            <table class="table table-bordered table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th style="color: #012970;" class="text-center" colspan="4">Total Trabajado</th>
                                        <th style="color: #012970;" class="text-center danger" colspan="2"><?php echo e($redondeado = round($horario->total_trabajado, 2)); ?></th>
                                    </tr>
                                    <tr>
                                        
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Hora</th>
                                        <th class="text-center">Nota</th>
                                        <th class="text-center">Ubicación</th>
                                        
                                        <th class="text-center">Observación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; ?>
                                    <?php $__currentLoopData = $estados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                       
                                        <td class="text-center"><?php echo e($estado->estado); ?></td>
                                        <td class="text-center"><?php echo e(\Carbon\Carbon::parse($estado->hora)->format('h:i A')); ?></td>
                                        <td class="text-center"><?php echo e($estado->notas); ?></td>
                                        <td class="text-center "><a href="" class="btn btn-outline-primary btn-sm"><i class="bi bi-map"></i></a></td>
                                       
                                        <td class="text-center">
                                            <input class="form-control" type="text" value="<?php echo e($estado->observacion); ?>" readonly>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <input type="hidden" name="i" value="<?php echo e($i); ?>">
                                    <input type="hidden" name="fecha" value="<?php echo e($estado->fecha); ?>">
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <!-- End Table with stripped rows -->
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/backup/public_html/people/resources/views/usuarios/reporte-detalles.blade.php ENDPATH**/ ?>