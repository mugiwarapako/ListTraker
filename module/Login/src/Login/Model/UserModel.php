<?php
namespace Login\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;

class UserModel extends TableGateway
{

    private $dbAdapter;
    private $auth;

    function __construct()
    {
        $this->dbAdapter = \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter();
        $this->table = 'usuario';
        $this->featureSet = new Feature\FeatureSet();
        $this->featureSet->addFeature(new Feature\GlobalAdapterFeature());
        $this->initialize();
        
        // Cargamos el servicio de autenticación en el constructor
        $this->auth = new AuthenticationService();
    }

    function getAll()
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select();
        $select->columns(array(
            'id',
            'nombre',
            'apellidoP',
            'apellidoM',
            'correo',
            'telefono'
        ))->from(array(
            'p' => $this->table
        ));
        $selectString = $sql->getSqlStringForSqlObject($select);
        $execute = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
        $result = $execute->toArray();
        
        return $result;
    }

    function login($dataUser)
    {
        
        // $query = "Select id from " . $this->table . " where correo = '" . $dataUser['email'] . "' and password = '" . $dataUser['password'] . "'";
        
        // // echo $query; exit;
        
        // $consulta = $this->dbAdapter->query($query, Adapter::QUERY_MODE_EXECUTE);
        
        // $res = $consulta->toArray();
        
        // return ($res != null && count($res) >0) ? $res[0] : $res;
        
        // echo "<pre>"; print_r($data); exit;
        // Instanciar el servicio de autenticación
        // $auth = new AuthenticationService();
        
        // Configurar la instancia con parámetros de constructor ...
        /*
         * $authAdapter = new AuthAdapter($this->dbAdapter,
         * 'users',
         * 'username',
         * 'password'
         * );
         */
        // print_r("<br> entro al model");
        // print_r($dataUser);
        // print_r("<br> auth : ");
        // ... o configurar la instancia con métodos setter
        $auth = $this->auth;
        $authAdapter = new AuthAdapter($this->dbAdapter);
        
        $authAdapter->setTableName('usuario')
            ->setIdentityColumn('correo')
            ->setCredentialColumn('password');
        
        // Establece los valores de credenciales de entrada (por ejemplo, desde un formulario de inicio de sesión)
        $authAdapter->setIdentity($dataUser['correo'])->setCredential($dataUser['password']);
        
        // Pasamos el adaptador al servixio de autenticacion
        $auth->setAdapter($authAdapter);
        
        // Llevamos a acabo la autenticacion
        $result = $auth->authenticate();
        
        return $authAdapter->getResultRowObject();
       
       
        
        // ************************************************
        
        // $dataResult = array();
        
        // // Validamos el resultado
        // if ($result->isValid()) {
        
        // // Columnas que deseamos
        // $columnsToReturn = array(
        // 'id', 'correo', 'nombre'
        // );
        
        // // Datos de autenticacion
        // $resultRowObject = (array) $authAdapter->getResultRowObject($columnsToReturn);
        // // echo "<pre>"; print_r($resultRowObject); exit;
        // // Arreglo con los datos a devolver
        // $dataResult = array(
        // 'code' => $result->getCode(),
        // 'id' => $resultRowObject['id'],
        // 'correo' => $resultRowObject['correo'],
        // 'nombre' => $resultRowObject['nombre']
        // );
        
        // } else {
        // // Arreglo con los datos a devolver
        // $dataResult = array(
        // 'code' => $result->getCode()
        // );
        // }
        
        // obtenemos la identidad
        // $auth->getIdentity()
        // Obtenemos el codigo de autenticacion
        // $result->getCode()
        // Obtenemos los datos de sesion
        // $authAdapter->getResultRowObject()
        // echo "<pre>"; print_r($dataResult); exit;
        
        // Devolvemos un resultado
        // return $dataResult;
    }

    function existe($dataUser)
    {
        $query = "select * FROM usuario where correo = '" . $dataUser['correo'] . "'";
        
        $consulta = $this->dbAdapter->query($query, Adapter::QUERY_MODE_EXECUTE);
        
        $res = $consulta->toArray();
        
        return ($res != null && count($res) > 0) ? $res[0] : $res;
    }

    function addUser($dataUser)
    {
        $flag = false;
        $respuesta = array();
        
        try {
            $sql = new Sql($this->dbAdapter);
            $insertar = $sql->insert($this->table);
            $array = array(
                'nombre' => $dataUser["nombre"],
                // 'apellidoP' => $dataUser["apellidoP"],
                // 'apellidoM' => $dataUser["apellidoM"],
                'correo' => $dataUser["correo"],
                'telefono' => $dataUser["telefono"],
                'password' => $dataUser["password"]
            );
            $insertar->values($array);
            $selectString = $sql->getSqlStringForSqlObject($insertar);
            $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
            $flag = true;
        } catch (\PDOException $e) {
            $flag = false;
        } catch (\Exception $e) {}
        $respuesta['status'] = $flag;
        
        return $respuesta;
    }

    function updateUser($dataUser)
    {
        $flag = false;
        $respuesta = array();
        
        try {
            $sql = new Sql($this->dbAdapter);
            $update = $sql->update();
            $update->table($this->table);
            
            $array = array(
                'nombre' => $dataUser["nombre"],
                'apellidoP' => $dataUser["apellidoP"],
                'apellidoM' => $dataUser["apellidoM"],
                'correo' => $dataUser["correo"],
                'telefono' => $dataUser["telefono"]
            );
            
            $update->set($array);
            $update->where(array(
                'id' => $dataUser["id"]
            ));
            
            $selectString = $sql->getSqlStringForSqlObject($update);
            $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
            $flag = true;
        } catch (\PDOException $e) {
            // echo "First Message " . $e->getMessage() . "<br/>";
            $flag = false;
        } catch (\Exception $e) {
            // echo "Second Message: " . $e->getMessage() . "<br/>";
        }
        $respuesta['status'] = $flag;
        return $respuesta;
    }

    function deleteUser($dataUser)
    {
        $flag = false;
        $respuesta = array();
        
        try {
            $sql = new Sql($this->dbAdapter);
            $delete = $sql->delete($this->table);
            $delete->where(array(
                'id' => $dataUser["id"]
            ));
            
            $selectString = $sql->getSqlStringForSqlObject($delete);
            $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
            
            $flag = true;
        } catch (\PDOException $e) {
            // echo "First Message " . $e->getMessage() . "<br/>";
            $flag = false;
        } catch (\Exception $e) {
            // echo "Second Message: " . $e->getMessage() . "<br/>";
        }
        $respuesta['status'] = $flag;
        return $respuesta;
    }
}
?>