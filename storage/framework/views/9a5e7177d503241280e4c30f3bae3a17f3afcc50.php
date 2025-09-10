<?php $__env->startSection('title', 'SkaPeople - Dashboards'); ?>

<?php $__env->startSection('content'); ?>

<style>
    
.card {
    margin: 0px;
}
</style>

<!-- Titulo de pagina -->
<div class="pagetitle">
    <h1>Dashboards</h1>
    <nav>
        <ol class="breadcrumb">
            <a href="<?php echo e(route('/admin')); ?>">
                <li class="breadcrumb-item">Reportes e Informes</li>
            </a>
            <!-- <li class="breadcrumb-item">Inicio</li> -->
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section dashboard" style="zoom: 80%">
    
    <!--<iframe style="width:100%; height: 100vh;" title="Reporte People" width="600" height="373.5"-->
    <!--src="https://app.powerbi.com/view?r=eyJrIjoiODU4NDViYTEtMGM5Yi00ZjFlLThkYTYtZTYzMTkzODgxNTBkIiwidCI6IjYwN2ZkNTkyLWQyYWYtNDA5MC1iOWIwLTQ2NjBkYzZjYmYzOSJ9" frameborder="0" allowFullScreen="true"></iframe>-->
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <div class="d-flex flex-column flex-grow-1 me-2">
          <!-- Informe Nombre -->
          <h1 class="fw-bold me-3 mb-0">Informe de</h1>
          <div class="col-12 col-md-7">
            <select class="form-select w-100" aria-label="Default select example">
              <option selected>Open this select menu</option>
              <option value="1">One</option>
              <option value="2">Two</option>
              <option value="3">Three</option>
            </select>
          </div>
        </div>
        <!-- Filtro Fecha -->
        <div class="m-3">
          <div class="d-flex gap-2 flex-wrap">
            <input type="date" id="min" name="min" class="form-control">
            <input type="date" id="max" name="max" class="form-control">
          </div>
        </div>
      </div>

      <div class="mt-2">
        <div class="row">
          <!-- (Ciudad y Ventas) -->
          <div class="test col-lg-2 col-md-3 col-sm-6 col-12 d-flex" style= "flex-direction: column; justify-content: space-between;">
            <div class="card text-center p-4 bg-primary text-white mt-2">
              <h5>Elizabeth Avenue</h5>
            </div>
            <div class="card text-center p-4 bg-primary text-white mt-2">
              <h5>Bodega</h5>
            </div>
            <div class="card text-center p-3 mt-2">
              <h3>0.00</h3>
              <small class="text-muted">Suma de <br>pto_acumulado</small>
            </div>
            <div class="card text-center p-3 mt-2">
              <h3>0.00</h3>
              <small class="text-muted">Suma de <br> pto_utilizado</small>
            </div>
            <div class="card text-center p-3 mt-2">
              <h3>0.00</h3>
              <small class="text-muted">Suma de <br>pto_disponible</small>
            </div>
            <div class="card text-center p-3 mt-2">
              <h3>0.00</h3>
              <small class="text-muted">Suma de <br>Horas trabajadas</small>
            </div>
          </div>

          <!-- (Gráficos y Datos) -->
          <div class="col-lg-10 col-md-9 mt-2">
            <div class="row g-3">
              <!-- Gráfico de Llegadas Tarde -->
              <div class="col-lg-8">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Llegadas Tarde (Por Mes)</h5>
                    <div id="reportsChart" class="grafico"></div>
                  </div>
                </div>
              </div>
              <!-- Suma de llegadas tarde y Permisos -->
              <div class="col-lg-4 d-flex flex-column">
                <div class="row g-3">
                  <!-- Suma de Llegadas Tardes -->
                  <div class="col-6">
                    <div
                      class="card text-center p-1 bg-primary text-white d-flex align-items-center justify-content-center w-100 h-auto">
                      <h4>1</h4>
                      <small class="text-white">Llegada Tarde</small>
                    </div>
                  </div>
                  <!-- Suma de Permisos -->
                  <div class="col-6">
                    <div
                      class="card text-center p-1 bg-primary text-white d-flex align-items-center justify-content-center w-100 h-auto">
                      <h4>1</h4>
                      <small class="text-white">Permisos</small>
                    </div>
                  </div>
                </div>
                <!-- Permisos -->
                <div class="card mt-2" style="height: 100%;">
                  <div class="card-body">
                    <h5 class="card-title">Permisos</h5>
                    <ul class="list-group overflow-auto" style="max-height: 200px;">
                      <li class="list-group-item">Permiso 1</li>
                      <li class="list-group-item">Permiso 1</li>
             
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <!-- Gráfico de Horas Trabajadas -->
            <div class="row mt-2">
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Horas trabajadas (Por Mes)</h5>
                    <div id="columnChart"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</section>

<!-- Script de Graficos -->
  <script>
    /* Script de Grafico Llegadas Tarde */
    document.addEventListener("DOMContentLoaded", () => {
      new ApexCharts(document.querySelector("#reportsChart"), {
        series: [{ name: 'Sales', data: [31, 40, 28, 51, 42, 82, 56] }],
        chart: { height: 257, type: 'area', toolbar: { show: false } },
        markers: { size: 4 },
        colors: ['#4154f1'],
        fill: { type: "gradient", gradient: { opacityFrom: 0.3, opacityTo: 0.4 } },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 2 },
        xaxis: { type: 'datetime', categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z"] },
        tooltip: { x: { format: 'dd/MM/yy HH:mm' } }
      }).render();

      /* Script de Grafico Horas Trabajadas */
      new ApexCharts(document.querySelector("#columnChart"), {
        series: [{ name: 'Net Profit', data: [44, 55, 57, 56, 61, 58, 63, 60, 66] }],
        chart: { type: 'bar', height: 235 },
        plotOptions: { bar: { horizontal: false, columnWidth: '55%', endingShape: 'rounded' } },
        dataLabels: { enabled: false },
        stroke: { show: true, width: 2, colors: ['transparent'] },
        xaxis: { categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'] },
        yaxis: { title: { text: '$ (thousands)' } },
        fill: { opacity: 1 },
        tooltip: { y: { formatter: function (val) { return "$ " + val + " thousands" } } }
      }).render();
    });
  </script>
  <!-- Fin Sesion Dashboard -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\people\resources\views/admin/dashboards.blade.php ENDPATH**/ ?>