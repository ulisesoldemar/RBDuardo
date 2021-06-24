<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h3 class="mt-4 mb-4">Listado de tickets</h3>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Tickets
                </div>
                <div class="card-body">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="panel">

                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Folio</th>
                                        <th>Fecha</th>
                                        <th>Total</th>
                                        <th>Mesa</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($datos as $row) { ?>
                                        <tr>
                                            <td><?php echo $row['folioTicket']; ?></td>
                                            <td><?php echo $row['fecha']; ?></td>
                                            <td><?php echo '$ ' . $row['total']; ?></td>
                                            <td><?php echo $row['idMeza']; ?></td>
                                            <td style="text-align: center;">
                                                <a href="<?php echo base_url() . '/admin/ticket/mostrarticket/' . $row['folioTicket']; ?>" class="btn btn-primary">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                            </td>
                                            <td style="text-align: center;">
                                                <a onclick="return confirm('¿Estas seguro? Si borras el ticket, se borrarán todos los pedidos relacionados con este')" href="<?php echo base_url() . '/admin/ticket/delete/' . $row['folioTicket']; ?>" class="btn btn-danger">
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