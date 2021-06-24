<?php

namespace App\Controllers\Mesero;

use App\Controllers\BaseController;
use App\Models\TicketModel;
use App\Models\PedidoModel;
use App\Models\MesasModel;
use App\Models\PedidoTicketModel;

//Mismo nombre del archivo
class Mesas extends BaseController
{
    //Variable para crear una instancia del modelo
    private $mesa;
    private $ticket;
    private $pedido;
    private $tic_ped;


    public function __construct()
    {
        //Cargar el modelo para interactuar con el
        $this->mesa = new MesasModel();
        $this->ticket = new TicketModel();
        $this->pedido = new PedidoModel();
        $this->tic_ped = new PedidoTicketModel();
    }

    public function index()
    {
        if ($this->hasSession() and $this->session->rol == 'mesero') {


            if ($this->request->getPost('btnMesa')) {
                $_SESSION['ID_MESA'] = $this->request->getPost('btnMesa');
                return redirect()->to(base_url('mesero/platillos'));
            }

            if ($this->request->getPost('btnCerrarMesa')) {
                // El id de la mesa se obtiene por sesión
                $idMesa = $this->request->getPost('btnCerrarMesa');
                // Total de la cuenta
                $total = $this->pedido->get_total($idMesa);

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

                $mesa = new MesasModel();
                $mesa->set_occupied($idMesa, false);
                $this->pedido->whereIn('idMesa', [$idMesa])->set(['completado' => true])->update();
                return redirect()->to(base_url('mesero/mesas'));
            }

            $db = \Config\Database::connect();
            $mesas = $db->query(
                'SELECT * FROM mesa WHERE idPersonal = ' . $_SESSION['idPersonal'] . ' AND ocupado = 1'
            )->getResultArray();
            $mesasNull = $this->mesa->get_personal_null();

            $data = [
                'titulo' => 'Mesas',
                'datos' => $mesas,
                'datosNull' => $mesasNull
            ];

            //Enviamos el resultado del query a la vista mesas
            echo view('mesero/header');
            echo view('mesero/mesas/mesas', $data);
            echo view('mesero/footer');
        } else {
            echo view('login');
        }
    }
}
