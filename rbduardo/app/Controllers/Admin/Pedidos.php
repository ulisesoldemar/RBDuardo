<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ContieneModel;
use App\Models\PedidoModel;
use App\Models\PedidoTicketModel;

//Mismo nombre del archivo
class Pedidos extends BaseController
{
    protected $pedido, $contiene, $ped_tick;

    public function __construct()
    {
        //Cargar el modelo para interactuar con el
        $this->pedido = new PedidoModel();
        $this->contiene = new ContieneModel();
        $this->ped_tick = new PedidoTicketModel();
    }


    public function index()
    {
        //Verificar que se haya logueado como administrador
        if ($this->hasSession() and $this->session->rol == 'administrador') {

            //SELECT * FROM pedidos
            $pedidos = $this->pedido->findAll();
            $data = ['datos' => $pedidos];

            echo view('admin/header');
            echo view('admin/pedidos/pedidos', $data);
            echo view('admin/footer');
        } else {
            echo view('login');
        }
    }

    //Funcion para eliminar un pedido
    public function delete($id)
    {
        if ($this->hasSession() and $this->session->rol == 'administrador') {
            //Buscar y eliminar el pedido de la tabla PEDIDO
            $this->pedido->where('idPedido', $id)->delete();

            //Buscar y eliminar el pedido de la tabla CONTIENE
            $this->contiene->where('idPedido', $id)->delete();

            //Buscar y eliminar el pedido de la tabla PEDIDO
            $this->ped_tick->delete_pedido($id);
            //Redireccionar hacia...

            return redirect()->to(base_url('admin/pedidos'));
        } else {
            echo view('login');
        }
    }

    //Funcion para eliminar todos los pedidos
    public function delete_all()
    {
        if ($this->hasSession() and $this->session->rol == 'administrador') {
            //Vacia cada una de las tablas

            $this->pedido->delete_all();
            $this->contiene->delete_all();
            $this->ped_tick->delete_all();

            //Redireccionar hacia...
            return redirect()->to(base_url('admin/pedidos'));
        } else {
            echo view('login');
        }
    }
}
