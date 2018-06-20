<?php
namespace Application\Controller;
use Application\Service\UserModelsService;
use Zend\Mvc\Controller\AbstractActionController;

class UserModelsController extends AbstractActionController
{

    private $mensajeService;

    /**
     * Instanciamos el servicio de participantes
     */
    public function getMensajeService()
    {
        return $this->mensajeService = new UserModelsService();
    }

    public function listAction(){

        $mensaje = $this->getMensajeService()->getAll();
        $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $mensaje,
            )));
            
        return $response;
        //exit;
    }

    public function addUserModelAction(){


        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);

            
            $result = $this->getMensajeService()->addUserModels($decodePostData);
                   
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            return $response;
        }

        exit;
    }
    public function buscarMensajeAction(){
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            
            $result = $this->getMensajeService()->buscarMensaje($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            return $response;
        }
        
        exit;
    }
}
?>