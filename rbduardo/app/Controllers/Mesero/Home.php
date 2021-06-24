<?php

namespace App\Controllers\Mesero;

use App\Controllers\BaseController;
use App\Models\MesasModel;

// Mismo nombre del archivo
class Home extends BaseController
{

	public function __construct()
	{
		$this->mesa = new MesasModel();
		$_SESSION['PRODUCTOS'] = [];
	}

	public function index()
	{
		if ($this->hasSession()) {
			$mesas = $this->mesa->findAll();
			echo view('mesero/header');
			echo view('mesero/home', ['mesas' => $mesas]);
			echo view('mesero/footer');
		} 
		else {
			echo view('login');
		}
	}
}
