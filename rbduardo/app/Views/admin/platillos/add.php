<div id="layoutSidenav_content">
<main>
    <div class="container-fluid px-4">
        <h3 class="mt-4">Agregar platillo</h3>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Platillos</li>
        </ol>
        
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Nuevo platillo
            </div>
            <div class="card-body">

                <!-- Configuracion para poder utilizar los errores -->
                <?php if (isset($validation)) { ?>
                    <div class="alert alert-danger">
                        <?php echo $validation->listErrors(); ?>
                    </div>
                <?php } ?>

                <form method="POST" action="<?php echo base_url(); ?>/admin/platillos/insertar" enctype="multipart/form-data" autocomplete="off"> 
                    
                    <div class="form-group">
                        <div class="row mb-3">
                            <div class="col-12 col-sm-6">
                                <label class="form-label"> Nombre </label>
                                <input type="text" name="nombre" id="nombre" class="form-control" autofocus required
                                value="<?php echo set_value('nombre'); ?>"/>
                            </div>

                            <div class="col-12 col-sm-6">
                                <label class="form-label"> Precio </label>
                                <input type="text" name="precio" id="precio" class="form-control" required
                                value="<?php echo set_value('precio'); ?>"/>
                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-sm-6">
                                <label class="form-label"> Imagen </label>
                                <div class="input-group">
                                    <input type="file" class="form-control" name="imagen" id="imagen" 
                                    aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="form-label"> Descripcion </label>
                                <textarea class="form-control" name="descripcion" id="descripcion" 
                                aria-label="With textarea" required
                                value="<?php echo set_value('descripcion'); ?>"></textarea>
                            </div>
                        </div>   
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-sm-6">
                            <label class="form-label"> Categoria </label>
                            <select class="form-select" name="idCategoria" id="idCategoria" required>
                                <option value="" selected>Selecciona la categoria</option>
                                <?php foreach($categorias as $categoria) { ?>
                                    <option value="<?php echo $categoria['idCategoria']; ?>"><?php echo $categoria['nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                            <div class="d-grid d-md-flex justify-content-md-end">
                                <a href="<?php echo base_url();?>/admin/platillos" class="btn btn-outline-secondary me-3"> Regresar </a>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                </form>
                
            </div>
        </div>
    </div>
</main>
                
