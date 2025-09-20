

<?php $__env->startSection('title', 'SkaPeople - Horarios'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Titulo de pagina -->
    <div class="pagetitle">
        <h1><?php echo e($accion); ?> Horario</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('/')); ?>">Inicio</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('mis-permisos')); ?>">Horarios</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('nuevo-permiso')); ?>"><?php echo e($accion); ?> Horario</a></li>
            </ol>
        </nav>
    </div> <!-- Fin titulo de pagina -->

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-body ">
                        <h5 class="card-title">Seleccion de empleado y rango de fechas</h5>

                        <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <p><?php echo e($error); ?></p>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           
                        </div>
                        <?php endif; ?>

                        <?php if(session('errores')): ?>
                        <div class="alert alert-danger">
                           
                                <?php $__currentLoopData = session('errores'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <p style="margin: 0"><?php echo e($error); ?></p>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                        </div>
                        <?php endif; ?>

                        <!-- General Form Elements -->
                        <form action="<?php echo e(route('horarios.store')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="accion" value="<?php echo e($accion); ?>">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Empleado</label>
                                <div class="col-sm-10">
                                    <select name="empleado[]" class="form-select" id="empleadoSelect" multiple="multiple"
                                        required>
                                        <?php $__currentLoopData = $empleados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empleado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($empleado->id_empleado); ?>"
                                                <?php echo e(in_array($empleado->id_empleado, old('empleado', [])) ? 'selected' : ''); ?>>
                                                <?php echo e($empleado->nombre); ?> <?php echo e($empleado->apellido); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <small class="form-text text-muted">Puedes seleccionar hasta 3 empleados.</small>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="datetime2" class="col-sm-2 col-form-label">Fecha Inicio</label>
                                <div class="col-sm-10">
                                    <input type="text" id="datetime2" name="fecha_inicio" class="form-control"
                                        value="<?php echo e(old('fecha_inicio')); ?>" placeholder="" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="datetime" class="col-sm-2 col-form-label">Fecha Fin</label>
                                <div class="col-sm-10">
                                    <input type="text" id="datetime" name="fecha_fin" class="form-control"
                                        value="<?php echo e(old('fecha_fin')); ?>" placeholder="" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- <label class="col-sm-2 col-form-label"></label> -->
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Asignar</button>
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

    <script>
        $(document).ready(function() {
            $('#empleadoSelect').select2({
                placeholder: "",
                maximumSelectionLength: 3,
                width: '100%',
                language: {
                    maximumSelected: function(args) {
                        return "Solo puedes seleccionar hasta 3 empleados";
                    }
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\people\resources\views/usuarios/nuevo-horario.blade.php ENDPATH**/ ?>