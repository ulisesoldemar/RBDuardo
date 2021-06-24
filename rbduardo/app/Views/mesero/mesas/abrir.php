<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h2 class="mt-4">Tus mesas</h2>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="home">Inicio</a></li>
                <li class="breadcrumb-item"><a href="mesas">Mesas</a></li>
                <li class="breadcrumb-item active">Abrir mesa</li>
            </ol>
            <div>
                <p>
                    <a href="<?php echo base_url(); ?>/Mesero/mesas" class="btn btn-danger">
                        <i class="fas fa-undo-alt"></i>
                        Regresar
                    </a>
                </p>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Mesas disponibles
                </div>
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4">
                        <?php foreach ($datos as $mesas) : ?>
                            <form method="post">
                                <div class="card col" style="height: 10rem; border-radius: 5%;">
                                    <button style="background-color: #198754; border-radius: 5%; margin-bottom: 6px; border: 0px;" class="card-body btn-abrir-mesa" type="submit" name="btnMesa" value="<?php echo $mesas['idMesa'] ?>">
                                        <h1 class="position-absolute top-50 start-50 translate-middle" style="color: white;">
                                            <?php echo $mesas['idMesa'] ?>
                                        </h1>
                                    </button>
                                </div>
                            </form>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>