<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MesasModel;

class Home extends BaseController
{
	private $mesa;

	public function __construct()
	{
		$this->mesa = new MesasModel();
	}

	public function index()
	{
		if ($this->hasSession()) {
			$mesas = $this->mesa->findAll();
			echo view('admin/header');
			echo view('admin/tables', ['mesas' => $mesas]);
			echo view('admin/footer');
		} else {
			echo view('login');
		}
	}
}
