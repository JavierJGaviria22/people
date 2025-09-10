

<?php $__env->startSection('title', 'SkaPeople - Noticias'); ?>

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
    <h1>Noticias</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('/')); ?>"></a>Inicio</li>
            <li class="breadcrumb-item">Noticias</li>
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Noticias</h5>
                    <p>En la siguiente tabla encontrará todos las Noticias de <?php echo e($info_admins->empresa); ?>.</p>
                    <div class="mb-3 text-end">
                        <a href="<?php echo e(route('noticias.create')); ?>" class="btn btn-primary btn-sm" title="Nuevo">
                            <i class="bi bi-plus-circle"></i> Nueva Noticia
                        </a>
                    </div>
                    <!-- Table with stripped rows -->
                    <div class="table-responsive">
                        <table class="table datatable table-striped table-bordered table-sm table-responsive">
                            <thead>
                                <tr>
                                    <th>Titulo</th>
                                    <th>Contenido</th>
                                    <th>Imagen</th>
                                    <th>Inicio</th>
                                    <th>Fin</th>
                                    <th>Editar</th>
                                    <th>Borrar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $noticias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $noticia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td> <?php echo e($noticia->titulo); ?> </td>
                                    <td> <?php echo e($noticia->contenido); ?> </td>
                                    <td> <?php echo e($noticia->imagen); ?> </td>
                                    <td> <?php echo e($noticia->fecha_inicio); ?> </td>
                                    <td> <?php echo e($noticia->fecha_fin); ?> </td>
                                    <td class="text-center">
                                        <a href="<?php echo e(route('noticias.edit', $noticia->id_noticia)); ?>" class="btn btn-outline-primary btn-sm" title="Editar">
                                            <i class="bi bi-pencil"></i></a>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?php echo e(route('noticias.show', $noticia->id_noticia)); ?>" class="btn btn-outline-danger btn-sm" title="Eliminar"
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
            text: "No podrás recuperar esta noticia.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, Eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = element.href; // Redirigir a la URL del enlace
            }
        });
    }
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/backup/public_html/people/resources/views/admin/noticias.blade.php ENDPATH**/ ?>