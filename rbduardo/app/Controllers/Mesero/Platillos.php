<?php

namespace App\Controllers\Mesero;

use App\Controllers\BaseController;
use App\Models\PlatilloModel;
use App\Models\PedidoModel;


//Mismo nombre del archivo
class Platillos extends BaseController
{
    //Mariable para crear una instancia del modelo
    protected $platillo;
    protected $pedido;
    protected $db;
    protected $idMesa;
    protected $idPedido;

    public function __construct()
    {
        //Cargar el modelo para interactuar con el
        $this->platillo = new PlatilloModel();
        $this->pedido = new PedidoModel();
        // Conexión a la base de datos
        $this->db = \Config\Database::connect();
        $this->idMesa = session()->get('ID_MESA');
        $this->idPedido = $this->get_idPedido();
    }

    public function index()
    {
        if ($this->hasSession() and $this->session->rol == 'mesero') {

            if ($this->request->getPost('btnPedido') == 'Ordenar') {
                if (isset($_POST['platillos'])) {
                    $this->add_db();
                    return redirect()->to(base_url('mesero/mesas'));
                }
            }

            $datos = $this->platillo->get_data();

            $data = [
                'datos' => $datos,
                'idMesa' => $this->idMesa,
                'idPedido' => $this->idPedido + 1
            ];

            //Enviamos el resultado del query a la vista platillos
            echo view('mesero/header');
            echo view('mesero/platillos', $data);
            echo view('mesero/footer');
        } else {
            echo view('login');
        }
    }

    // Contador del subtotal
    private function get_total()
    {
        $total = 0;
        // Dinero Total de la suma de los PEDIDO
        foreach ($this->request->getPost('platillos') as $id => $cantidad) {
            $precio = $this->platillo->where('idPlatillo', $id)->first()['precio'];
            $total += $precio * $cantidad;
        }
        return $total;
    }

    private function get_idPedido()
    {
        
        $query = $this->db->query('SELECT MAX(idPedido) FROM pedido WHERE idMesa = ' . $this->idMesa);
        $result = $query->getRowArray();
        return $result['MAX(idPedido)'];
    }

    private function add_db()
    {
        $this->pedido->save([
            'hora' => date('H:i:s'),
            'totalPedido' => $this->get_total(),
            'idMesa' => $this->idMesa,
            'comentario' => $this->request->getPost('comentario')
        ]);

        $idPedido = $this->get_idPedido();

        // Se conecta a la base de datos y hace las inserciones en la 
        // tabla contiene
        // Nota: ésto debería ir en el Modelo, pero no lo hace correctamente
        // así que lo puse aquí en lo que se me ocurre cómo
        $builder = $this->db->table('contiene');

        // Inserta una fila por cada producto referenciando al mismo pedido
        foreach ($_POST['platillos'] as $id => $cantidad) {
            $precio = $this->platillo->where('idPlatillo', $id)->first()['precio'];
            $data = [
                'idPedido' => (int)$idPedido,
                'idPlatillo' => (int)$id,
                'cantPlatillos' => $cantidad,
                'subtotal' => $cantidad * $precio
            ];
            $builder->insert($data);
        }
    }
}
