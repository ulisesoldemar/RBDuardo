<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Códigos QR</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                <li class="breadcrumb-item active">Códigos QR para mesas</li>
            </ol>
            <label class="form-label">Mesa para el QR</label>
            <select class="form-select" id="qr-text">
                <option value="" selected>Selecciona una mesa para general el código</option>
                <?php foreach ($mesas as $mesa) : ?>
                    <option value="<?php echo base_url('cliente/home/' .'setmesa/'. $mesa['idMesa']); ?>">
                        <?php echo $mesa['idMesa'] . ' - ' . $mesa['zona']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <br>
            <button class="btn btn-primary" type="submit" onclick="generateQRCode(); return false;">Aceptar</button>
            <br>
            <br>
            <canvas id="qr-code"></canvas>
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
    <script src="<?php echo base_url('js/qr.js') ?>"></script>