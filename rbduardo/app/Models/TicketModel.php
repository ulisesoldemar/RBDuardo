<?php
//La ruta de donde se ubica el modelo
namespace App\Models;
//Definir el modelo de CodeIgniter
use CodeIgniter\Model;

//Clase mismo nombre del archivo
class TicketModel extends Model
{
    protected $table      = 'ticket';
    protected $primaryKey = 'folioTicket';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    //Campos permitidos de la tabla
    protected $allowedFields = ['folioTicket', 'fecha', 'hora', 'total', 'idMeza'];

    //Herramientas para fecha y hora de creacion, actualizacion o eliminacion
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    //Herramientas de validacion
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function get_cuenta($idMesa)
    {
        $db = \Config\Database::connect();
        // SELECT nombre, SUM(cantPlatillos) as cantidad, precio, SUM(subtotal) as subtotal FROM platillo INNER JOIN contiene ON contiene.idPlatillo = platillo.idPlatillo INNER JOIN pedido ON pedido.idPedido = contiene.idPedido AND pedido.idMesa = 1 GROUP BY platillo.nombre;
        return $db->query(
            'SELECT nombre, SUM(cantPlatillos) AS cantidad, precio, SUM(subtotal) as subtotal FROM platillo 
            INNER JOIN contiene ON contiene.idPlatillo = platillo.idPlatillo 
            INNER JOIN pedido ON pedido.idPedido = contiene.idPedido AND pedido.completado = 0 AND pedido.idMesa = ' . $idMesa . ' 
            GROUP BY platillo.nombre;'
        )->getResultArray();
    }

    public function get_last_ticket($idMesa)
    {
        $db = \Config\Database::connect();
        $query = $db->query('SELECT MAX(folioTicket) FROM ticket WHERE idMeza = ' . $idMesa);
        $result = $query->getRowArray();
        return $result['MAX(folioTicket)'];
    }

    public function reporte($dateStart, $dateEnd){
        return $this->db->query('SELECT * FROM `ticket` 
            WHERE fecha BETWEEN ' . "'". $dateStart ."'" . ' AND ' . "'" . $dateEnd . "'")->getResultArray();
    }
}
