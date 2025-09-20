

<?php $__env->startSection('title', 'SkaPeople - Horarios'); ?>

<?php $__env->startSection('content'); ?>
<!-- Titulo de pagina -->

<head>
    <style>
        .form-control {
            padding: 0;
            font-size: 0.8rem;
        }

        .form-select {
            padding: 0 20px 0 0;
            font-size: 0.8rem;
        }

        .novedad {
            width: 8rem;
        }

       .btn-asignar {
            padding: 5px;
            font-size: 0.77rem;
       }
    </style>
</head>

<div class="pagetitle">
    <h1>Editar Horario</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('/')); ?>">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('mis-permisos')); ?>">Horarios</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('nuevo-permiso')); ?>">Editar Horario</a></li>
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<?php $j = 0; $k = 0; ?>
<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-10 d-flex gap-4" style="width: 100%;">
            <?php $__currentLoopData = $id_empleado; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card">
                <div class="card-body ">
                    
                        <div class=" d-flex align-items-baseline justify-content-between mt-3">
                            <h5 class="card-title">Horario para editar a <strong> <?php echo e($nombre_empleado[$j]->nombre); ?> <?php echo e($nombre_empleado[$j]->apellido); ?></strong></h5>
                            <div class="d-flex gap-2 align-items-baseline justify-content-end">
                                 <h6 class="card-title"><strong>Total a Trabajar:</strong></h6>
                                <input name="totalFinal" class="form-control" style="width: 25%;" id="totalSumado-<?php echo e($j); ?>" required readonly>
                                <input type="hidden" id="intervalo-<?php echo e($j); ?>" value="<?php echo e($intervalo->days); ?>" required>
                                <input type="hidden" id="id_empleado-<?php echo e($j); ?>" value="<?php echo e($nombre_empleado[$j]->id_empleado); ?>" required>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-4 d-flex justify-content-end">
                            <button type="button" class="btn btn-primary btn-asignar" data-index="<?php echo e($j); ?>">Actualizar</button>
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

                        <?php if(session('errores')): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php $__currentLoopData = session('errores'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                        <?php endif; ?>

                        <!-- Table with stripped rows -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="tabla-horario-<?php echo e($j); ?>">
                                <thead>
                                    <tr>
                                        <th class="text-center">Fecha</th>
                                        <th class="text-center">Entrada</th>
                                        <th class="text-center">Salida</th>
                                        <th class="text-center">Almuerzo</th>
                                        <th class="text-center">Sede</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-center">Novedad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for($i = 0; $i <= $intervalo->days; $i++): ?>
                                        <tr>
                                            <td class="text-center" data-index="<?php echo e($j); ?>"><?php echo e(\Carbon\Carbon::parse($horarios[$k]->fecha_h)->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY')); ?></td>
                                            <input type="hidden" class="fecha" data-index="<?php echo e($j); ?>" value="<?php echo e(\Carbon\Carbon::parse($horarios[$k]->fecha_h)->toDateString()); ?>" required>
                                            <td class="text-center"><input class="form-control hora1" type="time" data-index="<?php echo e($j); ?>" value="<?php echo e($horarios[$k]->entrada_h); ?>" required></td>
                                            <td class="text-center"><input class="form-control hora2" type="time" data-index="<?php echo e($j); ?>" value="<?php echo e($horarios[$k]->salida_h); ?>" required></td>
                                            <td class="text-center"><input class="form-control lunch" type="number" min="0" step="any" data-index="<?php echo e($j); ?>" value="<?php echo e($horarios[$k]->tiempo_fuera); ?>" required></td>
                                            <td class="text-center"> <select style="width: auto;" id="sede" name="sede<?php echo e($i); ?>" class="form-select sede" aria-label="Default select example" data-index="<?php echo e($j); ?>" required <?php echo e($horarios[$k]->id_permiso == null || $horarios[$k]->id_permiso == 6 ? '' : 'disabled'); ?>>
                                                    <option value="" <?php echo e($horarios[$k]->id_sede == null ? 'selected' : ''); ?> disabled>Seleccionar</option>
                                                    <?php $__currentLoopData = $sedes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sede): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($sede->id_sede); ?>" <?php echo e($horarios[$k]->id_sede == $sede->id_sede ? 'selected' : ''); ?>>
                                                        <?php echo e($sede->nombre); ?>

                                                    </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select></td>
                                            <td class="text-center"><input class="form-control resultado" data-index="<?php echo e($j); ?>" required readonly value="<?php echo e($horarios[$k]->total); ?>"></td>
                                            <td class="text-center">
                                                <select style="" class="form-select novedad" data-index="<?php echo e($j); ?>">
                                                    <option value="" <?php echo e($horarios[$k]->id_permiso ? '' : 'selected'); ?>>Sin Novedad</option>
                                                    <?php $__currentLoopData = $novedades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $novedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($novedad->id_tipo_permiso); ?>" <?php echo e($horarios[$k]->id_permiso == $novedad->id_tipo_permiso ? 'selected' : ''); ?>>
                                                        <?php echo e($novedad->permiso); ?>

                                                    </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select></td>
                                        </tr>
                                        <?php $k++; ?>
                                <?php endfor; ?>
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
            <?php $j = $j + 1; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {
    function deshabilitarElementosPorDataIndex(index) {
    // $('[data-index="' + index + '"]').filter('input, select, button').prop('disabled', true);
    $('[data-index="' + index + '"]').filter('td').css('background-color', 'chartreuse');
    }
    // Para cada card
    <?php $__currentLoopData = $id_empleado; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    (function(index) {
        // Calcular suma total de la card
        function calcularSumaTotalCard() {
            let total = 0;
            $(`.resultado[data-index='${index}']`).each(function() {
                const valor = parseFloat($(this).val());
                if (!isNaN(valor)) total += valor;
            });
            $(`#totalSumado-${index}`).val(total.toFixed(2));
        }

        // Cálculo de diferencia por fila
        $(`.hora1[data-index='${index}'], .hora2[data-index='${index}'], .lunch[data-index='${index}']`).on('input', function() {
            const row = $(this).closest('tr');
            const hora1 = row.find(`.hora1[data-index='${index}']`).val();
            const hora2 = row.find(`.hora2[data-index='${index}']`).val();
            const lunch = parseFloat(row.find(`.lunch[data-index='${index}']`).val()) || 0;
            if (hora1 && hora2) {
                const date1 = new Date(`2000-01-01T${hora1}`);
                const date2 = new Date(`2000-01-01T${hora2}`);
                let diferencia_horas = (date2 - date1) / (1000 * 60 * 60) - lunch;
                row.find(`.resultado[data-index='${index}']`).val(diferencia_horas.toFixed(2));
            } else {
                row.find(`.resultado[data-index='${index}']`).val('');
            }
            calcularSumaTotalCard();
        });

        // Inicializar suma al cargar
        calcularSumaTotalCard();

        // Novedad: deshabilitar/rehabilitar inputs de la fila
        $(`.novedad[data-index='${index}']`).on('change', function() {
            const row = $(this).closest('tr');
            if ($(this).val() !== "" && $(this).val() !== "5" && $(this).val() !== "6") {
                row.find('input, select').not(this).not('.fecha').prop('disabled', true).val('');
            } else {
                row.find('input, select').not(this).not('.fecha').prop('disabled', false);
            }
        });

        // Enviar por AJAX
        $(`.btn-asignar[data-index='${index}']`).on('click', function() {
            $('[data-index="' + index + '"]').filter('button').prop('disabled', true);
            let data = {
                _token: '<?php echo e(csrf_token()); ?>',
                id_empleado: $(`#id_empleado-${index}`).val(),
                totalFinal: $(`#totalSumado-${index}`).val(),
                intervalo: $(`#intervalo-${index}`).val(),
            };
            // Recorrer filas y agregar datos
            $(`#tabla-horario-${index} tbody tr`).each(function(i) {
                data[`fecha${i}`] = $(this).find('.fecha').val();
                data[`entrada${i}`] = $(this).find('.hora1').val();
                data[`salida${i}`] = $(this).find('.hora2').val();
                data[`lunch${i}`] = $(this).find('.lunch').val();
                data[`sede${i}`] = $(this).find('.sede').val();
                data[`total${i}`] = $(this).find('.resultado').val();
                data[`novedad${i}`] = $(this).find('.novedad').val();
            });
            $.ajax({
                url: '<?php echo e(route('horarios.actualizar')); ?>',
                method: 'POST',
                data: data,
                success: function(response) {
                    if (response.success == false) {
                        alert('Ya existe un horario en alguna de las fechas o hay campos vacios');
                        $('[data-index="' + index + '"]').filter('input, select, button').prop('disabled', false);
                    } else {
                        deshabilitarElementosPorDataIndex(index);
                        alert('Horario asignado correctamente');
                        $('[data-index="' + index + '"]').filter('button').prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    alert('Error al asignar horario');
                }
            });
        });
    })(<?php echo e($loop->index); ?>);
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
});
</script>


<script>
$(document).ready(function() {
    <?php $__currentLoopData = $id_empleado; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    $(`.hora1[data-index='<?php echo e($loop->index); ?>']`).each(function() {
        flatpickr(this, {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: false,
        });
    });
    $(`.hora2[data-index='<?php echo e($loop->index); ?>']`).each(function() {
        flatpickr(this, {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: false,
        });
    });
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\people\resources\views/usuarios/editar-horario.blade.php ENDPATH**/ ?>