<div id="layoutSidenav_content">
<main>
    <div class="container-fluid px-4">
        <h3 class="mt-4">Platillos</h3>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Platillos</li>
        </ol>

        <div>
            <p>
                <a href="<?php echo base_url();?>/admin/platillos/add" class="btn btn-success">
                    <i class="fas fa-plus-circle"></i>
                </a>
            </p>
        </div>
        
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Lista de platillos
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Imagen</th>
                            <th>Precio</th>
                            <th>Descripcion</th>
                            <th>Categoria</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>


                        <?php foreach ($datos as $row){?>
                            
                        <tr>
                            <td><?php echo $row['idPlatillo']; ?></td>
                            <td><?php echo $row['nombre']; ?></td>   
                            <td><img src="<?php echo base_url() . '/img/' . $row['imagen']; ?>" 
                                     class="img-thumbnail rounded" 
                                     style="max-width: 100px;"
                                     alt="<?php echo $row['imagen'];?>">
                            </td>   
                            <td><?php echo $row['precio']; ?></td> 
                            <td><?php echo $row['descripcion']; ?></td>
                            <td><?php echo $row['nombreCat']; ?></td>  
                            <td style="text-align: center;">
                                <a href="<?php echo base_url() .'/admin/platillos/edit/'. $row['idPlatillo']; ?>" class="btn btn-warning">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            </td>
                            <td style="text-align: center;">
                                <a href="<?php echo base_url() .'/admin/platillos/delete/'. $row['idPlatillo']; ?>"  class="btn btn-danger">
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
                
