<div id="layoutSidenav_content">
<main>
    <div class="container-fluid px-4">
        <h3 class="mt-4">Categoria</h3>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Categoria</li>
        </ol>

        <div>
            <p>
                <a href="<?php echo base_url();?>/admin/categorias/add" class="btn btn-success">
                    <i class="fas fa-plus-circle"></i>
                </a>
            </p>
        </div>
        
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Lista de categorias
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                        </tr>
                    </thead>
                    <tbody>


                        <?php foreach ($datos as $row){ ?>
                        <tr>
                            <td><?php echo $row['idCategoria']; ?></td>
                            <td><?php echo $row['nombre']; ?></td>   

                            <td style="text-align: center;">
                                <a href="<?php echo base_url() .'/admin/categorias/edit/'. $row['idCategoria']; ?>" class="btn btn-warning">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            </td>
                            <td style="text-align: center;">
                                <a href="<?php echo base_url() .'/admin/categorias/delete/'. $row['idCategoria']; ?>"  class="btn btn-danger">
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
                
