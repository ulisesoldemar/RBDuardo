<div id="layoutSidenav_content">
<main>
    <div class="container-fluid px-4">
        <h3 class="mt-4">Editar categoria</h3>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Categorias</li>
        </ol>
        
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Editar categoria
            </div>
            <div class="card-body">

                <!-- Configuracion para poder utilizar los errores -->
                <?php if (isset($validation)) { ?>
                    <div class="alert alert-danger">
                        <?php echo $validation->listErrors(); ?>
                    </div>
                <?php } ?>

                <form method="POST" action="<?php echo base_url(); ?>/admin/categorias/actualizar" autocomplete="off">

                    <input type="hidden" value="<?php echo $datos['idCategoria']; ?>" name="idCategoria" />

                    <div class="form-group">
                        <div class="row mb-3">
                            <div class="col-12 col-sm-6">
                                <label class="form-label"> Nombre </label>
                                <input type="text" name="nombre" id="nombre" class="form-control" 
                                    autofocus 
                                    required
                                    value="<?php echo $datos['nombre']; ?>"
                                />
                            </div>
                            
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-sm-6">
                                <div class="d-grid d-md-flex justify-content-md-end">
                                    <a href="<?php echo base_url();?>/admin/categorias" class="btn btn-outline-secondary me-3"> Regresar </a>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
                
