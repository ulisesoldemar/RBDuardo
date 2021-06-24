<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h3 class="mt-4 mb-4">Listado de pedidos</h3>

            <div>
                <p>
                    <a href="<?php echo base_url(); ?>/admin/platillos/add" class="btn btn-primary">
                        <i class="fas fa-broom"></i>
                        Limpiar pedidos
                    </a>
                </p>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Pedidos
                </div>

                <div class="card-body">

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="panel">

                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>IdPedido</th>
                                        <th>Hora</th>
                                        <th>Total</th>
                                        <th>Comentario</th>
                                        <th>Mesa</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($datos as $row) { ?>
                                        <tr>
                                            <td><?php echo $row['idPedido']; ?></td>
                                            <td><?php echo $row['hora']; ?></td>
                                            <td><?php echo '$ ' . $row['totalPedido']; ?></td>
                                            <td><?php echo $row['comentario']; ?></td>
                                            <td><?php echo $row['idMesa']; ?></td>
                                            <td style="text-align: center;">
                                                <a href="<?php echo base_url() . '/admin/meseros/delete/' . $row['idPedido']; ?>" class="btn btn-danger">
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
            </div>
        </div>
    </main>