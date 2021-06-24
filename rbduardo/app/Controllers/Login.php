<?php

namespace App\Controllers;

use App\Models\PersonalModel;

class Login extends BaseController
{

    private $personal;

    public function __construct()
    {
        $this->personal = new PersonalModel();
    }

    public function index()
    {
        echo view('login');
    }

     public function login()
    {
        //datos ingresados por el usuario
        $idPersonal = $this->request->getPost('idPersonal');
        $password = $this->request->getPost('password');
        //recupera los datos de la tabla de personal
        $datosmesero = $this->personal->where('idPersonal', $idPersonal)->first();

        if ($datosmesero != null) {
            if ($datosmesero['rol'] == 'administrador') {
                if ($password == $datosmesero['password']) {
                    $datosSesion = [
                        'idPersonal' => $datosmesero['idPersonal'],
                        'nombre' => $datosmesero['nombre'],
                        'apellido' => $datosmesero['apellido'],
                        'rol' => $datosmesero['rol']
                    ];

                    $this->session->set($datosSesion);

                    return redirect()->to(base_url() . '/admin/home');
                } else {
                    $data['error'] = "Las contraseñas no coinciden";
                    echo view('login', $data);
                }
            } elseif ($datosmesero['rol'] == 'mesero') {
                if ($password == $datosmesero['password']) {
                    $datosSesion = [
                        'idPersonal' => $datosmesero['idPersonal'],
                        'nombre' => $datosmesero['nombre'],
                        'apellido' => $datosmesero['apellido'],
                        'rol' => $datosmesero['rol']
                    ];

                    $this->session->set($datosSesion);

                    return redirect()->to(base_url() . '/mesero/home');
                } else {
                    $data['error'] = "Las contraseñas no coinciden";
                    echo view('login', $data);
                }
            }
        } else {
            $data['error'] = "El usuario no existe";
            echo view('login', $data);
        }
    }

    public function logout()
    {
        $this->session->destroy();
        echo view('login');
    }

}
