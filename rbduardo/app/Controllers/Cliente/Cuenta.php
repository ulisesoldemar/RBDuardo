<?php

namespace App\Controllers\Cliente;

use App\Controllers\BaseController;
use App\Models\TicketModel;
use App\Models\PedidoModel;
use App\Models\MesasModel;
use App\Models\PedidoTicketModel;

class Cuenta extends BaseController
{
    private $ticket;
    private $pedido;
    private $tic_ped;

    public function __construct()
    {
        $this->ticket = new TicketModel();
        $this->pedido = new PedidoModel();
        $this->tic_ped = new PedidoTicketModel();
    }

    public function index()
    {
        date_default_timezone_set('America/Mexico_City');


        // Si no hay sesión por alguna razón, se regresa al mensaje de bienvenida
        if (!isset($_SESSION['PEDIDO'])) {
            return redirect()->to(base_url());
        }

        // El id de la mesa se obtiene por sesión
        $idMesa = $_SESSION['PEDIDO']['MESA'];
        // Total de la cuenta
        $total = $this->pedido->get_total($idMesa);

        if ($this->request->getPost('btnAction') == 'Pagar') {

            // Antes de que se ponga el pedido en completado
            // Se obtienen todos los pedidos de dicha mesa
            // Se crea un nuevo ticket con esos pedidos
            // Y posteriormente se marcan como completados

            //Variable con los datos a buscar
            $seach = [
                'idMesa' => $idMesa,
                'completado' => false
            ];
            
            //Obtener los pedidos de un mismo cliente
            $pedidos = $this->pedido->where($seach)->findAll();

            //Creacion de un nuevo ticket
            $this->ticket->save([
                'fecha' => date('Y-m-d'),
                'hora' => date("H:i:s"),
                'total' => $total,
                'idMeza' => $idMesa
            ]);

            //Buscar el ultimo ticket ingresado
            $folio = $this->ticket->get_last_ticket($idMesa);

            //Actualizar la tabla de ticket_pedido con los pedidos de acuerdo al ticket
            foreach ($pedidos as $ped) {
                $this->tic_ped->insert_data($folio, $ped['idPedido']);
            }

            //Destruir la sesion
            $mesa = new MesasModel();
            $mesa->set_occupied($idMesa, false);
            $this->pedido->whereIn('idMesa', [$idMesa])->set(['completado' => true])->update();
            echo view('goodbye_message');
            session_destroy();
        } else {
            $data = [
                // La cuenta se genera en el ticket en base al id de la idMesa
                'cuenta' => $this->ticket->get_cuenta($idMesa),
                // El total se genera en el pedido en base al id de la idMesa
                'total' => $total
            ];

            echo view('cliente/cuenta', array_merge($data, $this->total_products()));
        }
    }
}
