<?php
namespace Login\Controller;   


use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Login\Service\UsuarioService;
use Login\Form\Formulario;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{

    private $usuarioService;
    private $dbAdapter;
    private $auth;
    
    public function __construct() {
        //Cargamos el servicio de autenticación en el constructor
        $this->auth = new AuthenticationService();
    }
    

    function getUsuarioService()
    {
        return $this->usuarioService = new UsuarioService();
    }
    
    function indexAction(){
//      echo "hola";
        $form = new Formulario("form");
//         $auth = $this->auth;
//         $identi=$auth->getStorage()->read();

        $request = $this->getRequest();
        $postData = $this->getRequest()->getContent();
        $decodePostData = json_decode($postData, true);
        
        $identi=$this->auth->getStorage()->read();
        if($identi!=false && $identi!=null){
            return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/web/index/home');
        }
      

//         Si nos llegan datos por post
        if($this->getRequest()->isPost()){
            $data = $request->getPost()->toArray();
            $res =$this->getUsuarioService()->login($data);
          
            if ($res == false) {
                
                // Crea un mensaje flash y redirige
                $this->flashMessenger()->addMessage("Credenciales incorrectas, intentalo de nuevo");
                return $this->redirect()->toUrl($this->getRequest()
                    ->getBaseUrl() . '/login/user/index');
            } else {
                
                // Le decimos al servicio que guarde en una sesión
                // el resultado del login cuando es correcto
                $this->auth->getStorage()->write($res);
                
                // Nos redirige a una pagina interior
                return $this->redirect()->toUrl($this->getRequest()
                    ->getBaseUrl() . '/web/index/home');
            }

       }
//        print_r("holllllllaaaaaa");exit;
   
     $view = array(
         
         "titulo"=>"Login",
         "form"=>$form,
         'url' => $this->getRequest()->getBaseUrl(),
     );
     
//      print_r($view);
     return new ViewModel($view);
      
       
    } 
    
    
    public function cerrarAction(){
        //Cerramos la sesión borrando los datos de la sesión.
        $this->auth->clearIdentity();
        return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/login/user/index');
    }
    
    
    
    function loginAction()
    {
//         echo "busca login"; exit;
//         $form = new Formulario("form");
        
//         $request = $this->getRequest();
//         if ($request->isPost()) {
//             $postData = $this->getRequest()->getContent();
//             $decodePostData = json_decode($postData, true);
            
//             $result = $this->getUsuarioService()->login($decodePostData);
            
//             $result['flag'] = empty(!$result);
            
//             $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
//                 "response" => $result
//             )));
//             return $response;
//         }
//        print_r("hola");
        
        return new ViewModel(array(
            "titulo"=>"Login"
        ));
    }
    
    public function dentroAction(){
        //Leemos el contenido de la sesión
        $identi=$this->auth->getStorage()->read();
        
        if($identi!=false && $identi!=null){
            $datos=$identi;
        }else{
            $datos="No estas identificado";
        }
        
        return new ViewModel(
            array("datos"=>$datos)
            );
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