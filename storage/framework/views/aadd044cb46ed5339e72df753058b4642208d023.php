

<?php $__env->startSection('title', 'SkaPeople - Permisos'); ?>

<?php $__env->startSection('content'); ?>
<!-- Titulo de pagina -->
<style>
    input::placeholder,
    select::placeholder {
        font-size: 15px;
        text-align: left;
    }
</style>
<div class="pagetitle">
    <h1>Nuevo Empleado</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('/admin')); ?>">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('empleados')); ?>">Empleados</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('nuevo-empleado')); ?>">Nuevo Empleado</a></li>
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section">
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
    <form action="<?php echo e(route('nuevo-empleado')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="row">

            <div class="col-lg-6">

                <div class="card">
                    <div class="card-body">

                        <h5 class="card-title">Informacion Personal</h5>

                        <!-- General Form Elements -->
                        <div class="row mb-3">
                            <label for="cedula" class="col-sm-4 col-form-label">Identificacion:</label>
                            <div class="col-sm-8">
                                <input type="text" id="cedula" name="cedula" class="form-control col-sm-1" value="<?php echo e(old('cedula')); ?>" placeholder="Ej: Cedula..." required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nombre" class="col-sm-3 col-form-label">Nombres:</label>
                            <div class="col-sm-9">
                                <input type="text" id="nombre" name="nombre" class="form-control col-sm-1" value="<?php echo e(old('nombre')); ?>" placeholder="Ej: Marcos..." required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="apellido" class="col-sm-3 col-form-label">Apellidos:</label>
                            <div class="col-sm-9">
                                <input type="text" id="apellido" name="apellido" class="form-control col-sm-1" value="<?php echo e(old('apellido')); ?>" placeholder="Ej: Fenix..." required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="datetime" class="col-sm-3 col-form-label">Nacimiento:</label>
                            <div class="col-sm-9">
                                <input type="text" id="datetime" name="nacimiento" class="form-control" value="<?php echo e(old('nacimiento')); ?>" placeholder="Ej: 1995-05-16" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="genero" class="col-sm-3 col-form-label">Genero:</label>
                            <div class="col-sm-9">
                                <select id="genero" name="genero" class="form-select" aria-label="Default select example" required>
                                    <option value="" selected disabled>Seleccionar</option>
                                    <option value="Masculino" <?php echo e(old('genero') == 'Masculino' ? 'selected' : ''); ?>>Masculino</option>
                                    <option value="Femenino" <?php echo e(old('genero') == 'Femenino' ? 'selected' : ''); ?>>Femenino</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-sm-3 col-form-label">E-mail:</label>
                            <div class="col-sm-9">
                                <input type="email" id="email" name="email" class="form-control col-sm-1" value="<?php echo e(old('email')); ?>" placeholder="Ej: Corre@gmail.com" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Segunda card -->

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Informacion Laboral</h5>
                        <!-- General Form Elements -->
                        <div class="row mb-3">
                            <label for="datetime2" class="col-sm-3 col-form-label">Ingreso:</label>
                            <div class="col-sm-9">
                                <input type="text" id="datetime2" name="ingreso" class="form-control" value="<?php echo e(old('ingreso')); ?>" placeholder="Ej: <?php echo e(today()->format('Y-m-d')); ?>" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="telefono" class="col-sm-3 col-form-label">Telefono:</label>
                            <div class="col-sm-9">
                                <input type="text" id="telefono" name="telefono" class="form-control col-sm-1" value="<?php echo e(old('telefono')); ?>" placeholder="Ej: 3216549871" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="estado-civil" class="col-sm-3 col-form-label">Estado Civil:</label>
                            <div class="col-sm-9">
                                <select id="estado-civil" name="estado-civil" class="form-select" aria-label="Default select example" required>
                                    <option value="" selected disabled>Seleccionar</option>
                                    <option value="Soltero" <?php echo e(old('estado-civil') == 'Soltero' ? 'selected' : ''); ?>>Soltero/a</option>
                                    <option value="Casado" <?php echo e(old('estado-civil') == 'Casado' ? 'selected' : ''); ?>>Casado/a</option>
                                    <option value="Divorciado" <?php echo e(old('estado-civil') == 'Divorciado' ? 'selected' : ''); ?>>Divorciado/a</option>
                                    <option value="Viudo" <?php echo e(old('estado-civil') == 'Viudo' ? 'selected' : ''); ?>>Viudo/a</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nhijos" class="col-sm-3 col-form-label">Nro Hijos:</label>
                            <div class="col-sm-9">
                                <input type="text" id="nhijos" name="nhijos" class="form-control col-sm-1" value="<?php echo e(old('nhijos')); ?>" placeholder="Ej: 2" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="dpto" class="col-sm-3 col-form-label">Dpto:</label>
                            <div class="col-sm-9">
                                <select id="dpto" name="dpto" class="form-select" aria-label="Default select example" required>
                                    <option value="" <?php echo e(old('dpto') ? '' : 'selected'); ?> disabled>Seleccionar</option>
                                    <?php $__currentLoopData = $selectDepartamentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dpto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($dpto->id_departamento); ?>" <?php echo e(old('dpto') == $dpto->id_departamento ? 'selected' : ''); ?>>
                                        <?php echo e($dpto->nombre); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="sede" class="col-sm-3 col-form-label">Sede:</label>
                            <div class="col-sm-9">
                                <select id="sede" name="sede" class="form-select" aria-label="Default select example" required>
                                    <option value="" <?php echo e(old('sede') ? '' : 'selected'); ?> disabled>Seleccionar</option>
                                    <?php $__currentLoopData = $selectSedes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sede): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($sede->id_sede); ?>" <?php echo e(old('sede') == $sede->id_sede ? 'selected' : ''); ?>>
                                        <?php echo e($sede->nombre); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row mb-12 justify-content-end">
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-primary">Agregar Empleado</button>
                </div>
            </div>
        </div>

    </form>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#datetime", {
            //  enableTime: true, // Habilita la selección de tiempo
            dateFormat: "Y-m-d", // Formato de fecha y hora
            // time_24hr: false, // Formato de 24 horas
            defaultDate: false, // Fecha por defecto
            //  minDate: "today" // No permite seleccionar fechas pasadas
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#datetime2", {
            // enableTime: true, // Habilita la selección de tiempo
            dateFormat: "Y-m-d", // Formato de fecha y hora
            time_24hr: false, // Formato de 24 horas
            defaultDate: false, // Fecha por defecto
            //minDate: "today" // No permite seleccionar fechas pasadas
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/backup/public_html/people/resources/views/admin/nuevo-empleado.blade.php ENDPATH**/ ?>