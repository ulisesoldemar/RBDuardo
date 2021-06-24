<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ContieneModel;
use App\Models\PedidoModel;
use App\Models\PedidoTicketModel;
use App\Models\TicketModel;

//Mismo nombre del archivo
class Ticket extends BaseController
{
    protected $ticket;
    protected $ticket_pedidos;
    protected $pedido;
    protected $contiene;

    public function __construct()
    {
        //Cargar el modelo para interactuar con el
        $this->ticket = new TicketModel();
        $this->ticket_pedidos = new PedidoTicketModel();
        $this->pedido = new PedidoModel();
        $this->contiene = new ContieneModel();
    }

    public function index()
    {
        if ($this->hasSession() and $this->session->rol == 'administrador') {

            //SELECT * FROM pedidos
            $tickets = $this->ticket->findAll();
            $data = ['datos' => $tickets];

            echo view('admin/header');
            echo view('admin/ticket/ticket', $data);
            echo view('admin/footer');
        } else {
            echo view('login');
        }
    }

    public function mostrarticket($folio)
    {
        //Validar que sea administrador
        if ($this->hasSession() and $this->session->rol == 'administrador') {
            $data = ['datos' => $folio];

            echo view('admin/header');
            echo view('admin/ticket/imprimir', $data);
            echo view('admin/footer');
        } else {
            echo view('login');
        }
    }


    public function generarticket($folio)
    {
        //Validar que sea administrador
        if ($this->hasSession() and $this->session->rol == 'administrador') {
            //Obtener todos los pedidos relacionados con ese ticket
            $venta = $this->ticket_pedidos->get_venta($folio);
            //Obtener todos los datos del ticket
            $ticket = $this->ticket->where('folioTicket', $folio)->first();
            //Generar un nuevo objeto para el PDF
            $pdf = new \FPDF('P', 'mm', array(80, 200));
            $pdf->AddPage();
            //Establece los margenes, el titulo y la fuente
            $pdf->SetMargins(10, 10, 10);
            $pdf->SetTitle("Ticket");
            $pdf->SetFont('Arial', 'B', 12);

            //Titulo del documento
            $pdf->Cell(60, 7, "RBDuardo Restaurant", 0, 1, 'C');
            $pdf->SetFont('Arial', '', 7);
            //Direccion
            $pdf->Cell(60, 3, 'Blvd. Gral. Marcelino Garcia Barragan 1421', 0, 1, 'C');
            $pdf->Cell(60, 3, 'Olimpica, 44430 Guadalajara, Jal', 0, 1, 'C');
            $pdf->Ln();

            $pdf->SetFont('Arial', 'B', 8);
            //Folio de ticket
            $pdf->Cell(10, 5, "Folio: ", 0, 0, 'L');
            $pdf->Cell(30, 5, $folio, 0, 1, 'L');

            $pdf->SetFont('Arial', '', 7);
            //Fecha y hora del ticket
            $pdf->Cell(10, 5, "Fecha: ", 0, 0, 'L');
            $pdf->Cell(25, 5, $ticket['fecha'], 0, 0, 'L');
            $pdf->Cell(10, 5, "Hora: ", 0, 0, 'L');
            $pdf->Cell(8, 5, $ticket['hora'], 0, 1, 'L');

            //Encabezado de la tabla
            $pdf->SetFont('Arial', '', 5);    //Letra Arial, negrita (Bold), tam. 5
            $pdf->Cell(60, 5, '__________________________________________________________________', 0, 1, 'C');
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(60, 5, 'CANT.       PLATILLO                          PRECIO    SUBTOTAL', 0, 1, 'C');
            $pdf->SetFont('Arial', '', 7);

            //Variables necesaras para hacer el recuento de pedidos
            $total = 0;
            $producto = [];
            $band = true;
            $notfound = false;

            //Iteracion para agrupar todos los platillos del mismo cliente (mesa)
            foreach ($venta as $row) {
                if ($band) {
                    //Agregar el primer dato al arreglo
                    array_push($producto, $row);
                    $band = false;
                } else {
                    foreach ($producto as $key => $pro) {

                        if ($pro['nombre'] == $row['nombre']) {
                            //Se encontro el pedido

                            //Calcular la nueva cantidad
                            $cantidad = $pro['cantPlatillos'];
                            $cantidad = $cantidad + $row['cantPlatillos'];
                            //Actializar la cantidad
                            $producto[$key]['cantPlatillos'] = $cantidad;

                            //Calcular el nuevo subtotal
                            $subtotal = $cantidad * $pro['precio'];
                            //Actualizar el subtotal y la cantidad del producto
                            $producto[$key]['subtotal'] = $subtotal;
                            $notfound = false;
                            break;
                        } else {
                            $notfound = true;
                        }
                    }
                    //Si no esta el dato en el arreglo entonces se agrega
                    if ($notfound) {
                        array_push($producto, $row);
                    }
                }
            }

            //Imprimir en el PDF todos los platillos con su respectivos campos
            foreach ($producto as $pro) {
                //Convertir a lenguaje español
                $title = utf8_decode($pro["nombre"]);

                $pdf->Cell(6, 5, $pro["cantPlatillos"], 0, 0, "L");
                $pdf->Cell(36, 5, strtoupper(substr($title , 0, 16)), 0, 0, 'L');
                $pdf->Cell(8, 5,   "$" . number_format($pro["precio"], 2, ".", ","), 0, 0, "R");
                $pdf->Cell(12, 5,  "$" . number_format($pro["subtotal"], 2, ".", ","), 0, 1, "R");

                //Suma el total de la venta
                $total = $total + $pro['subtotal'];
            }

            //TOTAL DE TICKET
            $pdf->Cell(60, 5, '_________________', 0, 1, 'R');
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(60, 5, 'TOTAL: $' . number_format($total, 2, ".", ","), 0, 1, 'R');
            $pdf->Cell(60, 5, 'IVA incluido', 0, 1, 'R');

            $pdf->Ln();
            $pdf->Cell(60, 7, 'GRACIAS POR TU COMPRA', 0, 1, 'C');

            //Configuracion para que se muestre en pantalla
            $this->response->setHeader('Content-Type', 'application/pdf');
            //Nombre del archivo
            $pdf->Output("ticket.pdf", "I");
        } else {
            echo view('login');
        }
    }

    public function delete($folio)
    {
        //Eliminar todos los registros de ese ticket
        //Valida que sea admin
        if ($this->hasSession() and $this->session->rol == 'administrador') {

            //Antes de eliminar los pedidos, se obtiene el id para poder eliminarlos de las demas tablas
            $pedidos = $this->ticket_pedidos->select_pedidos($folio);

            //Eliminar cada uno de los pedidos relacionados con ese ticket
            foreach ($pedidos as $ped) {
                //Buscar y eliminar el pedido de la tabla CONTIENE
                $this->contiene->where('idPedido', $ped['idPedido'])->delete();

                //Buscar y eliminar el pedido de la tabla PEDIDO
                $this->pedido->where('idPedido', $ped['idPedido'])->delete();
            }

            //DELETE * FROM ticket WHERE folioTicket = $folio - Elimina el primer elemento encontrado
            $this->ticket->where('folioTicket', $folio)->delete();

            //DELETE FROM ticket_pedidos WHERE folio = $folio - Elimina registros
            $this->ticket_pedidos->delete_data($folio);

            return redirect()->to(base_url('admin/ticket'));
        } else {
            echo view('login');
        }
    }
}
