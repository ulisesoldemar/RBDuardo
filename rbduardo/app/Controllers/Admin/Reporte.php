<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PedidoModel;
use App\Models\TicketModel;

//Mismo nombre del archivo
class Reporte extends BaseController
{

    protected $perdido, $ticket;

    public function __construct()
    {
        $this->pedido = new PedidoModel();
        $this->ticket = new TicketModel();
    }

    public function index()
    {
        if ($this->hasSession() and $this->session->rol == 'administrador') {

            echo view('admin/header');
            echo view('admin/reportes/reporte');
            echo view('admin/footer');
        } else {
            echo view('login');
        }
    }

    public function mostrarReporte()
    {
        //Verifica que sea administrador
        if ($this->hasSession() and $this->session->rol == 'administrador') {

            //Obtiene los datos del formulario
            $data = [
                'dateStart' => $this->request->getPost('fecha-inicio'),
                'dateEnd' => $this->request->getPost('fecha-fin')
            ];

            echo view('admin/header');
            echo view('admin/reportes/imprimir', $data);
            echo view('admin/footer');
        } else {
            echo view('login');
        }
    }

    public function generarReporte($dateStart, $dateEnd)
    {
        //Verifica que sea administrador
        if ($this->hasSession() and $this->session->rol == 'administrador') {
            //Obtiene todos los tickets dependiendo de la fecha especificada
            $tickets = $this->ticket->reporte($dateStart, $dateEnd);

            date_default_timezone_set('America/Mexico_City');
            //Obtiene la fecha y la hora del reporte
            $hoy = date("Y-m-d H:i:s");

            $pdf = new \FPDF('P', 'mm', 'letter');
            $pdf->AddPage();
            $pdf->SetMargins(10, 10, 10);
            $pdf->SetTitle("Reporte de ventas");
            $pdf->SetFont('Arial', 'B', 10);
            /** HEADER **/
            //Agregar celda Ancho, Alto, Titulo, Borde, salto de linea, posicion.
            $pdf->Cell(195, 5, utf8_decode("Reporte de ventas"), 0, 1, 'C');
            $pdf->Ln();
            //Asignar la fuente
            $pdf->SetFont('Arial', 'B', 9);
            //Imagenes File, x, y, width, height, type
            //$pdf->Image(base_url() . '/img/logo.png', 185, 10, 20, 20, 'PNG');
            $pdf->Cell(50, 5, "Rbduardo Restaurant", 0, 1, 'L');
            $pdf->Cell(30, 5, "Fecha del reporte: ", 0, 0, 'L');
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(25, 5, $hoy, 0, 1, 'L');
            $pdf->Ln();
            /** BODY **/
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetFillColor(0, 0, 0,);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->Cell(150, 5, "Detalle de ventas", 1, 1, 'C', 1);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(15, 5, 'No.', 1, 0, 'L');
            $pdf->Cell(30, 5, 'Folio Ticket', 1, 0, 'L');
            $pdf->Cell(45, 5, 'Fecha y hora', 1, 0, 'L');
            $pdf->Cell(35, 5, 'Importe ticket', 1, 0, 'L');
            $pdf->Cell(25, 5, 'Mesa', 1, 1, 'L');
            $total = 0;
            $cont = 1;
            $pdf->SetFont('Arial', '', 8);

            //Imprime todos los datos de los ticket
            foreach ($tickets as $row) {
                $pdf->Cell(15, 5, $cont, 1, 0, 'L');
                $pdf->Cell(30, 5, $row['folioTicket'], 1, 0, 'L');
                $pdf->Cell(45, 5, $row['fecha'] . '  -  ' . $row['hora'], 1, 0, 'L');
                $pdf->Cell(35, 5, "$" . number_format($row['total'], 2, ".", ","), 1, 0, 'L');
                $pdf->Cell(25, 5, $row['idMeza'], 1, 1, 'L');
                $total = $total + $row['total'];
                $cont++;
            }
                
            $pdf->Ln();
            /** FOOTER **/
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(150, 5, 'Total de venta: $' . number_format($total, 2, ".", ","), 0, 1, 'R');
            $this->response->setHeader('Content-Type', 'application/pdf');
            $pdf->Output("reporte.pdf", "I");
        } else {
            echo view('login');
        }
    }
}
