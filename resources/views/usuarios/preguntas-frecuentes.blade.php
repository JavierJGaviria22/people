@extends('layouts.layout')

@section('title', 'SkaPeople - Preguntas')

@section('content')
<div class="pagetitle">
      <h1>Preguntas frecuentes</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="">Inicio</a></li>
          <li class="breadcrumb-item">Paginas</li>
          <li class="breadcrumb-item active">Preguntas Frecuentes</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section faq">
      <div class="row">
        <div class="col-lg-6">

          <div class="card basic">
            <div class="card-body">
              <h5 class="card-title"></h5>

              <div>
                <h6>1. ¿Que es People?</h6>
                <p> People es una <b> herramienta </b> que reúne toda la información que necesitas como empleado. 
                <b> Puedes ver tus vacaciones, permisos, registrar tu asistencia y conocer tu horario de forma 
                fácil.</b> Además, tiene un <b> calendario personalizado para que no te pierdas de noticias o 
                cumpleaños importantes.</b> ¡Todo en un solo lugar! </p>
              </div>

              <div class="pt-2">
                <h6>2. ¿Cual es el objetivo de People?</h6>
                <p> Centralizar y optimizar la gestión de información laboral para los empleados, permitiéndoles  
                  acceder de manera rápida y sencilla a sus vacaciones, permisos, asistencias y notificaciones  
                  importantes, mejorando la organización y la comunicación dentro de la empresa. </p>
              </div>
            </div>
          </div>

          <!-- F.A.Q Group 1 -->
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Ponchador</h5>

              <div class="accordion accordion-flush" id="faq-group-1">

                <div class="accordion-item">
                  <h2 class="accordion-header">
                    <button class="accordion-button collapsed" data-bs-target="#faqsOne-3" type="button" data-bs-toggle="collapse">
                      ¿Por qué es necesaria la ubicación para registrar mi asistencia?
                    </button>
                  </h2>
                  <div id="faqsOne-3" class="accordion-collapse collapse" data-bs-parent="#faq-group-1">
                    <div class="accordion-body">
                      La ubicación es un <b> requisito obligatorio para registrar tu asistencia </b> por lo cual debes tenerla activa la momento de ponchar, ya que permite verificar que te encuentras 
                      en la empresa o tienda correspondiente. Sin este requisito, no podrás completar el registro de tu asistencia.
                    </div>
                  </div>
                </div>

                <div class="accordion-item">
                  <h2 class="accordion-header">
                    <button class="accordion-button collapsed" data-bs-target="#faqsOne-2" type="button" data-bs-toggle="collapse">
                      ¿Puedo corregir un error al registrar mi asistencia?
                    </button>
                  </h2>
                  <div id="faqsOne-2" class="accordion-collapse collapse" data-bs-parent="#faq-group-1">
                    <div class="accordion-body">
                      Si, al registrar tu asistencia, aparecerá un botón de <b> "Deshacer" </b>  que te permitirá corregir cualquier error, 
                      como haber marcado un estado incorrecto. <b> Esta opción estará disponible por aproximadamente 1 a 2 minutos </b>, 
                      por lo que debes estar atento para corregirlo de inmediato.
                    </div>
                  </div>
                </div>

                <div class="accordion-item">
                  <h2 class="accordion-header">
                    <button class="accordion-button collapsed" data-bs-target="#faqsOne-4" type="button" data-bs-toggle="collapse">
                      ¿Para que sirven las Notas?
                    </button>
                  </h2>
                  <div id="faqsOne-4" class="accordion-collapse collapse" data-bs-parent="#faq-group-1">
                    <div class="accordion-body">
                     Las notas permiten <b> informar cualquier novedad relacionada con tu asistencia </b>,
                     de modo que tu jefe pueda tenerlo en cuenta.
                    </div>
                  </div>
                </div>

                <div class="accordion-item">
                  <h2 class="accordion-header">
                    <button class="accordion-button collapsed" data-bs-target="#faqsOne-5" type="button" data-bs-toggle="collapse">
                      ¿Debo ponchar mis Permisos?
                    </button>
                  </h2>
                  <div id="faqsOne-5" class="accordion-collapse collapse" data-bs-parent="#faq-group-1">
                    <div class="accordion-body">
                      Sí, al solicitar un permiso, en la  <b> sección de Ponchador </b> aparecerá la opción para registrar 
                      la <b> hora de salida y, en caso de regresar,</b> la hora de regreso.<b>  Si no regresas, solo debes finalizar tu jornada normalmente.</b>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End F.A.Q Group 1 -->
        </div>

        <div class="col-lg-6">

          <!-- F.A.Q Group 2 -->
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Permisos</h5>

              <div class="accordion accordion-flush" id="faq-group-2">

                <div class="accordion-item">
                  <h2 class="accordion-header">
                    <button class="accordion-button collapsed" data-bs-target="#faqsTwo-1" type="button" data-bs-toggle="collapse">
                      ¿Cómo puedo solicitar un permiso?
                    </button>
                  </h2>
                  <div id="faqsTwo-1" class="accordion-collapse collapse" data-bs-parent="#faq-group-2">
                    <div class="accordion-body">
                      Para solicitar un permiso, dirígete a la opción de <b> Solicitudes </b>, donde encontrarás la <b> sección de Permisos </b>. 
                      Allí podrás crear una nueva solicitud, <b> seleccionar el tipo de permiso, indicar la fecha de inicio y fin </b>, 
                      y enviarla a tu líder para su revisión y aprobación.
                    </div>
                  </div>
                </div>

                <div class="accordion-item">
                  <h2 class="accordion-header">
                    <button class="accordion-button collapsed" data-bs-target="#faqsTwo-2" type="button" data-bs-toggle="collapse">
                      ¿Qué tipos de permisos existen?
                    </button>
                  </h2>
                  <div id="faqsTwo-2" class="accordion-collapse collapse" data-bs-parent="#faq-group-2">
                    <div class="accordion-body">
                      Existen varios tipos de permisos disponibles:
                      <ul>
                        <li>PTO – Vacaciones</li>
                        <li>Cita Medica</li>
                        <li>Permiso Personal No Pago</li>
                    </ul>
                    
                    </div>
                  </div>
                </div>

                <div class="accordion-item">
                  <h2 class="accordion-header">
                    <button class="accordion-button collapsed" data-bs-target="#faqsTwo-3" type="button" data-bs-toggle="collapse">
                     ¿Como saber si mi permiso fue aprobado?
                    </button>
                  </h2>
                  <div id="faqsTwo-3" class="accordion-collapse collapse" data-bs-parent="#faq-group-2">
                    <div class="accordion-body">
                      Puedes visualizar el estado de tu permiso en la sección de <b> Inicio </b>, donde aparecerán tarjetas con los permisos 
                      aprobados y pendientes. También puedes acceder a la opción de <b> Solicitudes </b> y entrar a la <b> Sección de Permisos </b> para ver en qué estado 
                      se encuentran una vez que tu líder haya dado una respuesta.
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div><!-- End F.A.Q Group 2 -->

          <!-- F.A.Q Group 3 -->
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Calendario y Horario</h5>

              <div class="accordion accordion-flush" id="faq-group-3">

                <div class="accordion-item">
                  <h2 class="accordion-header">
                    <button class="accordion-button collapsed" data-bs-target="#faqsThree-1" type="button" data-bs-toggle="collapse">
                      ¿Donde puedo ver mi horario?
                    </button>
                  </h2>
                  <div id="faqsThree-1" class="accordion-collapse collapse" data-bs-parent="#faq-group-3">
                    <div class="accordion-body">
                      Tu horario lo puedes visualizar en la  <b> sección de Calendario </b>, podrás visualizar tu horario asignado por tu lider de manera mensual o semanal, 
                      lo que te permitirá organizar mejor tu tiempo y gestionar tus actividades con anticipación.
                    </div>
                  </div>
                </div>

                 <div class="accordion-item">
                  <h2 class="accordion-header">
                    <button class="accordion-button collapsed" data-bs-target="#faqsThree-3" type="button" data-bs-toggle="collapse">
                      ¿Cómo puedo ver mis vacaciones acumuladas?
                    </button>
                  </h2>
                  <div id="faqsThree-3" class="accordion-collapse collapse" data-bs-parent="#faq-group-3">
                    <div class="accordion-body">
                      Tus vacaciones se acumulan según tus horas de trabajo y las puedes visualizar en la <b> sección de Inicio </b>, 
                      dentro de la tarjeta que dice <b> PTO disponible </b>.
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End F.A.Q Group 3 -->
        </div>
      </div>
    </section>
@endsection