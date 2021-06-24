<?php

namespace App\Controllers\Cocina;

use App\Controllers\BaseController;

// Mismo nombre del archivo
class Home extends BaseController
{
	public function index()
	{
		echo view('cocina/home');
	}

}
