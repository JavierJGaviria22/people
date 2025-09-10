

<?php $__env->startSection('title', 'SkaPeople - Calendario'); ?>

<?php $__env->startSection('content'); ?>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

<script>
    var eventsData = JSON.parse(<?php echo json_encode($eventsJson, 15, 512) ?>);
    console.log(eventsData);

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            firstDay: 1,
            events: eventsData
        });

        calendar.render();
    });
</script>

<!-- Titulo de pagina -->
<div class="pagetitle">
    <h1>Calendario</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('/')); ?>"></a>Inicio</li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('/')); ?>"></a>Calendario</li>
            <!-- <li class="breadcrumb-item">Inicio</li> -->
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section dashboard">
    <div class="row">

        <div class="col-lg-12">
            <div id='calendar'></div>
        </div>

    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/backup/public_html/people/resources/views/usuarios/calendario-horarios.blade.php ENDPATH**/ ?>