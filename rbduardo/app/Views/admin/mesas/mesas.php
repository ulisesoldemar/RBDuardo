<div id="layoutSidenav_content">
<main>
    <div class="container-fluid px-4">
        <h3 class="mt-4">Mesas</h3>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Mesas</li>
        </ol>

        <div>
            <p>
                <a href="<?php echo base_url();?>/admin/mesas/add" class="btn btn-success">
                    <i class="fas fa-plus-circle"></i>
                </a>
            </p>
        </div>
        
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Lista de mesas
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Zona</th>
                            <th>Personal a Cargo</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>


                        <?php 
                        if(!empty($datos)){
                            foreach ($datos as $row){ ?>
                        <tr>
                            <td><?php echo $row['idMesa']; ?></td>
                            <td><?php echo $row['zona']; ?></td>   
                            <td><?php echo $row['nombre']." ".$row['apellido']; ?></td> 
                            <td><?php if($row['ocupado']){ echo '<p>Ocupada</p>';}else{echo '<p>Libre</p>';} ?></td>   
                            <td style="text-align: center;">
                                <a href="<?php echo base_url() .'/admin/mesas/edit/'. $row['idMesa']; ?>" class="btn btn-warning">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            </td>
                            <td style="text-align: center;">
                                <a href="<?php echo base_url() .'/admin/mesas/delete/'. $row['idMesa']; ?>"  class="btn btn-danger">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                       
                        <?php }}?>

                        <!-- Si hay mesas sin personal -->
                        <?php if(!empty($datosNull)){

                                foreach ($datosNull as $row){ ?>
                        <tr>
                            <td><?php echo $row['idMesa']; ?></td>
                            <td><?php echo $row['zona']; ?></td>   
                            <td><?php echo $row['idPersonal']; ?></td>
                            <td><?php if($row['ocupado']){ echo '<p>Ocupada</p>';}else{echo '<p>Libre</p>';} ?></td>    
                            <td style="text-align: center;">
                                <a href="<?php echo base_url() .'/admin/mesas/edit/'. $row['idMesa']; ?>" class="btn btn-warning">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            </td>
                            <td style="text-align: center;">
                                <a href="<?php echo base_url() .'/admin/mesas/delete/'. $row['idMesa']; ?>"  class="btn btn-danger">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                       
                        <?php }} ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>