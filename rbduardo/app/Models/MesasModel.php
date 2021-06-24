<?php
//La ruta de donde se ubica el modelo
namespace App\Models;
//Definir el modelo de CodeIgniter
use CodeIgniter\Model;

//Clase mismo nombre del archivo
class MesasModel extends Model
{
    protected $table      = 'mesa';
    protected $primaryKey = 'idMesa';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    //Campos permitidos de la tabla
    protected $allowedFields = ['zona', 'nombreCliente', 'idPersonal', 'ocupado'];

    //Herramientas para fecha y hora de creacion, actualizacion o eliminacion
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    //Herramientas de validacion
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function get_showMesas()
    {
        $this->db = \Config\Database::connect();

        $this->builder = $this->db->table('mesa');
        $this->builder->select('idMesa, zona, personal.nombre, personal.apellido, ocupado');
        $this->builder->join('personal', 'personal.idPersonal=mesa.idPersonal');
        $this->builder->orderBy('idMesa');
        $query = $this->builder->get()->getResultArray();

        return $query;
    }

    public function get_personal()
    {
        $this->db = \Config\Database::connect();
        //SELECT idPersonal, nombre, apellido FROM personal;         
        $this->builder = $this->db->table('personal');
        $this->builder->select('idPersonal, nombre, apellido');
        $query = $this->builder->get()->getResultArray();

        return $query;
    }

    public function get_personal_null()
    {
        $this->db = \Config\Database::connect();
        //SELECT idPersonal, nombre, apellido FROM personal Where idPersonal is null;         
        $this->builder = $this->db->table('mesa');
        $this->builder->select('idMesa, zona, idPersonal, ocupado');
        $this->builder->where('idPersonal is null');
        $query = $this->builder->get()->getResultArray();

        return $query;
    }

    public function set_occupied($id, $state)
    {
        $this->update($id, ['ocupado' => $state]);
    }

    static public function is_occupied($id)
    {
        $db = \Config\Database::connect();
        return $db->query('SELECT ocupado FROM mesa WHERE idMesa = ' . $id)->getRow()->ocupado;
    }
}
