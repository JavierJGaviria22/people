<?php $__env->startSection('title', 'People - Auditoria'); ?>

<?php $__env->startSection('content'); ?>

<style>
    td {
        font-size: 15px;
    }

    label {
        padding: 0 0 17px 0;
    }
</style>

<!-- Titulo de pagina -->
<div class="pagetitle">
    <h1>Informes de PTO</h1>
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
                    <h5 class="card-title">Registro de PTO Acumulados por horas</h5>
                    <p>Consulta aquí los registros de PTO acumulado por horas de cada empleado durante el año en curso.</p>
                    
                    <!-- Table with stripped rows -->
                    <div class="table-responsive">
                        <div class="tb-filtro d-flex justify-content-end">
                            
                        </div>
                        <br>
                        <table class="table datatable table-striped table-bordered table-sm table-responsive text-center" id="example">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Empleado</th>
                                    <th>PTO Acumulado</th>
                                    <th>PTO Utilizado</th>
                                    <th>PTO Disponible</th>
                                    <th>Detalles</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; ?>
                                <?php $__currentLoopData = $pto; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td> <?php echo e($i); ?> </td>
                                    <td> <?php echo e($p->nombre); ?> <?php echo e($p->apellido); ?> </td>
                                    <td> <?php echo e($p->vacaciones_acumuladas); ?>  </td>
                                    <td> <?php echo e($p->vacaciones_tomadas); ?> </td>
                                    <td> <?php echo e($p->vacaciones_disponibles); ?></td>
                                    <td class="text-center">
                                        <a href="<?php echo e(route('detalle-pto' , ['id_empleado' => $p->id_empleado])); ?>" class="btn btn-outline-primary btn-sm" title="Ver" target="_blank" rel="noopener noreferrer">
                                            <i class="bi bi-eye"></i></a>
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
<?php echo $__env->make('layouts.admin-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/backup/public_html/people/resources/views/admin/infor-pto.blade.php ENDPATH**/ ?>