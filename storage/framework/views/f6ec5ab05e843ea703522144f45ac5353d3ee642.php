<?php
$usuario = auth('g_usuarios')->user();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title><?php echo $__env->yieldContent('title', 'People - Dashboard'); ?></title>
    <meta content="" name="description">
    <meta content="" name="keywords">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMzB7s1r0BlxBrY7wD5qEV/7v4Z1j8khxF4V5x" crossorigin="anonymous">


    <!-- Favicons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="<?php echo e(asset('assets/img/favicon.png')); ?>" rel="icon">
    <link href="<?php echo e(asset('assets/img/apple-touch-icon.png')); ?>" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Vendor CSS Files -->
    <link href="<?php echo e(asset('assets/vendor/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/vendor/boxicons/css/boxicons.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/vendor/quill/quill.snow.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/vendor/quill/quill.bubble.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/vendor/remixicon/remixicon.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/vendor/simple-datatables/style.css')); ?>" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="<?php echo e(asset('assets/css/style.css')); ?>" rel="stylesheet">

    <!-- Incluye CSS de Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Incluye JavaScript de JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Incluye JavaScript de Flatpickr -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS Bundle (incluye Popper) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

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
                <span class="d-none d-lg-block"><?php echo e($info_empleados->sede); ?></span>
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

                        <?php $__currentLoopData = $notificaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notificacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="notification-item">
                            <i class="bi bi-info-circle text-primary"></i>
                            <div>
                                <h4><?php echo e($notificacion->titulo); ?></h4>
                                <p><?php echo e($notificacion->mensaje); ?></p>
                                <p style="text-align: end; font-weight: bold;">hace <?php echo e($notificacion->hace); ?> días</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <li class="dropdown-footer">
                            <a href="#">Todas las Notificaciones</a>
                        </li>

                    </ul><!-- End Notification Dropdown Items -->

                </li><!-- End Notification Nav -->


                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="<?php echo e(asset('assets/img/profile-img.jpg')); ?>" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo e($usuario->empleado->nombre); ?></span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?php echo e($usuario->empleado->nombre); ?> <?php echo e($usuario->empleado->apellido); ?></h6>
                            <span><?php echo e($usuario->empleado->cargo); ?></span>
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
                            <form action="<?php echo e(route('logout')); ?>" method="POST">
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
                    <a class="nav-link <?php echo e(Route::currentRouteName() === '/' ? '' : 'collapsed'); ?>" href="<?php echo e(route('/')); ?>">
                        <i class="bi bi-grid"></i>
                        <span>Inicio</span>
                    </a>
                </li><!-- Star Fichaje Nav -->

                <!-- End Fichaje Nav -->
                <li class="nav-item">
                    <a class="nav-link <?php echo e(Route::currentRouteName() === 'fichaje' ? '' : 'collapsed'); ?>" href="<?php echo e(route('fichaje')); ?>">
                        <i class="bi bi-clock"></i>
                        <span>Ponchador</span>
                    </a>
                </li><!-- End Fichaje Nav -->

                <!-- End calendario Nav -->
                <li class="nav-item">
                    <a class="nav-link <?php echo e(Route::currentRouteName() === 'calendario' ? '' : 'collapsed'); ?>" href="<?php echo e(route('calendario')); ?>">
                        <i class="bi bi-calendar"></i>
                        <span>Calendario</span>
                    </a>
                </li><!-- End calendario Nav -->

                <!-- Start Solicitudes Nav -->
                <li class="nav-item">

                <li class="nav-item">
                    <a class="nav-link <?php echo e(Route::currentRouteName() == 'mis-permisos' || Route::currentRouteName() == 'vacaciones' ? '' : 'collapsed'); ?>" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-menu-button-wide"></i><span>Solicitudes</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="components-nav" class="nav-content <?php echo e(Route::currentRouteName() === 'mis-permisos' || Route::currentRouteName() === 'vacaciones' ? '' : 'collapse'); ?> " data-bs-parent="#sidebar-nav">
                        <li>
                            <a class="<?php echo e(Route::currentRouteName() === 'mis-permisos' ? 'active' : ''); ?>" href="<?php echo e(route('mis-permisos')); ?>">
                                <i class="bi bi-circle"></i><span>Permisos</span>
                            </a>
                        </li>
                        <li>
                            <a class="" href="#">
                                <i class="bi bi-circle"></i><span>Documentos</span>
                            </a>
                        </li>


                    </ul>
                </li><!-- End Components Nav -->
                <?php
                if ($info_empleados->lider !== null) {
                ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(Route::currentRouteName() === 'permisos' ? '' : 'collapsed'); ?>" href="<?php echo e(route('permisos')); ?>">
                        <i class="bi bi-file-earmark"></i>
                        <span>Historial de Permisos</span>
                    </a>
                </li><!-- End Permisos para Lideres Nav -->

                <li class="nav-item">
                    <a class="nav-link <?php echo e(Route::currentRouteName() === 'horarios.index' ? '' : 'collapsed'); ?>" href="<?php echo e(route('horarios.index')); ?>">
                        <i class="bi bi-calendar"></i>
                        <span>Gestionar Horarios</span>
                    </a>
                </li><!-- End Gestion de Horarios Nav -->

                <li class="nav-item">
                    <a class="nav-link <?php echo e(Route::currentRouteName() === 'reporte-horas-l' ? '' : 'collapsed'); ?>" href="<?php echo e(route('reporte-horas-l')); ?>">
                        <i class="bi bi-graph-up"></i>
                        <span>Reportes</span>
                    </a>
                </li><!-- End Reportes Nav -->
                <?php
                }
                ?>
            </div>

            <div style="width: 100%;">
                <!-- Elementos al final del aside -->
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
    <script src="<?php echo e(asset('assets/vendor/simple-datatables/simple-datatables.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/tinymce/tinymce.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/php-email-form/validate.js')); ?>"></script>    

    <!-- Template Main JS File -->
    <script src="<?php echo e(asset('assets/js/main.js')); ?>"></script>
    <!-- Alertas Sweetalert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>

</html><?php /**PATH C:\laragon\www\people\resources\views/layouts/layout.blade.php ENDPATH**/ ?>