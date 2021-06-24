<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Mesero</title>
    <link href="<?php echo base_url(); ?>/css/dataTables.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/css/styles.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/css/platillos.css" rel="stylesheet" />
    <script src="<?php echo base_url(); ?>/js/all.min.js"></script>
    <script src="<?php echo base_url(); ?>/js/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body class="sb-nav-fixed">
    <?php $sesion = session(); ?>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="home">RBDuardo</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li>
                        <div class="d-flex justify-content-center h-100">
                            <div class="image_outer_container">
                                <div class="green_icon"></div>
                                <div class="image_inner_container">
                                    <img src="<?php echo base_url() . '/img/user.png' ?>">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li style="text-align: center;"> <?php echo $sesion->nombre . ' ' . $sesion->apellido; ?> </li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="<?php echo base_url('login/logout') ?>">
                            <div class="dropdown-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                            Logout
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <!--        MESAS       -->
                        <a class="nav-link" href="<?php echo base_url(); ?>/mesero/mesas">
                            <div class="sb-nav-link-icon"><i class="fas fa-calendar"></i></div>
                            Mesas
                        </a>
                        <!--        Cierre Mesas        -->

                        <!--    PEDIDOS   -->
                        <a class="nav-link" href="<?php echo base_url(); ?>/mesero/pedidos">
                            <div class="sb-nav-link-icon"><i class="fas fa-hand-holding"></i></div>
                            Pedidos
                        </a>
                        <!--    CIERRE PEDIDOS  -->
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Hola bienvenido:</div>
                    <?php $sesion = session(); ?>
                    <?php echo $sesion->nombre . ' ' . $sesion->apellido; ?>
                </div>
            </nav>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>