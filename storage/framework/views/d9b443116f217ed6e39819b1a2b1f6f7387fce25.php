<?php
    $admin = auth('g_administradores')->user();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title><?php echo $__env->yieldContent('title', 'People - Dashboard'); ?></title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="<?php echo e(asset('assets/img/favicon.png')); ?>" rel="icon">
    <link href="<?php echo e(asset('assets/img/apple-touch-icon.png')); ?>" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?php echo e(asset('assets/vendor/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/vendor/boxicons/css/boxicons.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/vendor/quill/quill.snow.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/vendor/quill/quill.bubble.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/vendor/remixicon/remixicon.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/vendor/simple-datatables/style.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <!-- Template Main CSS File -->
    <link href="<?php echo e(asset('assets/css/style.css')); ?>" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">


    <!-- Incluye CSS de Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Incluye JavaScript de JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <!-- Incluye JavaScript de Flatpickr -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS Bundle (incluye Popper) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

    <!-- Sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="<?php echo e(route('/')); ?>" class="logo d-flex align-items-center">
                <img src="<?php echo e(asset('assets/img/logo.png')); ?>" alt="">
                <span class="d-none d-lg-block"><?php echo e($info_admins->empresa); ?></span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="#">
                <input type="text" name="query" placeholder="Buscar" title="Enter search keyword">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
        </div><!-- End Search Bar -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->

                <!-- Inicio Seccion Notificaciones-->
                <li class="nav-item dropdown">

                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-primary badge-number"><?php echo e($nro_notificaciones); ?></span>
                    </a><!-- End Notification Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                        <li class="dropdown-header">
                            Tienes <?php echo e($nro_notificaciones); ?> nuevas notificaciones
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">Ver Todo</span></a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>


                        <li class="notification-item">
                            <i class="bi bi-info-circle text-primary"></i>
                            <div>
                                <h4>titulo</h4>
                                <p>mensaje</p>
                                <p style="text-align: end; font-weight: bold;">hace días</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>


                        <li class="dropdown-footer">
                            <a href="#">Todas las Notificaciones</a>
                        </li>

                    </ul><!-- End Notification Dropdown Items -->

                </li><!-- End Notification Nav -->


                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                        data-bs-toggle="dropdown">
                        <img src="<?php echo e(asset('assets/img/profile-img.jpg')); ?>" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo e($info_admins->nombre_admin); ?></span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?php echo e($info_admins->nombre_admin); ?></h6>
                            <span>Administrador</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="<?php echo e(route('mi-perfil')); ?>">
                                <i class="bi bi-person"></i>
                                <span>Mi Perfil</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="<?php echo e(route('faq')); ?>">
                                <i class="bi bi-question-circle"></i>
                                <span>Necesitas Ayuda?</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <form action="<?php echo e(route('A-logout')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button class="dropdown-item d-flex align-items-center" href="#">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Cerrar Sesion</span>
                                </button>
                            </form>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">
            <div style="width: 100%;">
                <li class="nav-item">
                    <a class="nav-link <?php echo e(Route::currentRouteName() === '/admin' ? '' : 'collapsed'); ?>"
                        href="<?php echo e(route('/admin')); ?>">
                        <i class="bi bi-grid"></i>
                        <span>Dashboard</span>
                    </a>
                </li><!-- Star Dashboard Nav -->

                <!-- Start Gestion de Asistencia Nav -->
                <li class="nav-item">
                    <a class="nav-link <?php echo e(Route::currentRouteName() === 'nomina.index' ? '' : 'collapsed'); ?>"
                        data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-clock"></i><span>Gestion de Nomina</span><i
                            class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="icons-nav"
                        class="nav-content <?php echo e(Route::currentRouteName() === 'nomina.index' || Route::currentRouteName() === 'vacaciones' ? '' : 'collapse'); ?> "
                        data-bs-parent="#sidebar-nav">
                        <li>
                            <a class="<?php echo e(Route::currentRouteName() === 'nomina.index' ? 'active' : ''); ?>"
                                href="<?php echo e(route('nomina.index')); ?>">
                                <i class="bi bi-circle"></i><span>Corregir Inconsistencias</span>
                            </a>
                        </li>
                        <li>
                            <a class="" href="#">
                                <i class="bi bi-circle"></i><span>Calcular Salarios</span>
                            </a>
                        </li>
                    </ul>
                </li><!-- End Gestion de Asistencia Nav -->


                <li class="nav-item">
                    <a class="nav-link <?php echo e((Route::currentRouteName() === 'contratos.index') | (Route::currentRouteName() === 'contratos.create') | (Route::currentRouteName() === 'contratos.edit') ? '' : 'collapsed'); ?>"
                        href="<?php echo e(route('contratos.index')); ?>">
                        <i class="bi bi-file-earmark-check"></i>
                        <span> Gestion de Contratos </span>
                    </a>
                </li><!-- End Gestion de Contratos Nav -->


                <li class="nav-item">
                    <a class="nav-link <?php echo e((Route::currentRouteName() === 'empleados') | (Route::currentRouteName() === 'nuevo-empleado') | (Route::currentRouteName() === 'editar-empleado') ? '' : 'collapsed'); ?>"
                        href="<?php echo e(route('empleados')); ?>">
                        <i class="bi bi-person-workspace"></i>
                        <span> Gestion de Empleados </span>
                    </a>
                </li><!-- End Gestion de Empleados Nav -->


                <li class="nav-item">
                    <a class="nav-link <?php echo e((Route::currentRouteName() === 'noticias.index') | (Route::currentRouteName() === 'noticias.create') | (Route::currentRouteName() === 'noticias.edit') ? '' : 'collapsed'); ?>"
                        href="<?php echo e(route('noticias.index')); ?>">
                        <i class="bi bi-newspaper"></i>
                        <span> Gestion de Noticias </span>
                    </a>
                </li><!-- End Gestion de Noticias Nav -->

                <li class="nav-item">
                    <a class="nav-link <?php echo e(Route::currentRouteName() === 'fichaje' ? '' : 'collapsed'); ?>"
                        href="#">
                        <i class="bi bi-file-earmark-text"></i>
                        <span> Gestion de Solicitudes </span>
                    </a>
                </li><!-- End Gestion de Solicitudes Nav -->

                <li class="nav-item">
                    <a class="nav-link <?php echo e((Route::currentRouteName() === 'horariosA.index') | (Route::currentRouteName() === 'horariosA.create') | (Route::currentRouteName() === 'horariosA.edit') ? '' : 'collapsed'); ?>"
                        href="<?php echo e(route('horariosA.index')); ?>">
                        <i class="bi bi-file-earmark-text"></i>
                        <span> Gestion de Horarios </span>
                    </a>
                </li><!-- End Gestion de horarios Nav -->

                <!-- Start Reportes Nav -->
                <li class="nav-item">
                    <a class="nav-link <?php echo e(Route::currentRouteName() === 'reporte-horas.index' || Route::currentRouteName() === 'nomina.audit-log' || Route::currentRouteName() === 'info-pto' || Route::currentRouteName() === 'dashboards' ? '' : 'collapsed'); ?>"
                        data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-graph-up"></i><span>Reportes e Informes</span><i
                            class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="components-nav"
                        class="nav-content <?php echo e(Route::currentRouteName() === 'dashboards' || Route::currentRouteName() === 'reporte-horas.index' || Route::currentRouteName() === 'nomina.audit-log' || Route::currentRouteName() === 'info-pto' ? '' : 'collapse'); ?> "
                        data-bs-parent="#sidebar-nav">
                        <li>
                            <a class="<?php echo e(Route::currentRouteName() === 'dashboards' ? 'active' : ''); ?>"
                                href="<?php echo e(route('dashboards')); ?>">
                                <i class="bi bi-circle"></i><span>Dashboard's</span>
                            </a>
                        </li>
                        <li>
                            <a class="<?php echo e(Route::currentRouteName() === 'nomina.audit-log' ? 'active' : ''); ?>"
                                href="<?php echo e(route('nomina.audit-log')); ?>">
                                <i class="bi bi-circle"></i><span>Registro de Auditoria</span>
                            </a>
                        </li>
                        <li>
                            <a class="<?php echo e(Route::currentRouteName() === 'reporte-horas.index' ? 'active' : ''); ?>"
                                href="<?php echo e(route('reporte-horas.index')); ?>">
                                <i class="bi bi-circle"></i><span>Reporte Ponchador</span>
                            </a>
                        </li>
                        <li>
                            <a class="<?php echo e(Route::currentRouteName() === 'info-pto' ? 'active' : ''); ?>"
                                href="<?php echo e(route('info-pto')); ?>">
                                <i class="bi bi-circle"></i><span>Informe PTO</span>
                            </a>
                        </li>
                    </ul>
                </li><!-- End Reportes Nav -->

            </div>

            <div style="width: 100%;">
                <li class="nav-item">
                    <a class="nav-link <?php echo e(Route::currentRouteName() === 'config' ? '' : 'collapsed'); ?>"
                        href="<?php echo e(route('config')); ?>">
                        <i class="bi bi-gear"></i>
                        <span> Configuración </span>
                    </a>
                </li><!-- End Configuracion Nav -->

            </div>

        </ul>

    </aside><!-- End Sidebar-->

    <main id="main" class="main">
        <?php echo $__env->yieldContent('content'); ?>
    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>SkaPeople</span></strong>. Todos los derechos reservados
        </div>
        <div class="credits">
            Desarrollado por <a href="#">Sistemas</a>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
    <!-- Vendor JS Files -->
    <script src="<?php echo e(asset('assets/vendor/apexcharts/apexcharts.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/chart.js/chart.umd.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/echarts/echarts.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/quill/quill.js')); ?>"></script>

    <!-- Elimina simple-datatables.js para evitar conflicto -->
    <!-- <script src="<?php echo e(asset('assets/vendor/simple-datatables/simple-datatables.js')); ?>"></script> -->

    <script src="<?php echo e(asset('assets/vendor/tinymce/tinymce.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/php-email-form/validate.js')); ?>"></script>

    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>




    <!-- Main JS File -->
    <script src="<?php echo e(asset('assets/js/main.js')); ?>"></script>

    <!-- Script para inicializar el DataTable -->
    <script>
        $(document).ready(function() {
            // Inicializa el DataTable
            $('.datatable').DataTable();
        });
    </script>


</body>

</html>
<?php /**PATH C:\laragon\www\people\resources\views/layouts/admin-layout.blade.php ENDPATH**/ ?>