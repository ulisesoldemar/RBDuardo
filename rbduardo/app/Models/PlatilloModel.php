<?php
//La ruta de donde se ubica el modelo
namespace App\Models;
//Definir el modelo de CodeIgniter
use CodeIgniter\Model;

//Clase mismo nombre del archivo
class PlatilloModel extends Model
{
    protected $table      = 'platillo';
    protected $primaryKey = 'idPlatillo';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre', 'imagen', 'precio', 'descripcion', 'idCategoria'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;


    public function get_data()
    {

        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('platillo');
        $this->builder->select('idPlatillo, platillo.nombre, imagen, precio, descripcion, categoria.nombre as nombreCat');
        $this->builder->join('categoria', 'platillo.idCategoria = categoria.idCategoria');
        $query = $this->builder->get()->getResultArray();

        return $query;
    }
}
