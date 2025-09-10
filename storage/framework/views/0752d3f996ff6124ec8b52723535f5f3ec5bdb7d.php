

<?php $__env->startSection('title', 'SkaPeople - Empleados'); ?>

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
    <h1>Empleados</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('/')); ?>"></a>Inicio</li>
            <li class="breadcrumb-item">Empleados</li>
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Empleados</h5>
                    <p>En la siguiente tabla encontrará todos los Empleados de <?php echo e($info_admins->empresa); ?>.</p>
                    <div class="mb-3 text-end">
                        <a href="<?php echo e(route('nuevo-empleado')); ?>" class="btn btn-primary btn-sm" title="Nuevo">
                            <i class="bi bi-plus-circle"></i> Nuevo Empleado
                        </a>
                    </div>
                    <!-- Table with stripped rows -->
                    <div class="table-responsive">
                        <table class="table datatable table-striped table-bordered table-sm table-responsive">
                            <thead>
                                <tr>
                                    <th>Sede</th>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Genero</th>
                                    <th>Correo</th>
                                    <th>Celular</th>
                                    <th>Cargo</th>
                                    <th>Dpto</th>
                                    <th>Acciones</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $info_empleados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empleado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td> <?php echo e($empleado->sede); ?> </td>
                                    <td> <?php echo e($empleado->cedula); ?> </td>
                                    <td> <?php echo e($empleado->nombre); ?> <?php echo e($empleado->apellido); ?></td>
                                    <td> <?php echo e($empleado->genero); ?> </td>
                                    <td> <?php echo e($empleado->correo); ?> </td>
                                    <td> <?php echo e($empleado->celular); ?> </td>
                                    <td> <?php echo e($empleado->cargo); ?> </td>
                                    <td> <?php echo e($empleado->departamento); ?> </td>
                                    <td class="text-center">
                                        <a href="" class="btn btn-outline-success btn-sm" title="Ver">
                                            <i class="bi bi-eye"></i></a>
                                        
                                        <a href="<?php echo e(route('editar-empleado', $empleado->id_empleado)); ?>" class="btn btn-outline-primary btn-sm" title="Editar">
                                            <i class="bi bi-pencil"></i></a>
                                    
                                        <a href="<?php echo e(route('eliminar-empleado', $empleado->id_empleado)); ?>" class="btn btn-outline-danger btn-sm" title="Eliminar"
                                            onclick="return confirmDelete(event, this);">
                                            <i class="bi bi-trash"></i></a>
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
<?php echo $__env->make('layouts.admin-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/backup/public_html/people/resources/views/admin/empleados.blade.php ENDPATH**/ ?>