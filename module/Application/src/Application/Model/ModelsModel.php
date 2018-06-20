<?php
namespace Application\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\Feature;
use Zend\Db\TableGateway\TableGateway;

class ModelsModel extends TableGateway
{

    private $dbAdapter;

    public function __construct()
    {
        $this->dbAdapter = \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter();
        $this->table = 'modelo';
        $this->featureSet = new Feature\FeatureSet();
        $this->featureSet->addFeature(new Feature\GlobalAdapterFeature());
        $this->initialize();
    }

    public function getAll()
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select();
        $select->columns(array(
                'id',
                'descripcion',
                'imagen',
                'id_evento'
        ))->from(array(
            'v' => $this->table
        ));
        $selectString = $sql->getSqlStringForSqlObject($select);
        // print_r($selectString); exit;
        $execute = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
        $result = $execute->toArray();
        // echo "<pre>"; print_r($result); exit;
        
        return $result;
    }

    public function existe($folioNuevo)
    {
        
        // print_r($folioNuevo);
        // $consulta=$this->dbAdapter->query("select id , folio FROM voluntarioCreador where nombre = '" . $dataUser['nombre']."' and correo = '".$dataUser['correo']. "'" ,Adapter::QUERY_MODE_EXECUTE);
        $consulta = $this->dbAdapter->query("select * correo FROM modelo where folio = '" . $folioNuevo . "'", Adapter::QUERY_MODE_EXECUTE);
        
        $res = $consulta->toArray();
        // echo "res ";
        // print_r($res);
        
        return $res;
    }

    

    public function addVolModelo($dataModelo)
    {
        $flag = false;
        $respuesta = array();
        
        date_default_timezone_set('America/Mexico_City');
        $current_date = date("Y-m-d H:i:s");
        
        try {
            $sql = new Sql($this->dbAdapter);
            $insertar = $sql->insert($this->table);
            
            $array = array(
                'descripcion'=> $dataModelo['descripcion'],
                'imagen'=> $dataModelo['imagen'],
                'id_evento'=> $dataModelo['id_evento'],
                'id_usuario'=> $dataModelo['id_usuario'],
                'latitud'=> $dataModelo['latitud'],
                'longitud'=> $dataModelo['longitud'],
                'status'=> $dataModelo['status'],
                'fecha-hora'=> $current_date
            );
            
            $insertar->values($array);
            
            $selectString = $sql->getSqlStringForSqlObject($insertar);
            $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
            $flag = true;
        } catch (\PDOException $e) {
             echo "First Message " . $e->getMessage() . "<br/>";
            $flag = false;
        } catch (\Exception $e) {
             echo "Second Message: " . $e->getMessage() . "<br/>";
        }
        $respuesta['status'] = $flag;

        return $respuesta;
    }

    public function updateModelo($dataModelo)
    {
        
        $flag = false;
        $respuesta = array();
        
        try {
            $sql = new Sql($this->dbAdapter);
            $update = $sql->update();
            $update->table('voluntarioCreador');
            
            $array = array(
                'descripcion'=> $dataModelo['descripcion'],
                'imagen'=> $dataModelo['imagen'],
                'id_evento'=> $dataModelo['id_evento']
            );
            
            $update->set($array);
            $update->where(array(
                'id' => $dataModelo[0]['id']
            ));
            
            $selectString = $sql->getSqlStringForSqlObject($update);
            $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
        } catch (\PDOException $e) {
            // echo "First Message " . $e->getMessage() . "<br/>";
            $flag = false;
        } catch (\Exception $e) {
            // echo "Second Message: " . $e->getMessage() . "<br/>";
        }
        $respuesta['status'] = $flag;
        return $respuesta;
    }
    
    
    public function mostrarModeloId($id)
    {

        $consulta = $this->dbAdapter->query("select imagen FROM modelo where id = '" . $id . "'", Adapter::QUERY_MODE_EXECUTE);
        
        $res = $consulta->toArray();

        return $res;
        
    }
    
    function viewAll(){
        
        $res = array();
        
        try {
            $query  = "select modelo.id, modelo.descripcion, modelo.imagen, modelo.longitud, 
                        modelo.latitud, modelo.status, DATE_FORMAT(modelo.fechaHora, '%d/%m/%Y') AS fecha,
                        DATE_FORMAT(modelo.fechaHora, '%H:%i') as hora, usuario.nombre 
                       from modelo, usuario  
                       where modelo.id_usuario = usuario.id
                       order by id";

            //print_r($query); exit;
            
            $consulta = $this->dbAdapter->query($query, Adapter::QUERY_MODE_EXECUTE);
            
            $res = $consulta->toArray();
            
            //print_r($res); exit;
            
            return $res;
            
        } catch (\Exception $e) {
            // echo "Second Message: " . $e->getMessage() . "<br/>";
        } finally {
            return $res;
        }
    }
}

?>






