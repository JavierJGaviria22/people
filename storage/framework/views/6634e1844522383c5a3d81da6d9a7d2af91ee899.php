<?php $__env->startSection('title', 'People - Auditoria'); ?>

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
    <h1>Registro de Auditoria</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('/')); ?>"></a>Inicio</li>
            <li class="breadcrumb-item">Reportes e informes</li>
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Registro de cambios encontrados en el sistema de asistencia</h5>
                    <p>Este Informe presentara los cambios realizados por los admins desde la fecha actual hasta 30 dias atras</p>
                    
                    <!-- Table with stripped rows -->
                    <div class="table-responsive">
                        <div class="tb-filtro d-flex justify-content-end">
                            <table border="0" cellspacing="5" cellpadding="5">
                                <tbody>
                                <tr>
                                    <td>Desde:</td>
                                    <td><input type="date" id="min" name="min"></td>
                                </tr>
                                <tr>
                                    <td>Hasta:</td>
                                    <td><input type="date" id="max" name="max"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <table class="table datatable table-striped table-bordered table-sm table-responsive text-center" id="example">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Empleado</th>
                                    <th>Fecha</th>
                                    <th>Modificado de</th>
                                    <th>Modificado a</th>
                                    <th>Modificado con la IP</th>
                                    <th>Modificado por</th>
                                    <th>Fecha modificación</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; ?>
                                <?php $__currentLoopData = $audits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $audit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td> <?php echo e($audit->id_audit); ?> </td>
                                    <td> <?php echo e($audit->usuario_modificado); ?> </td>
                                    <td> <?php echo e(\Carbon\Carbon::parse($audit->modificado_de)->format('Y-m-d')); ?> </td>
                                    <td> <?php echo e(\Carbon\Carbon::parse($audit->modificado_de)->format('h:i A')); ?> </td>
                                    <td> <?php echo e(\Carbon\Carbon::parse($audit->modificado_a)->format('h:i A')); ?> </td>
                                    <td> <?php echo e($audit->modificado_por_ip); ?> </td>
                                    <td> <?php echo e($audit->modificado_por_usuario); ?> </td>
                                    <td> <?php echo e($audit->fecha_modificacion); ?> </td>
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
    $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
            var minDate = $('#min').val();
            var maxDate = $('#max').val();
            var fecha = data[2];

            var date = new Date(fecha);
            var startDate = minDate ? new Date(minDate) : null;
            var endDate = maxDate ? new Date(maxDate) : null;

            if (
                (startDate && date < startDate) || 
                (endDate && date > endDate)
            ) {
                return false;
            }

            return true;
        }
    );

    $(document).ready(function () {
        var table = $('#example').DataTable();

        $('#min, #max').change(function () {
            table.draw();
        });
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/backup/public_html/people/resources/views/admin/audit-log.blade.php ENDPATH**/ ?>