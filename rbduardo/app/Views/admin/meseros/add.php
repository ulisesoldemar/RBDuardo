<div id="layoutSidenav_content">
<main>
    <div class="container-fluid px-4">
        <h3 class="mt-4">Agregar Mesero</h3>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Meseros</li>
        </ol>
        
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Nuevo mesero
            </div>
            <div class="card-body">

                <form method="POST" action="<?php echo base_url(); ?>/admin/meseros/insertar" enctype="multipart/form-data" autocomplete="off"> 
                    <div class="form-group">
                        <div class="row mb-3">
                            <div class="col-12 col-sm-6">
                                <label class="form-label"> Nombre </label>
                                <input type="text" name="nombre" id="nombre" class="form-control" autofocus require/>
                            </div>

                            <div class="col-12 col-sm-6">
                                <label class="form-label"> Apellidos </label>
                                <input type="text" name="apellido" id="apellido" class="form-control" require/>
                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-sm-6">
                                <label class="form-label"> Contraseña</label>
                                <input type="password" id="password" name="password" class="form-control" require/>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="form-label"> Rol </label>
                                <select class="form-select" name="rol" id="rol" required>
                                    <option value="administrador">Administrador</option>
                                    <option value="mesero">Mesero</option>
                                </select>
        
                            </div>
                        </div>   
                    </div>

                    <div class="row">
                            <div class="d-grid d-md-flex justify-content-md-end">
                                <a href="<?php echo base_url();?>/admin/meseros" class="btn btn-outline-secondary me-3"> Regresar </a>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                </form>
                
            </div>
        </div>
    </div>
</main>
                

             