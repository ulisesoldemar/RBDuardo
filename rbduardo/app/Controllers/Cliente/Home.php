<?php

namespace App\Controllers\Cliente;

use App\Controllers\BaseController;
use App\Models\MesasModel;
use App\Models\PersonalModel;

class Home extends BaseController
{

	public function index()
	{
		// Si no hay sesión por alguna razón, se regresa al mensaje de bienvenida
		if (!isset($_SESSION['PEDIDO'])) {
			return view('welcome_message');
		}
		$mesa = $_SESSION['PEDIDO']['MESA'];
		$mesero = new PersonalModel();
		$mesero = $mesero->find($_SESSION['PEDIDO']['MESERO'])['nombre'];
		echo view('cliente/home', array_merge($this->total_products(), [
			'mesa' => $mesa,
			'mesero' => $mesero
		]));
	}

	public function setMesa($idMesa)
	{
		// Si la mesa no está activa en la base de datos y no hay sesión
		if (!MesasModel::is_occupied($idMesa) and !isset($_SESSION['PEDIDO'])) {
			// Se inicia la sesión
			$mesa = new MesasModel();
			if($mesa->find($idMesa)['idPersonal'] != NULL){
				$mesa->set_occupied($idMesa, true);
				$_SESSION['PEDIDO'] = [
					'MESA' => $idMesa,
					'MESERO' => $mesa->find($idMesa)['idPersonal'],
					'PRODUCTOS' => []
				];
				// Se activa la mesa en la base de datos
				// Y se redirije al inicio de clientes
			}
			return redirect()->to(base_url('cliente/home/'));
			// Si la sesión está activa en el dispositivo, lo redirije al inicio
			// de clientes, así aunque reescaneen el QR no pasa nada
		} else if (isset($_SESSION['PEDIDO']) and !MesasModel::is_occupied($idMesa)) {
			return redirect()->to(base_url('cliente/home/'));
		}
		// De lo contrario, redirije a la pantalla de bienvenida, así no se puede
		// acceder desde otro dispositivo
		return redirect()->to(base_url());
	}
}
