<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h2 class="mt-4">Mesas abiertas</h2>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="home">Inicio</a></li>
                <li class="breadcrumb-item active">Mesas</li>
            </ol>

            <div>
                <p>
                    <a href="<?php echo base_url(); ?>/mesero/abrir" class="btn btn-success">
                        <i class="fas fa-plus-circle"></i>
                        Abrir mesa nueva
                    </a>
                </p>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Mesas ocupadas
                </div>
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4">
                        <?php foreach ($datos as $mesas) : ?>
                            <form method="post">
                                <div class="card col" style="height: 10rem; border-radius: 5%;">
                                    <button id="btn-abrir-mesa" style="background-color: #198754; border-radius: 5%; margin-bottom: 6px; border: 0px;" class="card-body btn-abrir-mesa" type="submit" name="btnMesa" value="<?php echo $mesas['idMesa'] ?>">
                                        <h1 class="position-absolute start-50 translate-middle" style="color: white;">
                                            <?php echo $mesas['idMesa'] ?>
                                        </h1>
                                    </button>
                                    <button class="btn btn-danger" type="submit" name="btnCerrarMesa" value="<?php echo $mesas['idMesa'] ?>" onclick="return confirm('¿La cuenta es correcta? No podrás cancelar el pago después.');">
                                        <h1 class="fas fa-bullhorn"></h1>
                                        Solicitar cuenta
                                    </button>
                                </div>
                            </form>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>
        </div>
    </main>