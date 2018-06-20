<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class UserModel extends TableGateway
{

    private $dbAdapter;

    function __construct()
    {
        $this->dbAdapter = \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter();
        $this->table = 'usuario';
        $this->featureSet = new Feature\FeatureSet();
        $this->featureSet->addFeature(new Feature\GlobalAdapterFeature());
        $this->initialize();
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
    
    function login($dataUser){
        
        
        $query = "Select id from " . $this->table . " where correo   = '" . $dataUser['email'] . "' and password = '" . $dataUser['password'] . "'";
        
//         echo $query; exit;
        
        $consulta = $this->dbAdapter->query($query, Adapter::QUERY_MODE_EXECUTE);
        
        $res = $consulta->toArray();
        
        return ($res != null && count($res) >0) ? $res[0] : $res;
        
    }

    function existe($dataUser)
    {
        $query ="select * FROM usuario where correo = '" . $dataUser['correo']."'";
        
        $consulta = $this->dbAdapter->query($query, Adapter::QUERY_MODE_EXECUTE);
        
        $res = $consulta->toArray();
        
        return ($res != null && count($res) >0) ? $res[0] : $res;
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
//                 'apellidoP' => $dataUser["apellidoP"],
//                 'apellidoM' => $dataUser["apellidoM"],
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
        } catch (\Exception $e) {
        }
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