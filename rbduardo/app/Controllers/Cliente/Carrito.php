<?php

namespace App\Controllers\Cliente;

use App\Controllers\BaseController;
use App\Models\ContieneModel;
use App\Models\PedidoModel;

class Carrito extends BaseController
{
	protected $request;
	protected $encrypter;
	protected $contiene;
	protected $pedido;
	protected $db;

	public function __construct()
	{
		$this->request = \Config\Services::request();
		$this->encrypter = \Config\Services::encrypter();
		$this->contiene = new ContieneModel();
		$this->pedido = new PedidoModel();
		$this->db = \Config\Database::connect();
	}

	public function index()
	{
		// Si no hay sesión por alguna razón, se regresa al mensaje de bienvenida
		if (!isset($_SESSION['PEDIDO'])) {
			return redirect()->to(base_url());
		}
		// Manejo de request para las eliminaciones
		if ($this->request->getPost('btnAction') == 'Eliminar') {
			$this->remove();
		}

		if ($this->request->getPost('btnAction') == 'Ordenar') {
			$this->add_db();
			$_SESSION['PEDIDO']['PRODUCTOS'] = [];
			return redirect()->to(base_url('cliente/menu'));
		}

		// Se envía a la vista los productos del carrito, cuantos hay
		// y el total $ de los productos
		$data = [
			'pedido' => $_SESSION['PEDIDO']['PRODUCTOS'],
			'total' => $this->get_total(),
			'idPedido' => $this->getPedido()
		];

		echo view('cliente/carrito', array_merge($data, $this->total_products()));
	}

	// Recibe como variable el nombre enviado desde el request de la vista
	private function decode($name)
	{
		// Se desencriptan los valores pasados por el arreglo $_POST
		$decoded_value = $this->encrypter->decrypt(base64_decode($this->request->getPost($name)));
		return $decoded_value;
	}

	// Contador del subtotal
	private function get_total()
	{
		$total = 0;
		// Dinero Total de la suma de los productos
		if (!empty($_SESSION['PEDIDO']['PRODUCTOS'])) {
			foreach ($_SESSION['PEDIDO']['PRODUCTOS'] as $platillo) {
				$total += $platillo['SUBTOTAL'];
			}
		}
		return $total;
	}

	// Esta función sí altera la base de datos
	private function add_db()
	{
		// Se obtiene el id de la mesa de donde saldrá el pedido
		$id_mesa = $_SESSION['PEDIDO']['MESA'];
		$this->pedido->save([
			'hora' => date('H:i:s'),
			'totalPedido' => $this->get_total(),
			'idMesa' => $id_mesa,
			'comentario' => $this->request->getPost('comentario')
		]);

		$id_pedido = $this->getPedido();
		// Se conecta a la base de datos y hace las inserciones en la 
		// tabla contiene
		// Nota: ésto debería ir en el Modelo, pero no lo hace correctamente
		// así que lo puse aquí en lo que se me ocurre cómo
		$builder = $this->db->table('contiene');
		// Inserta una fila por cada producto referenciando al mismo pedido
		foreach ($_SESSION['PEDIDO']['PRODUCTOS'] as $id => $info) {
			$data = [
				'idPedido' => (int)$id_pedido,
				'idPlatillo' => (int)$id,
				'cantPlatillos' => $info['CANTIDAD'],
				'subtotal' => $info['SUBTOTAL']
			];
			$builder->insert($data);
		}
	}

	public function getPedido()
	{
		// Se obtiene el id de la mesa de donde saldrá el pedido
		$id_mesa = $_SESSION['PEDIDO']['MESA'];

		// El último id del pedido de la mesa es el de mayor valor
		$query = $this->db->query('SELECT MAX(idPedido) FROM pedido WHERE idMesa = ' . $id_mesa);
		$result = $query->getRowArray();
		$id_pedido = $result['MAX(idPedido)'];

		return $id_pedido;
	}
	// Esta función es a nivel de sesión, no altera la base de datos aún
	public function add()
	{
		// Se desencriptan los valores antes de ser agregados a la sesión de carrito
		// Se pasa como parámetro el nombre indicado el request de la vista
		$id_decoded = $this->decode('id');
		$nombre_decoded = $this->decode('nombre');
		$precio_decoded = $this->decode('precio');
		$imagen_decoded = $this->decode('imagen');
		// Los productos se agregan de 1 en 1
		$cantidad = 1;

		// Producto que se agregará al carrito
		$producto = [
			'NOMBRE' => $nombre_decoded,
			'PRECIO' => (float)$precio_decoded,
			'IMAGEN' => $imagen_decoded,
			'CANTIDAD' => $cantidad,
			'SUBTOTAL' => $precio_decoded
		];

		// Referencia al arreglo de producto para no tener que estar accediendo a cada rato
		$productos = &$_SESSION['PEDIDO']['PRODUCTOS'];

		// Si no hay producto, se inicia el arreglo de productos con el ingresado
		if (empty($productos)) {
			$productos = [$id_decoded => $producto];
		} else {
			// Si el producto ya está en el carrito, aumenta la cantidad y el subtotal
			if (isset($productos[$id_decoded])) {
				$productos[$id_decoded]['CANTIDAD']++;
				$productos[$id_decoded]['SUBTOTAL'] += $productos[$id_decoded]['PRECIO'];
				// Si no está, asigna al nuevo índice los valores de $producto
			} else {
				$productos[$id_decoded] = $producto;
			}
		}
	}

	// Solamente elimina los productos de la sesion, no de la base de datos
	public function remove()
	{
		// Decodifica el id enviado desde la vista
		$id_decoded = $this->decode('id');

		// Referencia al producto a eliminar, no es necesario validar que el
		// producto esté en el carrito porque solo los productos en el mismo
		// aparecen para eliminar
		$producto = &$_SESSION['PEDIDO']['PRODUCTOS'][$id_decoded];

		// Si el índice tiene más de un producto en CANTIDAD...
		if ($producto['CANTIDAD'] > 1) {
			// ...reduce en 1 la cantidad...
			$producto['CANTIDAD']--;
			// ...y resta un producto al subtotal
			$producto['SUBTOTAL'] -= $producto['PRECIO'];
		} else {
			// Si solamente hay un producto de ese tipo, lo elimina del carrito completamente
			unset($_SESSION['PEDIDO']['PRODUCTOS'][$id_decoded]);
		}
	}
}
