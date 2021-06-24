<?php
//La ruta de donde se ubica el modelo
namespace App\Models;
//Definir el modelo de CodeIgniter
use CodeIgniter\Model;

//Clase mismo nombre del archivo
class PedidoModel extends Model
{
    protected $table      = 'pedido';
    protected $primaryKey = 'idPedido';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    //Campos permitidos de la tabla
    protected $allowedFields = ['idPedido', 'hora', 'totalPedido', 'idMesa', 'comentario', 'completado'];

    //Herramientas para fecha y hora de creacion, actualizacion o eliminacion
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    //Herramientas de validacion
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function get_total($idMesa)
    {
        // SELECT SUM(pedido.totalPedido) FROM pedido WHERE pedido.completado = 0 AND pedido.idMesa = $idMesa
        return $this->db->query(
            'SELECT SUM(pedido.totalPedido) as total 
            FROM pedido 
            WHERE pedido.completado = 0 AND pedido.idMesa = ' . $idMesa)->getRowArray()['total'];
    }

    public function delete_all(){
        $this->db->query('DELETE FROM `pedido`');
    }
}
