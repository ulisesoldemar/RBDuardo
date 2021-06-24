<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Cocina</title>
    <link href="<?php echo base_url(); ?>/css/cocinaCSS/styles.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/css/cocinaCSS/journal.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/css/cocinaCSS/auth.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/css/cocinaCSS/buttons.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/css/cocinaCSS/notes.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/css/styles.css" rel="stylesheet" />
    <script src="<?php echo base_url(); ?>/js/jquery.min.js"></script>

</head>

<body class="sb-nav-fixed">
    <div class="journal__main-content">
        <aside class="journal__sidebar">
            <div class="journal__sidebar-navbar">
                <h5 class="mt-5">
                    <span> Comandas Cocina </span>
                </h5>
            </div>
            <div id="journal__entries">

            </div>
        </aside>

        <main>
            <div class="notes__main-content">
                <div class="notes__appbar">
                    <span class="blocktext">
                        <?php
                        $fecha = new DateTime('now', new DateTimeZone('America/Mexico_City'));
                        echo $fecha->format('d / m / Y');
                        ?>
                    </span>
                </div>
                <!-- Descripción de los pedidos -->
                <table class="table table-bordered" id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Pedido</th>
                            <th>Mesa</th>
                            <th>Dia</th>
                            <th>Hora</th>
                            <th>Platillo</th>
                            <th>Cantidad</th>
                            <th>Comentario</th>
                        </tr>
                    </thead>
                    <tbody id="descripcion">
                        <!-- <td id="platillos"></td>
                        <td id="cantidad"></td> -->
                    </tbody>
                    <button id="btn-Finalizado" class="btn btn-primary" disabled> Finalizar Pedido </button>
                </table>
            </div>
        </main>
    </div>
    <script>
        var conn = new WebSocket('ws://localhost:8080');

        conn.onopen = function(e) {
            console.log("Connection established!");
            conn.send(JSON.stringify({
                command: "register",
                userId: 'cocina'
            }));
        };

        conn.onmessage = function(e) {
            var pedido = JSON.parse(e.data);
            newOrder(pedido);
        };

        /* Añadir un div con cada una de las especificaciones del pedido a la cocina */
        function newOrder(msg) {
            const numIdPedidos = [];
            const dias = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
            const fecha = new Date();
            const dia = fecha.getDay();
            const nombre_dia = dias[dia];
            const hora = fecha.getHours() + ':' + fecha.getMinutes();
            const pedido = document.getElementById('journal__entries');
            const element = document.createElement('button');
            element.type = `button`;
            element.className = `journal__entry pointer`;
            element.name = 'name-btn-pedido';
            element.id = `btn-pedidos-${msg.idPedido}`;
            element.onclick = `botonFinalizar(this)`;
            element.innerHTML = `
                    <div class="journal__entry-body">
                        <p class="journal__entry-title"> Pedido: ` + msg.idPedido + `  | Mesa: ` + msg.mesa + `</p>
                    </div>
                    <div class="journal__entry-date-box">
                        <span> ` + nombre_dia + ` </span>
                        <h4>` + hora + `</h4>
                    </div>
                    `;
            pedido.appendChild(element);
            numIdPedidos.push(msg.idPedido);
            btnEventListener(msg, nombre_dia, hora, numIdPedidos);
        }

        function btnEventListener(msg, nombre_dia, hora, array) {
            /* let cont = msg.platillo.length; */
            const tabla = document.getElementById('descripcion');
            document.getElementById(`btn-pedidos-${msg.idPedido}`).addEventListener('click', function() {
                const element = document.createElement('tr');
                element.id = `descripcion-pedidos-${msg.idPedido}`;
                element.innerHTML = `
                    <td> ` + msg.idPedido + ` </td>
                    <td> ` + msg.mesa + `</td>
                    <td> ` + nombre_dia + `</td>
                    <td> ` + hora + `</td>
                    <td> ` + msg.platillo + `</td>
                    <td> ` + msg.cantidad + `</td>
                    <td>` + msg.comentario + `</td>
                `;

                tabla.appendChild(element);
                document.getElementById(`btn-pedidos-${msg.idPedido}`).disabled = true;
                document.getElementById(`btn-Finalizado`).disabled = false;
            });

            document.getElementById(`btn-Finalizado`).addEventListener('click', function() {
                for (let i = array.length - 1; i >= 0; i--) {
                    const btn = document.getElementById(`btn-pedidos-${array[i]}`);
                    const descripcion = document.getElementById(`descripcion-pedidos-${array[i]}`);
                    const btnPop = document.getElementById(`journal__entries`);
                    tabla.removeChild(descripcion);
                    btnPop.removeChild(btn);
                }
            });
            for (let i = 0; i < array.length - 1; i++)
                array.pop();
        }
    </script>
</body>

</html>