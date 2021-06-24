<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoriaModel;
use App\Models\PlatilloModel;

//Mismo nombre del archivo
class Platillos extends BaseController
{
    //Mariable para crear una instancia del modelo
    protected $platillo;
    protected $categoria;
    protected $reglas;

    public function __construct()
    {
        //Cargar el modelo para interactuar con el
        $this->platillo = new PlatilloModel();
        $this->categoria = new CategoriaModel();

        //Incluir un helper
        helper(['form']);

        $this->reglas = [
            'nombre' => [
                'rules' => 'required',
                'error' => ['required' => 'El campo {field} es obligatorio.']
            ],
            'precio' => [
                'rules' => 'required',
                'error' => ['required' => 'El campo {field} es obligatorio.']
            ],
            'descripcion' => [
                'rules' => 'required',
                'error' => ['required' => 'El campo {field} es obligatorio.']
            ],
            'idCategoria' => [
                'rules' => 'required',
                'error' => ['required' => 'El campo {field} es obligatorio.']
            ]
        ];
    }

    public function index()
    {
        if ($this->hasSession() and $this->session->rol == 'administrador') {
            //SELECT * FROM platillo
            $platillos = $this->platillo->findAll();

            $query = $this->platillo->get_data();

            $data = ['titulo' => 'Platillos',  'datos' => $query];

            //Enviamos el resultado del query a la vista platillos
            echo view('admin/header');
            echo view('admin/platillos/platillos', $data);
            echo view('admin/footer');
        } else {
            echo view('login');
        }
    }

    //Funcion para mostrar la interfaz nuevo platillo
    public function add()
    {
        if ($this->hasSession() and $this->session->rol == 'administrador') {
            //Obtener la lista de categorias
            $categorias = $this->categoria->findAll();

            //guardar las categorias
            $data = ['categorias' => $categorias];

            //Mostrar vistas
            echo view('admin/header');
            echo view('admin/platillos/add', $data);
            echo view('admin/footer');
        } else {
            echo view('login');
        }
    }

    //Funcion para insertar un nuevo platillo
    public function insertar()
    {
        if ($this->hasSession() and $this->session->rol == 'administrador') {
            //VALIDACION que se envie por POST y que los campos sean requeridos
            if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {
               
                //Verifica si se subio una imagen.
                if (is_uploaded_file($_FILES['imagen']['tmp_name'])) {
                    //Directorio de la imagen
                    $uploaddir = '../public/img/';
                    //Directorio completo con la imagen para la base de datos
                    $databasepath = '../../public/img/' . $_FILES['imagen']['name'];
                    
                    //Se concatena el nombre de la imagen
                    $uploadfile = $uploaddir . $_FILES['imagen']['name'];

                    //Si se pudo guardar la imagen en la carpeta entonces...
                    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadfile)) {
                        //echo "File is valid, and was successfully uploaded.\n";

                        //Insertar los datos recibidos por post a la BD
                        $this->platillo->save([
                            'nombre' => $this->request->getPost('nombre'),
                            'imagen' => $databasepath,
                            'precio' => $this->request->getPost('precio'),
                            'descripcion' => $this->request->getPost('descripcion'),
                            'idCategoria' => $this->request->getPost('idCategoria')
                        ]);

                        //Redireccionar hacia...
                        return redirect()->to(base_url('admin/platillos'));
                    } else {
                        //Redireccionar hacia...
                        return redirect()->to(base_url('admin/platillos'));
                    }
                //No se inserto ninguna imagen
                } else {

                     //Insertar los datos recibidos por post a la BD
                     $this->platillo->save([
                        'nombre' => $this->request->getPost('nombre'),
                        'precio' => $this->request->getPost('precio'),
                        'descripcion' => $this->request->getPost('descripcion'),
                        'idCategoria' => $this->request->getPost('idCategoria')
                    ]);
                    //Redireccionar hacia...
                    return redirect()->to(base_url('admin/platillos'));
                }
            } else {
                //Obtener la lista de categorias
                $categorias = $this->categoria->findAll();

                //Enviar las validaciones que fueron necesarias y los datos
                $data = ['categorias' => $categorias, 'validation' => $this->validator];

                //Mostrar vistas
                echo view('admin/header');
                echo view('admin/platillos/add', $data);
                echo view('admin/footer');
            }
        } else {
            echo view('login');
        }
    }

    //Funcion para mostrar la vista: editar platillo
    public function edit($id, $valid = null)
    {
        if ($this->hasSession() and $this->session->rol == 'administrador') {
            //SELECT platillo FROM platillo WHERE idPlatillo = $id - Selecciona el primer elemento encontrado
            $platillo = $this->platillo->where('idPlatillo', $id)->first();

            //Obtener la lista de categorias
            $categorias = $this->categoria->findAll();

            if ($valid != null) {
                //Almacenamos los datos en un arreglo
                $data = ['datos' => $platillo, 'categorias' => $categorias, 'validation' => $valid];
            } else {
                //Almacenamos los datos en un arreglo
                $data = ['datos' => $platillo, 'categorias' => $categorias];
            }

            //Mostramos las vistas y enviamos los datos
            echo view('admin/header');
            echo view('admin/platillos/edit', $data);
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

                //Si no se subio ninguna imagen entonces actualiza los datos modificados
                if (!is_uploaded_file($_FILES['imagen']['tmp_name'])) {
                    
                    //Insertar los datos recibidos por post
                    $this->platillo->update(
                        $this->request->getPost('idPlatillo'),
                        [
                            'nombre' => $this->request->getPost('nombre'),
                            'precio' => $this->request->getPost('precio'),
                            'descripcion' => $this->request->getPost('descripcion'),
                            'idCategoria' => $this->request->getPost('idCategoria')
                        ]
                    );
                } else {
                    //Si no cambio la imagen entonces buscar la imagen anterior
                    $eliminar = $this->platillo->where('idPlatillo', $this->request->getPost('idPlatillo'))->first();

                    //Para eliminar la imagen valida que haya algo en el campo imagen
                    if($eliminar['imagen']){
                        //EDirectorio con el nombre de la imagen a eliminar
                        $imagedelete = '../public/img/' . $eliminar['imagen'];

                        //Si la imagen anterior existe
                        if (file_exists($imagedelete)) {
                            //Eliminar imagen
                            unlink($imagedelete);
                            //echo "Imagen eliminada";
                        } else {
                            //Error
                            //echo "No se encontro la imagen";
                        }
                    } 
                    //Sino hay imagen en la base de datos no elimina nada

                    //Directorio completo con la imagen para la base de datos
                    $databasepath = '../../public/img/' . $_FILES['imagen']['name'];

                    //Directorio de la imagen
                    $imagepath = '../public/img/';

                    //Se concatena el nombre de la imagen
                    $uploadfile = $imagepath . $_FILES['imagen']['name'];

                    //Si se pudo guardar la imagen en la carpeta entonces...
                    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadfile)) {
                        //Insertar los datos recibidos por post
                        $this->platillo->update(
                            $this->request->getPost('idPlatillo'),
                            [
                                'nombre' => $this->request->getPost('nombre'),
                                'imagen' => $databasepath,
                                'precio' => $this->request->getPost('precio'),
                                'descripcion' => $this->request->getPost('descripcion'),
                                'idCategoria' => $this->request->getPost('idCategoria')
                            ]
                        );
                    }
                }

                //Redireccionar hacia...
                return redirect()->to(base_url('admin/platillos'));
            } else {
                return $this->edit($this->request->getPost('idPlatillo'), $this->validator);
            }
        } else {
            echo view('login');
        }
    }

    //Funcion para eliminar un platillo
    public function delete($id)
    {
        if ($this->hasSession() and $this->session->rol == 'administrador') {
            $eliminar = $this->platillo->where('idPlatillo', $id)->first();

            $imagepath = './img/' . $eliminar['imagen'];

            if (file_exists($imagepath)) {
                unlink($imagepath);
                //echo "File Successfully Delete."; 

                //DELETE platillo FROM platillo WHERE idPlatillo = $id - Elimina el primer elemento encontrado
                $this->platillo->where('idPlatillo', $id)->delete();
                //Redireccionar hacia...
                return redirect()->to(base_url('admin/platillos'));
            } else {
                //DELETE platillo FROM platillo WHERE idPlatillo = $id - Elimina el primer elemento encontrado
                $this->platillo->where('idPlatillo', $id)->delete();
                //echo "Unable to delete."; 
                return redirect()->to(base_url('admin/platillos'));
            }
        } else {
            echo view('login');
        }
    }
}
