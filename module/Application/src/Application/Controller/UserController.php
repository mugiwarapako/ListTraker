<?php
namespace Application\Controller;

use Application\Service\UsuarioService;
use Zend\Mvc\Controller\AbstractActionController;

class UserController extends AbstractActionController
{

    private $usuarioService;

    function getUsuarioService()
    {
        return $this->usuarioService = new UsuarioService();
    }
    
    
    function loginAction()
    {
//         echo "busca login"; exit;
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            $result = $this->getUsuarioService()->login($decodePostData);
            
            $result['flag'] = empty(!$result);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result
            )));
            return $response;
        }
    }
    

    function listaAction()
    {
        $usuarios = $this->getUsuarioService()->getAll();
        $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
            "response" => $usuarios
        )));
        
        return $response;
    }

    function addUserAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            $result = $this->getUsuarioService()->addUser($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result
            )));
            return $response;
        }
       
    }
    
    
    function updateUserAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            $result = $this->getUsuarioService()->updateUser($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result
            )));
            return $response;
        }
    }
    
    function deleteUserAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            $result = $this->getUsuarioService()->deleteUser($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result
            )));
            return $response;
        }
    }
}
?>