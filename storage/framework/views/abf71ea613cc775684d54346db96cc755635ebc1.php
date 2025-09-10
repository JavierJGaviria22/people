

<?php $__env->startSection('title', 'SkaPeople - Incosistencias'); ?>

<?php $__env->startSection('content'); ?>

<style>
    td {
        font-size: 13px;
    }

    label {
        padding: 0 0 17px 0;
    }
</style>

<!-- Titulo de pagina -->
<div class="pagetitle">
    <h1>Inconsistencias</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('/')); ?>"></a>Inicio</li>
            <li class="breadcrumb-item">Inconsistencias</li>
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Inconsistencias Encontradas</h5>
                    <p>Revisa la posible causa de estas inconsistencias, ten en cuenta las notas de los empleados.</p>
                    
                    <!-- Table with stripped rows -->
                    <div class="table-responsive">
                        <table class="table datatable table-striped table-bordered table-sm table-responsive text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Empleado</th>
                                    <th>Fecha</th>
                                    <th>Total Trabajado</th>
                                    <th>Total Asignado</th>
                                    <th>Notas</th>
                                    <th>Observaciones</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; ?>
                                <?php $__currentLoopData = $inconsistencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td> <?php echo e($i); ?> </td>
                                    <td> <?php echo e($info->empleado); ?> </td>
                                    <td> <?php echo e($info->fecha); ?> </td>
                                    <td> <?php echo e(number_format($info->total_trabajado, 2)); ?> </td>
                                    <td> <?php echo e($info->total_asignado); ?> </td>
                                    <td> <?php echo e($info->notas); ?> </td>
                                    <td> <?php echo e($info->observaciones); ?> </td>

                                    <td class="text-center">
                                        <a href="<?php echo e(route('nomina.edit', ['id_empleado' => $info->id_empleado, 'fecha' => $info->fecha])); ?>" class="btn btn-outline-primary btn-sm" title="Editar" target="_blank" rel="noopener noreferrer">
                                            <i class="bi bi-box-arrow-in-up-right"></i></a>
                                    </td>
                                </tr>
                                <?php $i++; ?>
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
<script>
    function confirmDelete(event, element) {
        event.preventDefault(); // Evitar que el enlace se ejecute inmediatamente

        Swal.fire({
            title: '¿Estás seguro?',
            text: "Podrás reactivar este empleado en cualquier momento.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, desactivar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = element.href; // Redirigir a la URL del enlace
            }
        });
    }
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/backup/public_html/people/resources/views/admin/informe-inconsistencias.blade.php ENDPATH**/ ?>