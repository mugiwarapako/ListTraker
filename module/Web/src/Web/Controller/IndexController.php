<?php
namespace Web\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Service\ModelsService;
use Zend\Authentication\AuthenticationService;

class IndexController extends AbstractActionController
{

    private $modelService;

    private $auth;

    public function __construct()
    {
        // Cargamos el servicio de autenticación en el constructor
        $this->auth = new AuthenticationService();
    }

    function getModelService()
    {
        return $this->modelService = new ModelsService();
    }

    function index()
    {
        return new ViewModel(array(
            "titulo" => "Login",
            "form" => $form,
            "prueba" => $prueba
        
        ));
    }

    function homeAction()
    {
        // Leemos el contenido de la sesión
        $identi = $this->auth->getStorage()->read();
        
        if ($identi != false && $identi != null) {
            $datos = $identi;
            $consulta = $this->getModelService()->viewAll();
            // echo "<pre>"; print_r($consulta); exit;
            return new ViewModel(array(
                
                "modelos" => $consulta
            ));
        } else {
            
            return new ViewModel(array(
                $datos = "No estas identificado",
                $this->redirect()->toUrl($this->getRequest()
                    ->getBaseUrl() . '/login/user/index')
            ));
        }
    }
}
?>