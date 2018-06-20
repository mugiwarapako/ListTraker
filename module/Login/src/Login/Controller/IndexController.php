<?php
namespace Login\Controller;   

use Application\Service\UsuarioService;
use Login\Form\Formulario;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class IndexController extends AbstractActionController
{

    private $usuarioService;

    function getUsuarioService()
    {
        return $this->usuarioService = new UsuarioService();
    }
    
    function index(){
        return new ViewModel(array(
            "titulo"=>"Login",
            "form"=>$form,
            "prueba"=>$prueba
            
            
        ));
    }
    
    function loginAction()
    {
       
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


// *************************************************************************************************








namespace Modulo\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Validator;
use Zend\I18n\Validator as I18nValidator;
use Zend\Db\Adapter\Adapter;
use Zend\Crypt\Password\Bcrypt;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;

//Componentes de autenticación
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Session\Container;

//Incluir modelos
use Modulo\Model\Entity\UsuariosModel;

//Incluir formularios
use Modulo\Form\LoginForm;

class UsuariosController extends AbstractActionController{
    private $dbAdapter;
    private $auth;
    
    public function __construct() {
        //Cargamos el servicio de autenticación en el constructor
        $this->auth = new AuthenticationService();
    }
    
    public function indexAction(){
        //Vamos a utilizar otros métodos
        return new ViewModel();
    }
    
    public function loginAction(){
        //
        $auth = $this->auth;
        $identi=$auth->getStorage()->read();
        if($identi!=false && $identi!=null){
            return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuarios/dentro');
        }
        
        //DbAdapter
        $this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
        
        //Creamos el formulario de login
        $form=new LoginForm("form");
        
        //Si nos llegan datos por post
        if($this->getRequest()->isPost()){
            
            /* Creamos la autenticación a la que le pasamos:
             1. La conexión a la base de datos
             2. La tabla de la base de datos
             3. El campo de la bd que hará de username
             4. El campo de la bd que hará de contraseña
             */
            $authAdapter = new AuthAdapter($this->dbAdapter,
                'usuarios',
                'email',
                'password'
                );
            
            /*
             Podemos hacer lo mismo de esta manera:
             $authAdapter = new AuthAdapter($dbAdapter);
             $authAdapter
             ->setTableName('users')
             ->setIdentityColumn('username')
             ->setCredentialColumn('password');
             */
            
            /*
             En el caso de que la contraseña en la db este cifrada
             tenemos que utilizar el mismo algoritmo de cifrado
             */
            $bcrypt = new Bcrypt(array(
                'salt' => 'aleatorio_salt_pruebas_victor',
                'cost' => 5));
            
            $securePass = $bcrypt->create($this->request->getPost("password"));
            
            //Establecemos como datos a autenticar los que nos llegan del formulario
            $authAdapter->setIdentity($this->getRequest()->getPost("email"))
            ->setCredential($securePass);
            
            
            //Le decimos al servicio de autenticación que el adaptador
            $auth->setAdapter($authAdapter);
            
            //Le decimos al servicio de autenticación que lleve a cabo la identificacion
            $result=$auth->authenticate();
            
            //Si el resultado del login es falso, es decir no son correctas las credenciales
            if($authAdapter->getResultRowObject()==false){
                
                //Crea un mensaje flash y redirige
                $this->flashMessenger()->addMessage("Credenciales incorrectas, intentalo de nuevo");
                return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuarios/login');
            }else{
                
                // Le decimos al servicio que guarde en una sesión
                // el resultado del login cuando es correcto
                $auth->getStorage()->write($authAdapter->getResultRowObject());
                
                //Nos redirige a una pagina interior
                return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuarios/dentro');
            }
        }
        
        return new ViewModel(
            array("form"=>$form)
            );
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
    
    public function cerrarAction(){
        //Cerramos la sesión borrando los datos de la sesión.
        $this->auth->clearIdentity();
        return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuarios/login');
    }
}





















?>