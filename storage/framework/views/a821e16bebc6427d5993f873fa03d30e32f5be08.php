

<?php $__env->startSection('title', 'People - PTO'); ?>

<?php $__env->startSection('content'); ?>

<style>
    td {
        font-size: 14px;
    }

    label {
        padding: 0 0 17px 0;
    }
</style>
<!-- Titulo de pagina -->
<div class="pagetitle">
    <h1>Detalles de PTO</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('/')); ?>"></a>Inicio</li>
            <li class="breadcrumb-item">PTO</li>
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">PTO Solicitado y Utilizado</h5>
                    <p>Este es el PTO Utilizado por <strong><?php echo e($nombre_empleado->nombre); ?> <?php echo e($nombre_empleado->apellido); ?> </strong> </p>

                    <!-- Table with stripped rows -->
                    <div class="table-responsive col-sm-9 m-auto">
                        <table class="table table-bordered table-sm table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">Tipo</th>
                                    <th class="text-center">Fecha de solicitud</th>
                                    <th class="text-center">Horas solicitadas</th>
                                    <th class="text-center">Estados</th>
                                    <th class="text-center">Fecha inicio</th>
                                    <th class="text-center">Fecha fin</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $vistapto; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td <?php if($pto->estado == 'Aprobado'): ?> style="background-color: #6db46d;" <?php endif; ?> class="text-center"><?php echo e($pto->tipo); ?></td>
                                    <td <?php if($pto->estado == 'Aprobado'): ?> style="background-color: #6db46d;" <?php endif; ?> class="text-center"><?php echo e($pto->fecha_solicitud); ?></td>
                                    <td <?php if($pto->estado == 'Aprobado'): ?> style="background-color: #6db46d;" <?php endif; ?> class="text-center"><?php echo e($pto->horas); ?></td>
                                    <td <?php if($pto->estado == 'Aprobado'): ?> style="background-color: #6db46d;" <?php endif; ?> class="text-center"><?php echo e($pto->estado); ?></td>
                                    <td <?php if($pto->estado == 'Aprobado'): ?> style="background-color: #6db46d;" <?php endif; ?> class="text-center"><?php echo e($pto->fecha_inicio); ?></td>
                                    <td <?php if($pto->estado == 'Aprobado'): ?> style="background-color: #6db46d;" <?php endif; ?> class="text-center"><?php echo e($pto->fecha_fin); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/backup/public_html/people/resources/views/admin/vista-pto.blade.php ENDPATH**/ ?>