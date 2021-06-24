<?php

namespace App\Controllers\Mesero;

use App\Controllers\BaseController;
use App\Models\PersonalModel;
use App\Models\MesasModel;

// Mismo nombre del archivo
class Abrir extends BaseController
{

	public function __construct()
	{
		$this->personal = new PersonalModel();
		$this->mesa = new MesasModel();
	}

    
	public function index()
	{
        if ($this->hasSession() and $this->session->rol == 'mesero') {
            
            if ($this->request->getPost('btnMesa')) {
                $_SESSION['ID_MESA'] = $this->request->getPost('btnMesa');
                $this->mesa->set_occupied($_SESSION['ID_MESA'], true);
                return redirect()->to(base_url('mesero/platillos'));
            }

            $db = \Config\Database::connect();
            $mesas = $db->query(
                'SELECT * FROM mesa WHERE idPersonal = ' . $_SESSION['idPersonal'] . ' AND ocupado = 0'
            )->getResultArray();
            $mesasNull = $this->mesa->get_personal_null();

            $data = ['titulo' => 'Mesas', 'datos' => $mesas, 'datosNull' => $mesasNull];

            //Enviamos el resultado del query a la vista mesas
            echo view('mesero/header');
            echo view('mesero/mesas/abrir', $data);
            echo view('mesero/footer');
        } else {
            echo view('login');
        }
		
	}


}
