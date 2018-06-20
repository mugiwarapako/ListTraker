<?php
namespace Application\Controller;
use Application\Service\UsuarioEventoService;
use Zend\Mvc\Controller\AbstractActionController;

class UserEventController extends AbstractActionController
{

    private $voluntarioSimulacroService;

    /**
     * Instanciamos el servicio de participantes
     */
    public function getUsuarioEventoService()
    {
        return $this->voluntarioSimulacroService = new UsuarioEventoService();
    }

    public function listAction(){

        $voluntariosSimulacro = $this->getUsuarioEventoService()->getAll();
        $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $voluntariosSimulacro,
            )));
            
        return $response;
    }

    public function addUserEventAction(){


        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);

            
            $result = $this->getUsuarioEventoService()->addUsuarioEvento($decodePostData);
                   
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            return $response;
        }

        exit;
    }
    
//     public function updateVoluntarioSimulacroAction(){
        
        
//         $request = $this->getRequest();
//         if ($request->isPost()) {
//             $postData       = $this->getRequest()->getContent();
//             $decodePostData = json_decode($postData, true);
            
            
//             $result = $this->getVoluntarioSimulacroService()->updateVoluntario($decodePostData);
            
//             $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
//                 "response" => $result,
//             )));
//             return $response;
//         }
        
//         exit;
//     }
    
//     public function buscarDetalleVoluntarioAction(){
        
        
//         $request = $this->getRequest();
//         if ($request->isPost()) {
//             $postData       = $this->getRequest()->getContent();
//             $decodePostData = json_decode($postData, true);
            
            
//             $result = $this->getVoluntarioSimulacroService()->buscarDetalleVoluntario($decodePostData);
            
//             $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
//                 "response" => $result,
//             )));
//             return $response;
//         }
        
//         exit;
//     }
    
//     public function deletelistaVoluntarioAction(){
        
        
//         $request = $this->getRequest();
//         if ($request->isPost()) {
//             $postData       = $this->getRequest()->getContent();
//             $decodePostData = json_decode($postData, true);
            
            
//             $result = $this->getVoluntarioSimulacroService()->listaVoluntario($decodePostData);
            
//             $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
//                 "response" => $result,
//             )));
//             return $response;
//         }
        
//         exit;
//     }
    
//     public function eliminarVolDeSimulacroAction(){
        
        
//         $request = $this->getRequest();
//         if ($request->isPost()) {
//             $postData       = $this->getRequest()->getContent();
//             $decodePostData = json_decode($postData, true);
            
            
//             $result = $this->getVoluntarioSimulacroService()->eliminarVolDeSimulacro($decodePostData);
            
//             $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
//                 "response" => $result,
//             )));
//             return $response;
//         }
        
//         exit;
//     }
}
?>