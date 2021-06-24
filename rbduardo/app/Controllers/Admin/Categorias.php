<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoriaModel;

//Mismo nombre del archivo
class Categorias extends BaseController
{
    //Mariable para crear una instancia del modelo
    protected $categoria;
    protected $reglas;

    public function __construct()
    {
        //Cargar el modelo para interactuar con el
        $this->categoria = new CategoriaModel();

        //Incluir un helper
        helper(['form']);

        $this->reglas = [
            'nombre' => [
                'rules' => 'required',
                'error' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ]
        ];
    }

    public function index()
    {
        if ($this->hasSession() and $this->session->rol == 'administrador') {
            //SELECT * FROM categoria
            $categorias = $this->categoria->findAll();
            $data = ['titulo' => 'Categorias', 'datos' => $categorias];

            //Enviamos el resultado del query a la vista categorias
            echo view('admin/header');
            echo view('admin/categorias/categorias', $data);
            echo view('admin/footer');
        } else {
            echo view('login');
        }
    }

    //Funcion para mostrar la interfaz nuevo categoria
    public function add()
    {
        if ($this->hasSession() and $this->session->rol == 'administrador') {
            //Mostrar vistas
            echo view('admin/header');
            echo view('admin/categorias/add');
            echo view('admin/footer');
        } else {
            echo view('login');
        }
    }

    //Funcion para insertar un nuevo categoria
    public function insertar()
    {
        if ($this->hasSession() and $this->session->rol == 'administrador') {
            //VALIDACION que se envie por POST y que los campos sean requeridos
            if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {

                //Insertar los datos recibidos por post a la BD
                $this->categoria->save(['nombre' => $this->request->getPost('nombre')]);
                //Redireccionar hacia...
                return redirect()->to(base_url('admin/categorias'));
            } else {
                //Enviar las validaciones que fueron necesarias
                $data = ['validation' => $this->validator];

                //Mostrar vistas
                echo view('admin/header');
                echo view('admin/categorias/add', $data);
                echo view('admin/footer');
            }
        } else {
            echo view('login');
        }
    }

    //Funcion para mostrar la vista: editar categoria
    public function edit($id, $valid = null)
    {
        if ($this->hasSession() and $this->session->rol == 'administrador') {     //SELECT categoria FROM categoria WHERE idcategoria = $id - Selecciona el primer elemento encontrado
            $categoria = $this->categoria->where('idCategoria', $id)->first();

            if ($valid != null) {
                //Lo almacena en un arreglo
                $data = ['datos' => $categoria, 'validation' => $valid];
            } else {
                $data = ['datos' => $categoria];
            }


            //Mostramos las vistas y enviamos los datos
            echo view('admin/header');
            echo view('admin/categorias/edit', $data);
            echo view('admin/footer');
        } else {
            echo view('login');
        }
    }

    //Funcion para actualizar los cambios al editar
    public function actualizar()
    {
        if ($this->hasSession() and $this->session->rol == 'administrador') {
            //Insertar los datos recibidos por post
            if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {

                $this->categoria->update(
                    $this->request->getPost('idCategoria'),
                    ['nombre' => $this->request->getPost('nombre')]
                );
                //Redireccionar hacia...
                return redirect()->to(base_url('admin/categorias'));
            } else {
                return $this->edit($this->request->getPost('idCategoria'), $this->validator);
            }
        } else {
            echo view('login');
        }
    }

    //Funcion para eliminar un categoria
    public function delete($id)
    {
        if ($this->hasSession() and $this->session->rol == 'administrador') {
            //DELETE categoria FROM categoria WHERE idcategoria = $id - Elimina el primer elemento encontrado
            $this->categoria->where('idCategoria', $id)->delete();
            //Redireccionar hacia...
            return redirect()->to(base_url('admin/categorias'));
        } else {
            echo view('login');
        }
    }
}
