<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h2 class="mt-4">Mesa: <?= $idMesa; ?></h2>
            <h2 class="mt-4">Platillos</h2>

            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="home">Home</a></li>
                <li class="breadcrumb-item active">Platillos</li>
            </ol>

            <div>
                <a href="<?php echo base_url(); ?>/mesero/mesas" class="btn btn-danger mb-4">
                    <i class="fas fa-undo-alt"></i>
                    Regresar
                </a>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Lista de platillos
                </div>
                <div class="card-body">
                    <form method="POST">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Imagen</th>
                                    <th>Precio</th>
                                    <th>Descripcion</th>
                                    <th>Categoria</th>
                                    <th>Cantidad</th>
                                    <th>Seleccionar</th>
                                </tr>
                            </thead>
                            <?php foreach ($datos as $row) : ?>
                                <?php $id = $row['idPlatillo'] ?>
                                <tr>
                                    <td><?php echo $id; ?></td>
                                    <td id="nombre-<?= $id; ?>"><?php echo $row['nombre']; ?></td>
                                    <td>
                                        <img src="<?php echo base_url() . '/img/' . $row['imagen']; ?>" class="img-thumbnail rounded" style="max-width: 100px;" alt="<?php echo $row['imagen']; ?>">
                                    </td>
                                    <td><?php echo $row['precio']; ?></td>
                                    <td><?php echo $row['descripcion']; ?></td>
                                    <td><?php echo $row['nombreCat']; ?></td>
                                    <td>
                                        <input name="cantidad" id="cantidad-<?php echo $id ?>" type="number" value="0" min="0" step="1" disabled>
                                    </td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="platillos[<?php echo $id ?>]" onchange="setValue('<?php echo $id ?>', this)" value="" />
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                            <button class="btn btn-primary mb-4" name="btnPedido" id="ordenar" type="submit" value="Ordenar" onclick="return sendOrder();" disabled>
                                <i class="fas fa-marker"></i>
                                Hacer pedido
                            </button>
                            <br>
                            <input type="text" name="comentario" id="comentario" class="form-control mb-4" placeholder="Comentario de preparación">
                        </table>
                    </form>
                </div>
            </div>
    </main>
    <script>
        const pedido = [];

        $("input[name='cantidad']").TouchSpin({
            verticalbuttons: true,
            verticalupclass: 'glyphicon glyphicon-plus',
            verticaldownclass: 'glyphicon glyphicon-minus'
        });

        function setValue(id, element) {
            document.getElementById('ordenar').disabled = !element.checked;
            var spinbox = document.getElementById('cantidad-' + id);
            spinbox.disabled = !element.checked;
            var nombre = document.getElementById('nombre-' + id).textContent;
            var producto = {
                nombre: nombre,
                cantidad: 1
            };
            if (element.checked) {
                spinbox.value = 1;
                spinbox.min = 1;
                element.value = 1;
            } else {
                spinbox.value = 0;
                pedido.pop(producto);
                console.log(pedido);
                return;
            }
            spinbox.addEventListener("change", function() {
                element.value = spinbox.value;
                producto.cantidad = Number(element.value);
                console.log(pedido);
            });
            pedido.push(producto);
            console.log(pedido);
        }

        var conn = new WebSocket('ws://localhost:8080');

        conn.onmessage = function(e) {
            console.log(e);
        };

        function sendOrder() {
            if (!confirm('¿Estás seguro de enviar este pedido? Ya no podrás modificarlo más adelante.')) {
                return false;
            }
            platillos = [];
            cantidades = [];
            for (let i = 0; i < pedido.length; ++i) {
                platillos.push(pedido[i].nombre);
                cantidades.push(pedido[i].cantidad);
            }
            conn.send(JSON.stringify({
                command: "message",
                from: "mesero-<?= session()->get('idPersonal'); ?>",
                to: "cocina",
                message: JSON.stringify({
                    mesa: '<?= $idMesa; ?>',
                    idPedido: <?= $idPedido; ?>,
                    platillo: platillos,
                    cantidad: cantidades,
                    comentario: document.getElementById('comentario').value
                })
            }));
        }
    </script>