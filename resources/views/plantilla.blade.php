@extends('layouts.layout-test')

@section('title', 'Plantilla')

@section('content')
<!-- Titulo de pagina -->
<div class="title">
  <h1>Plantilla</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('/') }}"></a>Inicio</li>
      <li class="breadcrumb-item">Plantilla</li>
    </ol>
  </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section dashboard">
<input class="form-control" type="time" id="datetime" name="hora" required>
  
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#datetime", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: false,
        });
    });
</script>
@endsection