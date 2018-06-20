<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class EventoModel extends TableGateway
{

    private $dbAdapter;

    function __construct()
    {
        $this->dbAdapter = \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter();
        $this->table = 'evento';
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
            'nombreEvento',
            'direccion',
            'fecha',
            'numeroLugares',
            'numeroParticipantes',
            'hora'
        ))->from(array(
            's' => $this->table
        ));
        $selectString = $sql->getSqlStringForSqlObject($select);
        $execute = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
        $result = $execute->toArray();
        
        return $result;
    }

    function addEvent($dataEvent)
    {
        $flag = false;
        $respuesta = array();
        
        try {
            
            $sql = new Sql($this->dbAdapter);
            
            $insertar = $sql->insert($this->table);
            
            $array = array(
                'nombreEvento' => $dataEvent["nombreEvento"],
                'direccion' => $dataEvent["direccion"],
                'fecha' => $dataEvent["fecha"],
                'numeroLugares' => $dataEvent["numeroLugares"],
                'numeroParticipantes' => 1
//                 'hora' => $dataEvent["hora"]
            );
            $insertar->values($array);
            
            $selectString = $sql->getSqlStringForSqlObject($insertar);
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

    function searchEvent($dataEvent)
    {
        $where = "";
        
        if ($dataEvent["direccion"] != null && ! empty($dataEvent["direccion"])) {
            
            if ($dataEvent["fecha"] != null && ! empty($dataEvent["fecha"])) {
                $where = "where direccion = '" . $dataEvent['direccion'] . "' and fecha like '" . $dataEvent["fecha"] . "%'";
            } else {
                $where = "where direccion = '" . $dataEvent['direccion'] . "'";
            }
        } else {
            if ($dataEvent["fecha"] != null && ! empty($dataEvent["fecha"])) {
                $where = "where fecha like '" . $dataEvent["fecha"] . "%'";
            }
        }
        
        $query = "select * FROM evento " . $where;
        
        $consulta = $this->dbAdapter->query($query, Adapter::QUERY_MODE_EXECUTE);
        
        $res = $consulta->toArray();
        
        return ($res != null && count($res) > 0) ? $res[0] : $res;
    }

    function deleteEvent($dataEvent)
    {
        $flag = false;
        $respuesta = array();
        
        try {
            $sql = new Sql($this->dbAdapter);
            $delete = $sql->delete($this->table);
            $delete->where(array(
                'id' => $dataEvent["id"]
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
    
    function updateEvent($dataEvent)
    {
        $flag = false;
        $respuesta = array();
        
        try {
            $sql = new Sql($this->dbAdapter);
            $update = $sql->update();
            $update->table($this->table);
            
            $array = array(
                'nombreEvento' => $dataEvent["nombreEvento"],
                'direccion' => $dataEvent["direccion"],
                'fecha' => $dataEvent["fecha"],
                'numeroLugares' => $dataEvent["numeroLugares"],
                'numeroParticipantes' => $dataEvent["numeroParticipantes"],
                'hora' => $dataEvent["hora"]
            );
            
            $update->set($array);
            $update->where(array(
                'id' => $dataEvent["id"]
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

    function updateParticipants($total, $idEvent)
    {
        $flag = false;
        $respuesta = array();
        
        try {
            $sql = new Sql($this->dbAdapter);
            $update = $sql->update();
            $update->table($this->table);
            
            $array = array(
                'numeroParticipantes' => $total["totalParticipantes"] + 1
            );
            
            $update->set($array);
            $update->where(array(
                'id' => $idEvent
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
}
?>