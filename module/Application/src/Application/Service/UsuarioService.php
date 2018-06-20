<?php
namespace Application\Service;

use Application\Model\UserModel;

class UsuarioService
{

    private $userModel;

    private function getUserModel()
    {
        return $this->userModel = new UserModel();
    }

    function getAll()
    {
        return $this->getUserModel()->getAll();
    }
    
    
    function login($dataUser){
//         echo "busca login S"; exit;
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