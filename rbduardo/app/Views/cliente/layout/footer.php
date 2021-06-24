<!--boton flotante -->
<a class="btn-flotante">Llamar Mesero</a>
<div class="btn-flotante-group">
    <div class="btn-flotante-li">
        <a href="<?php echo base_url('cliente/cuenta'); ?>">Solicitar cuenta</a>
    </div>
    <button class="btn-flotante-li" id="solicitar">Solicitar asistencia</button>

</div>
<script>
    $(function() {
        var conn = new WebSocket('ws://localhost:8080');
        var mesa = 'mesa-<?= session()->get('PEDIDO')['MESA']; ?>';
        var mesero = 'mesero-<?= session()->get('PEDIDO')['MESERO']; ?>';

        conn.onopen = function(e) {
            console.log("Connection established!");
            // Al momento de acceder a la sesión, se registra en el servidor
            conn.send(JSON.stringify({
                command: "register",
                userId: mesa
            }));
        };

        conn.onmessage = function(e) {
            console.log(e.data);
        };

        $('#solicitar').on('click', function() {
            if (!confirm('¿Llamar a mesero?'))
                return false;
            conn.send(JSON.stringify({
                command: "message",
                from: mesa,
                to: mesero,
                message: 'Te solicitan en la mesa <?= session()->get('PEDIDO')['MESA']; ?>'
            }));
        })
    })
</script>
<!-- Fin de boton flotante -->

<footer class="tm-footer text-center">
    <p>Copyright &copy; 2021 RBDuardo

        | Design: <a rel="nofollow" href="https://templatemo.com">TemplateMo</a></p>
</footer>