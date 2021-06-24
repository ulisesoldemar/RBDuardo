<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h2 class="mt-4 mb-4">Listado de pedidos</h2>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="home">Inicio</a></li>
                <li class="breadcrumb-item active">Pedidos</li>
            </ol>
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
                                        <th>Pedido</th>
                                        <th>Mesa</th>
                                        <th>Hora</th>
                                        <th>Total</th>
                                        <th>Comentario</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($datos as $row) { ?>
                                        <tr>
                                            <td><?php echo $row['idPedido']; ?></td>
                                            <td><?php echo $row['idMesa']; ?></td>
                                            <td><?php echo $row['hora']; ?></td>
                                            <td><?php echo '$' . number_format($row['totalPedido'], 2); ?></td>
                                            <td><?php echo $row['comentario']; ?></td>
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