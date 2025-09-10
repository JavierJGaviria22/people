<?php $__env->startSection('title', 'SkaPeople - Reportes'); ?>

<?php $__env->startSection('content'); ?>

<style>
    td {
        font-size: 13px;
    }

    label {
        padding: 0 0 17px 0;
    }

    body {
  font-family: Arial, sans-serif;
  padding: 20px;
}

table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  padding: 8px;
  border: 1px solid #ddd;
  text-align: left;
}

input[type="text"], input[type="date"] {
  margin: 10px;
}

/* Contenedor de la paginación */
#pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
}

/* Botones de paginación */
#pagination button {
  background-color: #f8f9fa; /* Fondo claro */
  border: 1px solid #ddd; /* Borde gris suave */
  padding: 8px 16px;
  margin: 0 5px;
  font-size: 14px;
  color: #495057; /* Texto oscuro */
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s, color 0.3s;
}

/* Efecto al pasar el mouse (hover) */
#pagination button:hover {
  background-color: #007bff; /* Fondo azul */
  color: white; /* Texto blanco */
  border-color: #007bff; /* Borde azul */
}

/* Estado del botón activo (página actual) */
#pagination button.active {
  background-color: #007bff;
  color: white;
  border-color: #007bff;
  font-weight: bold; /* Resalta la página actual */
}

/* Deshabilitar botones (si no hay más páginas) */
#pagination button:disabled {
  background-color: #e9ecef;
  color: #6c757d;
  cursor: not-allowed;
  border-color: #ddd;
}

</style>

<!-- Titulo de pagina -->
<div class="pagetitle">
    <h1>Reportes</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('/')); ?>"></a>Inicio</li>
            <li class="breadcrumb-item">Reportes e Informes</li>
        </ol>
    </nav>
</div> <!-- Fin titulo de pagina -->

<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Reporte de horas trabajadas</h5>
                    <p>Horas trabajadas por dia de cada empleado</p>
                   
                    <!-- Table with stripped rows -->
                    <div class="table-responsive">
                        <input type="text" id="search" placeholder="Empleado..." onkeyup="filterTable()">
  <label>Fecha Inicio: <input type="date" id="startDate" onchange="filterTable()"></label>
  <label>Fecha Fin: <input type="date" id="endDate" onchange="filterTable()"></label>

  <table id="dataTable">
    <thead>
        <tr>
            <th>Empleado</th>
            <th>Fecha</th>
            <th>Total Trabajado</th>
            <th>Total Asignado</th>
            <th>Notas</th>
            <th>Observaciones</th>
            <th>Detalle</th>
        </tr>
    </thead>
    <tbody>
        <?php $i=1; ?>
        <?php $__currentLoopData = $inconsistencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td> <?php echo e($info->empleado); ?> </td>
            <td> <?php echo e($info->fecha); ?> </td>
            <td> <?php echo e(number_format($info->total_trabajado, 2)); ?> </td>
            <td> <?php echo e($info->total_asignado); ?> </td>
            <td> <?php echo e($info->notas); ?> </td>
            <td> <?php echo e($info->observaciones); ?> </td>

            <td class="text-center">
                <a href="<?php echo e(route('nomina.edit', ['id_empleado' => $info->id_empleado, 'fecha' => $info->fecha])); ?>" class="btn btn-outline-primary btn-sm" title="Editar" target="_blank" rel="noopener noreferrer">
                    <i class="bi bi-eye"></i></a>
            </td>
        </tr>
        <?php $i++; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
  </table>

  <div id="pagination"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Table with stripped rows -->
</section>

<script>
  const rowsPerPage = 10;
let currentPage = 1;

const data = <?php echo json_encode($inconsistencias, 15, 512) ?>;

function displayTable() {
  const tableBody = document.querySelector('#dataTable tbody');
  const filteredData = filterData();  // Obtener los datos filtrados
  const paginatedData = paginate(filteredData);  // Paginamos los datos filtrados
  
  // Limpiar el contenido actual de la tabla
  tableBody.innerHTML = '';
  
  // Insertar las filas correspondientes a la página actual
  paginatedData.forEach(item => {
    const row = `<tr>
        <td>${item.empleado}</td>
        <td>${item.fecha}</td>
        <td>${Math.round(item.total_trabajado * 100) / 100}</td>
        <td>${item.total_asignado}</td>
        <td>${item.notas ? item.notas : '-'}</td>
        <td>${item.observaciones ? item.observaciones : '-'}</td>
        <td class="text-center">
          <a href="<?php echo e(url('reporte-detalle/')); ?>/${item.id_empleado}/${item.fecha}/show" class="btn btn-outline-primary btn-sm" title="Editar" target="_blank" rel="noopener noreferrer">
            <i class="bi bi-eye"></i>
          </a>
        </td>
    </tr>`;
    tableBody.innerHTML += row;
  });

  // Actualizamos los botones de la paginación basados en los datos filtrados
  displayPagination(filteredData.length);
}

function filterData() {
  const search = document.getElementById('search').value.toLowerCase();
  const startDate = document.getElementById('startDate').value;
  const endDate = document.getElementById('endDate').value;

  return data.filter(item => {
    const matchName = item.empleado.toLowerCase().includes(search);
    const matchDate = (!startDate || item.fecha >= startDate) && (!endDate || item.fecha <= endDate);
    return matchName && matchDate;
  });
}

function paginate(filteredData) {
  const startIndex = (currentPage - 1) * rowsPerPage;
  const endIndex = startIndex + rowsPerPage;
  return filteredData.slice(startIndex, endIndex);
}

function displayPagination(filteredLength) {
  const paginationDiv = document.getElementById('pagination');
  const totalPages = Math.ceil(filteredLength / rowsPerPage);
  
  paginationDiv.innerHTML = '';  // Limpiar paginación existente
  
  // Agregar botones de paginación solo en función de los datos filtrados
  for (let i = 1; i <= totalPages; i++) {
    const pageButton = document.createElement('button');
    pageButton.textContent = i;
    
    // Agregar clase 'active' si es la página actual
    if (i === currentPage) {
      pageButton.classList.add('active');
    }

    // Configurar la acción de cambio de página
    pageButton.onclick = function() {
      changePage(i);
    };
    
    // Agregar el botón a la paginación
    paginationDiv.appendChild(pageButton);
  }
}

function changePage(page) {
  currentPage = page;
  displayTable();  // Refrescar los datos de la tabla
  displayPagination(filterData().length);  // Actualizar los botones de paginación en base a los datos filtrados
}

filterTable = () => {
  currentPage = 1;
  displayTable();  // Mostrar la tabla con los datos filtrados
}

displayTable();  // Inicializar la tabla cuando se carga la página

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/backup/public_html/people/resources/views/usuarios/reporte-asistencia.blade.php ENDPATH**/ ?>