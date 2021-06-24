<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>RBDuardo Restaurant</title>
    <link href="<?php echo base_url(); ?>/css/dataTables.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/css/styles.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/css/platillos.css" rel="stylesheet" />
    <script src="<?php echo base_url(); ?>/js/all.min.js"></script>
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
            <!-- <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
            </div> -->
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
                                    <img src="<?php echo base_url() . '/img/user.png'?>" >
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
                        <div class="sb-sidenav-menu-heading">Personal</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseMeseros" aria-expanded="false" aria-controls="collapsePlatillos">
                            <div class="sb-nav-link-icon"><i class="fas fa-utensils"></i></div>
                            Meseros
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseMeseros" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link" href="<?php echo base_url(); ?>/admin/meseros">
                                    Meseros
                                </a>

                            </nav>
                        </div>
                        <!--    PLATILLOS   -->
                        <div class="sb-sidenav-menu-heading">Platillos</div>

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePlatillos" aria-expanded="false" aria-controls="collapsePlatillos">
                            <div class="sb-nav-link-icon"><i class="fas fa-utensils"></i></div>
                            Platillos
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePlatillos" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link" href="<?php echo base_url(); ?>/admin/platillos">
                                    Platillo
                                </a>
                                <a class="nav-link" href="<?php echo base_url(); ?>/admin/categorias">
                                    Categoría
                                </a>
                            </nav>
                        </div>

                        <!--        MESAS       -->
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseMesas" aria-expanded="false" aria-controls="collapseMesas">
                            <div class="sb-nav-link-icon"><i class="fas fa-calendar"></i></div>
                            Mesas
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseMesas" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link" href="<?php echo base_url(); ?>/admin/mesas">
                                    Mesa
                                </a>

                            </nav>
                        </div>
                        <!--        Cierre Mesas        -->

                        <!--    PEDIDOS   -->
                        <a class="nav-link" href="<?php echo base_url(); ?>/admin/pedidos">
                            <div class="sb-nav-link-icon"><i class="fas fa-hand-holding"></i></div>
                            Pedidos
                        </a>
                        <!--    CIERRE PEDIDOS  -->

                        <!--    Fin platillos   -->


                        <div class="sb-sidenav-menu-heading">Herramientas</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                            <div class="sb-nav-link-icon"><i class="fas fa-calendar-check"></i></div>
                            Reportes
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link" href="<?php echo base_url(); ?>/admin/reporte">
                                    Reporte diario
                                </a>
                                <a class="nav-link" href="<?php echo base_url(); ?>/admin/ticket">
                                    Tickets
                                </a>
                            </nav>
                        </div>
                        <a class="nav-link" href="home">
                            <div class="sb-nav-link-icon"><i class="fas fa-qrcode"></i></div>
                            Códigos QR
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Hola bienvenido:</div>

                    <?php echo $sesion->nombre . ' ' . $sesion->apellido; ?>
                </div>
            </nav>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
        <script src="<?php echo base_url('js/qr.js') ?>"></script>