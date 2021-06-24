<?= $this->extend('cliente/layout/main'); ?>

<?= $this->section('title') ?>
Pedido
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">
    <main>
        <header class="p-5 text-center bg-light">
            <h2 class="mb-3">Pedido actual</h2>
        </header>
        <?php if ($total_p) : ?>
            <table class="table table-light table-bordered text-center">
                <tbody>
                    <tr>
                        <th colspan="2" width="30%" class="tm-section-title">Platillo</th>
                        <th width="30%" class="tm-section-title">Cantidad</th>
                        <th width="10%" class="tm-section-title">--</th>
                    </tr>
                    <?php $encrypter = \Config\Services::encrypter(); ?>
                    <?php foreach ($pedido as $index => $platillo) : ?>
                        <tr>
                            <!-- Aquí van todos los productos en el pedido -->
                            <td width="30%" class="text-center tm-section">
                                <img class="card-img-top img-carrito" title="<?php echo $platillo['NOMBRE']; ?>" alt="Título" src="<?php echo base_url() . '/img/' . $platillo['IMAGEN']; ?>" onerror="this.onerror=null; this.src='<?php echo base_url('img/default-food.png'); ?>'" width="128px" height="128px">
                                </th>
                            <td width="30%" class="text-center tm-section"><?php echo $platillo['NOMBRE'] ?></th>
                            <td width="30%" class="text-center tm-section"><?php echo $platillo['CANTIDAD'] ?></th>
                            <td width="10%">
                                <form action="" method="post">
                                    <!-- Por seguridad, se encriptan los valores de las peticiones enviadas a post-->
                                    <input type="hidden" name="id" value="<?php echo base64_encode($encrypter->encrypt($index)); ?>">
                                    <button class="btn btn-danger" type="submit" name="btnAction" value="Eliminar"><i class="far fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <form action="" method="post">
                <input type="text" name="comentario" id="comentario" class="form-control" placeholder="Comentario de preparación" size="50%">
                <br>
                <button class="tm-btn tm-btn-primary" name="btnAction" id="ordenar" type="submit" value="Ordenar">Ordenar</button>
            </form>

        <?php else : ?>
            <div class="alert succes-alert">
                <h3 class="text-center">No hay platillos en tu pedido</h3>
            </div>
        <?php endif ?>
    </main>
</div>
<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script>
    $(function() {
        var conn = new WebSocket('ws://localhost:8080');

        conn.onmessage = function(e) {
            console.log(e);
        };

        $('#ordenar').on('click', function() {
            if (!confirm('¿Estás seguro de enviar este pedido? Ya no podrás modificarlo más adelante.'))
                return false;
            platillo = [];
            cantidad = [];
            <?php foreach (session()->get('PEDIDO')['PRODUCTOS'] as $index => $platillo) : ?>
                platillo.push('<?= $platillo['NOMBRE']; ?>'),
                cantidad.push('<?= $platillo['CANTIDAD']; ?>'),
            <?php endforeach ?>
            conn.send(JSON.stringify({
                command: "message",
                from: "mesa-<?= session()->get('PEDIDO')['MESA']; ?>",
                to: "cocina",
                message: JSON.stringify({
                    mesa: '<?= session()->get('PEDIDO')['MESA']; ?>',
                    idPedido: '<?= $idPedido ?>',
                    platillo: platillo,
                    cantidad: cantidad,
                    comentario: document.getElementById('comentario').value
                })
            }));

        });
    });
</script>
<?= $this->endSection() ?>