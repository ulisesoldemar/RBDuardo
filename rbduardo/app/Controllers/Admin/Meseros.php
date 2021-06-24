<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PersonalModel;

//Mismo nombre del archivo
class Meseros extends BaseController
{
    //Variable para crear una instancia del modelo
    protected $mesero;

    public function __construct()
    {
        //Cargar el modelo para interactuar con el
        $this->mesero = new PersonalModel();
    }

    public function index()
    {
        if ($this->hasSession() and $this->session->rol == 'administrador') {
            //SELECT * FROM platillo
            $meseros = $this->mesero->findAll();
            $data = ['titulo' => 'Platillos', 'datos' => $meseros];

            //Enviamos el resultado del query a la vista platillos
            echo view('admin/header');
            echo view('admin/meseros/meseros', $data);
            echo view('admin/footer');
        } else {
            echo view('login');
        }
    }

    //Funcion para mostrar la interfaz nuevo platillo
    public function add()
    {
        if ($this->hasSession() and $this->session->rol == 'administrador') {
            //Mostrar vistas
            echo view('admin/header');
            echo view('admin/meseros/add');
            echo view('admin/footer');
        } else {
            echo view('login');
        }
    }

    //Funcion para insertar un nuevo platillo
    public function insertar()
    {
        if ($this->hasSession() and $this->session->rol == 'administrador') {
            //Directorio de la imagen
            //  $uploaddir = '../public/img/';

            //Se concatena el nombre de la imagen
            //  $uploadfile = $uploaddir . $_FILES['imagen']['name'];

            //Si se pudo guardar la imagen en la carpeta entonces...
            //if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadfile)) {
            //echo "File is valid, and was successfully uploaded.\n";

            //Insertar los datos recibidos por post a la BD
            $this->mesero->save([
                'password' => $this->request->getPost('password'),
                'nombre' => $this->request->getPost('nombre'),
                'apellido' => $this->request->getPost('apellido'),
                'rol' => $this->request->getPost('rol')
            ]);

            //Redireccionar hacia...
            return redirect()->to(base_url('admin/meseros'));

            // } else {
            //echo "Upload failed";
            //  }
        } else {
            echo view('login');
        }
    }

    //Funcion para mostrar la vista: editar platillo
    public function edit($id)
    {
        if ($this->hasSession() and $this->session->rol == 'administrador') {
            //SELECT platillo FROM platillo WHERE idPlatillo = $id - Selecciona el primer elemento encontrado
            $mesero = $this->mesero->where('idPersonal', $id)->first();
            //Lo almacena en un arreglo
            $data = ['datos' => $mesero];

            //Mostramos las vistas y enviamos los datos
            echo view('admin/header');
            echo view('admin/meseros/edit', $data);
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
            $this->mesero->update(
                $this->request->getPost('idPersonal'),
                [
                    'password' => $this->request->getPost('password'),
                    'nombre' => $this->request->getPost('nombre'),
                    'apellido' => $this->request->getPost('apellido'),
                    'rol' => $this->request->getPost('rol')
                ]
            );
            //Redireccionar hacia...
            return redirect()->to(base_url('admin/meseros'));
        } else {
            echo view('login');
        }
    }

    //Funcion para eliminar un platillo
    public function delete($id)
    {
        if ($this->hasSession() and $this->session->rol == 'administrador') {
            //DELETE platillo FROM platillo WHERE idPlatillo = $id - Elimina el primer elemento encontrado
            $this->mesero->where('idPersonal', $id)->delete();
            //Redireccionar hacia...
            return redirect()->to(base_url('admin/meseros'));
        } else {
            echo view('login');
        }
    }
}
