<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h3 class="mt-4">Editar mesa</h3>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Mesas</li>
            </ol>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Editar mesa
                </div>
                <div class="card-body">

                    <form method="POST" action="<?php echo base_url(); ?>/admin/mesas/actualizar" autocomplete="off">

                        <input type="hidden" value="<?php echo $datos['idMesa']; ?>" name="idMesa" />

                        <div class="form-group">
                            <div class="row mb-3">
                                <div class="col-12 col-sm-6">
                                    <label class="form-label"> Zona </label>
                                    <input type="text" name="zona" id="zona" class="form-control" autofocus require value="<?php echo $datos['zona']; ?>" />
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label class="form-label"> Personal a Cargo </label>
                                    <select class="form-select" name="idPersonal" id="idPersonal" required>
                                        <option value="0" selected>Ninguno</option>
                                        <?php foreach ($personal as $mesero) { ?>
                                            <option value="<?php echo $mesero['idPersonal']; ?>" 
                                            <?php if ($datos['idPersonal'] == $mesero['idPersonal']) { echo 'selected'; } ?>>
                                                <?php echo $mesero['nombre'] . " " . $mesero['apellido']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-sm-6">
                                    <label class="form-label"> Estado </label>
                                    <select class="form-select" name="ocupado" id="ocupado" required>
                                        <?php foreach ($estado as $key => $est) { ?>
                                            <option value="<?php echo $key; ?>" <?php if ($key == $datos['ocupado']) { echo 'selected'; } ?>
                                            > <?php echo $est; ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="d-grid d-md-flex justify-content-md-end">
                                <a href="<?php echo base_url(); ?>/admin/mesas" class="btn btn-outline-secondary me-3"> Regresar </a>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </main>