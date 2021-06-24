<?php

namespace App\Controllers\Cliente;

use App\Controllers\BaseController;

//Mismo nombre del archivo
class Contact extends BaseController
{
    public function index()
    {
        // Si no hay sesión por alguna razón, se regresa al mensaje de bienvenida
        if (!isset($_SESSION['PEDIDO'])) {
            return redirect()->to(base_url());
        }
        echo view('cliente/contact', $this->total_products());
    }
}
