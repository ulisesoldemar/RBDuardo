<?php

namespace App\Controllers\Mesero;

use App\Controllers\BaseController;
use App\Models\PedidoModel;

//Mismo nombre del archivo
class Pedidos extends BaseController
{
    protected $pedido;

    public function __construct()
    {
        //Cargar el modelo para interactuar con el
        $this->pedido = new PedidoModel();
    }


    public function index()
    {
        if ($this->hasSession() and $this->session->rol == 'mesero') {
            $db = \Config\Database::connect();
            $pedidos = $db->query(
                'SELECT * FROM pedido 
                INNER JOIN mesa ON pedido.idMesa = mesa.idMesa 
                WHERE mesa.idPersonal = ' . $_SESSION['idPersonal'] . 
                ' ORDER BY pedido.idPedido'
            )->getResultArray();
            $data = ['datos' => $pedidos];

            echo view('mesero/header');
            echo view('mesero/pedidos', $data);
            echo view('mesero/footer');
        } else {
            echo view('login');
        }
    }
}
