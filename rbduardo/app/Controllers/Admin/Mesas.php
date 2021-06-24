<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MesasModel;

//Mismo nombre del archivo
class Mesas extends BaseController
{
    //Variable para crear una instancia del modelo
    protected $mesa;

    public function __construct()
    {
        //Cargar el modelo para interactuar con el
        $this->mesa = new MesasModel();
    }

    public function index()
    {
        if ($this->hasSession() and $this->session->rol == 'administrador') {
            //SELECT * FROM mesa
            //Selecciona los datos de la mesa y el nombre del personal a cargo
            $mesas = $this->mesa->get_showMesas();
            //Selecciona las mesas pero las que no tienen personal asignado
            $mesasNull = $this->mesa->get_personal_null();

            $data = ['titulo' => 'Mesas', 'datos' => $mesas, 'datosNull' => $mesasNull];

            //Enviamos el resultado del query a la vista mesas
            echo view('admin/header');
            echo view('admin/mesas/mesas', $data);
            echo view('admin/footer');
        } else {
            echo view('login');
        }
    }

    //Funcion para mostrar la interfaz nuevo platillo
    public function add()
    {
        if ($this->hasSession() and $this->session->rol == 'administrador') {        //Obtener información del personal
            $personal = $this->mesa->get_personal();
            $data = ['personal' => $personal];

            //Mostrar vistas
            echo view('admin/header');
            echo view('admin/mesas/add', $data);
            echo view('admin/footer');
        } else {
            echo view('login');
        }
    }

     //Funcion para insertar una nueva mesa
     public function insertar()
     {
         if ($this->hasSession() and $this->session->rol == 'administrador') {        //Insertar los datos recibidos por post a la BD
             
             if($this->request->getPost('idPersonal') == 0){
                 $this->mesa->save([
                     'zona' => $this->request->getPost('zona'),
                     'idPersonal' => NULL
                 ]);
             }
             else{
                 $this->mesa->save([
                     'zona' => $this->request->getPost('zona'),
                     'idPersonal' => $this->request->getPost('idPersonal')
                 ]);
             }
             
             
             //Redireccionar hacia...
             return redirect()->to(base_url('admin/mesas'));
         } else {
             echo view('login');
         }
     }

    //Funcion para mostrar la vista: editar mesa
    public function edit($id)
    {
        if ($this->hasSession() and $this->session->rol == 'administrador') {
            //SELECT mesa FROM mesa WHERE idMesa = $id - Selecciona el primer elemento encontrado
            $mesa = $this->mesa->where('idMesa', $id)->first();
            //Obtener información del personal
            $personal = $this->mesa->get_personal();
            //Mandar el estado
            $estado = [
                0 => 'Libre',
                1 => 'Ocupado'
            ];

            //Lo almacena en un arreglo
            $data = ['datos' => $mesa, 'personal' => $personal, 'estado' => $estado];

            //Mostramos las vistas y enviamos los datos
            echo view('admin/header');
            echo view('admin/mesas/edit', $data);
            echo view('admin/footer');
        } else {
            echo view('login');
        }
    }

    //Funcion para actualizar los cambios al editar
    //Funcion para actualizar los cambios al editar
    public function actualizar()
    {
        if ($this->hasSession() and $this->session->rol == 'administrador') {
            //Insertar los datos recibidos por post
           

            if($this->request->getPost('idPersonal') == 0){
                $this->mesa->update(
                    $this->request->getPost('idMesa'),
                    [
                        'zona' => $this->request->getPost('zona'),
                        'idPersonal' => NULL,
                        'ocupado' => $this->request->getPost('ocupado')
                    ]
                );
            }
            else{
                $this->mesa->update(
                    $this->request->getPost('idMesa'),
                    [
                        'zona' => $this->request->getPost('zona'),
                        'idPersonal' => $this->request->getPost('idPersonal'),
                        'ocupado' => $this->request->getPost('ocupado')
                    ]
                );
            }
            //Redireccionar hacia...
            return redirect()->to(base_url('admin/mesas'));
        } else {
            echo view('login');
        }
    }

    //Funcion para eliminar una mesa
    public function delete($id)
    {
        if ($this->hasSession() and $this->session->rol == 'administrador') {
            //DELETE mesa FROM mesa WHERE idMesa = $id - Elimina el primer elemento encontrado
            $this->mesa->where('idMesa', $id)->delete();
            //Redireccionar hacia...
            return redirect()->to(base_url('admin/mesas'));
        } else {
            echo view('login');
        }
    }
}
