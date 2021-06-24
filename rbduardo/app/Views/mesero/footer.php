<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; RBDuardo <?php echo date('Y'); ?> </div>
            <div>
                <a href="#">Politica de privacidad</a>
                &middot;
                <a href="#">Terminos &amp; condiciones</a>
            </div>
        </div>
    </div>
</footer>
<script>
    var conn = new WebSocket('ws://localhost:8080');
    conn.onopen = function(e) {
        console.log("Connection established!");
        conn.send(JSON.stringify({
            command: "register",
            userId: "mesero-<?= session()->get('idPersonal'); ?>"
        }));
        conn.send(JSON.stringify({
            command: "subscribe",
            channel: "mesero-<?= session()->get('idPersonal'); ?>"
        }));
    };

    conn.onmessage = function(e) {
        alert(e.data);
    };
</script>
<script src="<?php echo base_url(); ?>/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="<?php echo base_url(); ?>/js/scripts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<script src="<?php echo base_url(); ?>/js/datatables-simple-demo.js"></script>
</body>

</html>