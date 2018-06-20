<?php
/**
 * @autor JuanMS
 * Controlador para las peticiones de sismos
 */
namespace Application\Controller;

use Application\Service\EventoService;
use Zend\Mvc\Controller\AbstractActionController;

class EventoController extends AbstractActionController
{

    private $eventoService;

    function getEventoService()
    {
        return $this->eventoService = new EventoService();
    }

    function listAction()
    {
        $voluntarios = $this->getEventoService()->getAll();
        $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
            "response" => $voluntarios
        )));
        
        return $response;
    }

    function addEventAction()
    {
        $request = $this->getRequest();
        $response;
        
        if ($request->isPost()) {
            $postData = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            $result = $this->getEventoService()->addEvent($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result
            )));
            
            
        }
        
        return $response;
        
    }

    function searchEventAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            $result = $this->getEventoService()->searchEvent($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result
            )));
            return $response;
        }
    }

    function deleteEventAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            $result = $this->getEventoService()->deleteEvent($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result
            )));
            return $response;
        }
    }
    
    function updateEventAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            $result = $this->getEventoService()->updateEvent($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result
            )));
            return $response;
        }
    }

}