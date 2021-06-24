<?= $this->extend('cliente/layout/main'); ?>

<?= $this->section('title') ?>
Cuenta
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">
    <main>
        <header class="p-5 text-center bg-light">
            <h2 class="mb-3">Cuenta</h2>
        </header>
        <!-- Si hay un total, entonces sí existe la cuenta -->
        <?php if ($total) : ?>
            <table class="table table-light table-bordered text-center">
                <tbody>
                    <tr>
                        <th width="25%" class="tm-section-title">Platillo</th>
                        <th width="25%" class="tm-section-title">Cantidad</th>
                        <th width="25%" class="tm-section-title">Precio</th>
                        <th width="25%" class="tm-section-title">Subtotal</th>
                    </tr>
                    <?php foreach ($cuenta as $platillo) : ?>
                        <tr>
                            <!-- Aquí irán todos los productos en el carrito -->
                            <td width="25%" class="text-center tm-section"><?php echo $platillo['nombre'] ?></th>
                            <td width="25%" class="text-center tm-section"><?php echo $platillo['cantidad'] ?></th>
                            <td width="25%" class="text-center tm-section">$<?php echo number_format($platillo['precio'], 2) ?></th>
                            <td width="25%" class="text-center tm-section">$<?php echo number_format($platillo['subtotal'], 2) ?></th>
                        </tr>
                    <?php endforeach ?>
                    <tr>
                        <td colspan="3" align="right">
                            <h3 class="tm-section">Total</h3>
                        </td>
                        <!-- Lo que se va a formatear es el total de la cuenta-->
                        <td align="right">
                            <h3 class="tm-section text-center">$<?php echo number_format($total, 2) ?></h3>
                        </td>
                    </tr>
                </tbody>
            </table>
            <form action="" method="post">
                <button class="tm-btn tm-btn-primary" name="btnAction" type="submit" value="Pagar" onclick="if (!confirm('¿La cuenta es correcta? No podrás cancelar el pago después.')) return false;">Pagar</button>
            </form>
        <?php else : ?>
            <div class="alert succes-alert">
                <h3 class="text-center">No hay platillos en tu cuenta</h3>
            </div>
        <?php endif ?>
    </main>
</div>
<?= $this->endSection() ?>