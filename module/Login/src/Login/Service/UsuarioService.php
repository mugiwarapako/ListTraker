<?php
namespace Login\Service;

use Login\Model\UserModel;
use Zend\View\Helper\ViewModel;
use Login\Form\Formulario;
use Zend\Session\Container;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;

class UsuarioService
{

    private $userModel;
    private $auth;

    private function getUserModel()
    {
        return $this->userModel = new UserModel();
    }

    function getAll()
    {
        return $this->getUserModel()->getAll();
    }
    
    public function __construct() {
        //Cargamos el servicio de autenticación en el constructor
        $this->auth = new AuthenticationService();
    }
    
    
    function login($dataUser){
        
        $auth = $this->auth;

        $datos = $this->getUserModel()->login($dataUser);
        
        $dataDB = array(
            'correo' => strip_tags($dataUser['correo']),
            'password' => $dataUser['password']
        );
        
        return $this->getUserModel()->login($dataUser);
        
      
    }
    

    function addUser($dataUser)
    {
        $respuesta = array();
        $usuario = $this->getUserModel()->existe($dataUser);
        
        if (count($usuario) == 0) {
            $respuesta = $this->getUserModel()->addUser($dataUser);
            $respuesta["mensaje"] = "Usuario Registrado";
        } else {
            $respuesta["status"] = false;
            $respuesta["mensaje"] = "Ya existe usuario asciado a la cuenta de correo : " . $usuario['correo'];
        }
        return $respuesta;
        
        exit;
    }

    function updateUser($dataUser)
    {
        $respuesta = array();
        $usuario = $this->getUserModel()->existe($dataUser);
        
        if (count($usuario) != 0) {
            $respuesta = $this->getUserModel()->updateUser($dataUser);
            $respuesta["mensaje"] = "Datos Actualzizados";
        } else {
            $respuesta["status"] = false;
            $respuesta["mensaje"] = "No encontro usuario " . $dataUser['correo'];
        }
        return $respuesta;
    }

    function deleteUser($dataUser)
    {
        $respuesta = $this->getUserModel()->deleteUser($dataUser);
        
        return $respuesta;
    }
}
?>