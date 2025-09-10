@extends('layouts.layout')

@section('title', 'SkaPeople - Calendario')

@section('content')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

<script>
    var eventsData = JSON.parse(@json($eventsJson));
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
            <li class="breadcrumb-item"><a href="{{ route('/') }}"></a>Inicio</li>
            <li class="breadcrumb-item"><a href="{{ route('/') }}"></a>Calendario</li>
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
@endsection