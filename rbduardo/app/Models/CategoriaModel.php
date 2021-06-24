<?php 
//La ruta de donde se ubica el modelo
namespace App\Models;
//Definir el modelo de CodeIgniter
use CodeIgniter\Model;

//Clase mismo nombre del archivo
class CategoriaModel extends Model
{
    protected $table      = 'categoria';
    protected $primaryKey = 'idCategoria';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['idCategoria', 'nombre'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}

?>