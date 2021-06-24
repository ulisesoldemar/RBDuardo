<?php 
//La ruta de donde se ubica el modelo
namespace App\Models;
//Definir el modelo de CodeIgniter
use CodeIgniter\Model;

//Clase mismo nombre del archivo
class PersonalModel extends Model
{
    protected $table      = 'personal';
    protected $primaryKey = 'idPersonal';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    //Campos permitidos de la tabla
    protected $allowedFields = ['password', 'nombre', 'apellido', 'rol'];

    //Herramientas para fecha y hora de creacion, actualizacion o eliminacion
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    //Herramientas de validacion
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
