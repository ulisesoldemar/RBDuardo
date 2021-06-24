<div id="layoutSidenav_content">
<main>
    <div class="container-fluid px-4">
        <h3 class="mt-4">Meseros</h3>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Meseros</li>
        </ol>

        <div>
            <p>
                <a href="<?php echo base_url();?>/admin/meseros/add" class="btn btn-success">
                    <i class="fas fa-plus-circle"></i>
                </a>
            </p>
        </div>
        
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Lista de meseros
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Contraseña</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Rol</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>


                        <?php foreach ($datos as $row){ ?>
                        <tr>
                            <td><?php echo $row['idPersonal']; ?></td>
                            <td><?php echo $row['password']; ?></td>   
                            <td><?php echo $row['nombre']; ?></td>   
                            <td><?php echo $row['apellido']; ?></td> 
                            <td><?php echo $row['rol']; ?></td>  
                            <td>
                                <a href="<?php echo base_url() .'/admin/meseros/edit/'. $row['idPersonal']; ?>" class="btn btn-warning">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url() .'/admin/meseros/delete/'. $row['idPersonal']; ?>"  class="btn btn-danger">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                       
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
                
