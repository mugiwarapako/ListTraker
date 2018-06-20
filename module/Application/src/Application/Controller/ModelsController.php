<?php
/**
 * @autor JuanMS
 * Controlador para las peticiones de voluntario Creador
 */

namespace Application\Controller;

use Application\Service\ModelsService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ModelsController extends AbstractActionController
{

    private $modelsService;

    public function getModel(){
    	return $this->voluntCreadorService = new ModelsService();
    }

    public function listAction(){
        
        $models = $this->getModel()->getAll();
        $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
            "response" => $models,
        )));
        
        return $response;
        //exit;
    }
    public function addModelsAction(){
        
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$postData       = $this->getRequest()->getContent();
    		$decodePostData = json_decode($postData, true);
          
    		$result = $this->getModel()->addModel($decodePostData);
//     		print_r($result);
//     		exit;
    		
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            
            return $response;
     
    	}

    }
    
    public function existModelAction(){
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            $result = $this->getModel()->existModel($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            
            return $response;
            
        }
    }
    
    
    public function viewAction(){
        
        $id=$this->params()->fromRoute("id",null);
                
        
        $result = $this->getModel()->mostrarModeloId($id);
        
//         print_r($result[0]['imagen']); exit;
        
        // get image content
//         $response = $this->getResponse();
        
//         $response->setContent($result);
//         $response
//         ->getHeaders()
//         ->addHeaderLine('Content-Transfer-Encoding', 'binary')
//         ->addHeaderLine('Content-Type', 'image/png')
//         ->addHeaderLine('Content-Length', mb_strlen($imageContent));
        
//         return $response;
        
        
        return new ViewModel(array("imagen"=>$result[0]['imagen']));
    }
    

    function viewAllAction(){
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            $result = $this->getModel()->viewAll($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            
            return $response;
            
        }
        
        
    }
}