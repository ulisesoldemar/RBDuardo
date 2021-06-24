<?php

namespace App\Controllers;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\Libraries\Mensaje;

class Server extends BaseController
{
	public function index()
	{

		if (!is_cli()) {
			return redirect()->to(base_url());
			die();
		}

		$server = IoServer::factory(
			new HttpServer(
				new WsServer(
					new Mensaje()
				)
			),
			8080
		);

		$server->run();
	}
}
