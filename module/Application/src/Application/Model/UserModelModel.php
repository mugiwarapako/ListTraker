<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class UserModelModel extends TableGateway
{
	private $dbAdapter;

	public function __construct()
	{
		$this->dbAdapter  = \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter();
    	$this->table      = 'usuario_modelo';
       	$this->featureSet = new Feature\FeatureSet();
     	$this->featureSet->addFeature(new Feature\GlobalAdapterFeature());
    	$this->initialize();
	}

	/**
	* OBTEMOS TODOS los imeis
	*/
	public function getAll()
	{
		$sql = new Sql($this->dbAdapter);
		$select = $sql->select();
		$select
		->columns(array('id_usuario', 'id_modelo', 'calf_arriba', 'calf_media', 'calif_bajo'))
			->from(array('m' => $this->table));
		$selectString = $sql->getSqlStringForSqlObject($select);
		//print_r($selectString); exit;
		$execute      = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
		$result       = $execute->toArray();
		//echo "<pre>"; print_r($result); exit;

		return $result;
	}
	
	public function addUserModels($dataMensaje){
		
	    $flag = false;
	    $respuesta = array();
	    try {
	        $sql = new Sql($this->dbAdapter);
	        $insertar = $sql->insert($this->table);
	        $array=array(
	            
	            'id_usuario' =>$dataMensaje["id_usuario"],
	            'id_modelo' =>$dataMensaje["id_modelo"],
	            'calf_arriba' =>$dataMensaje["calf_arriba"],
	            'calf_media' =>$dataMensaje["calf_media"],
	            'calif_bajo' =>$dataMensaje["calif_bajo"]
	        );
	        //		print_r($array);
	        //		exit;
	        $insertar->values($array);
	        $selectString = $sql->getSqlStringForSqlObject($insertar);
	        $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
	        $flag = true;
	    }
	    catch (\PDOException $e) {
	        //echo "First Message " . $e->getMessage() . "<br/>";
	        $flag = false;
	    }catch (\Exception $e) {
	        //echo "Second Message: " . $e->getMessage() . "<br/>";
	    }
	    $respuesta['status'] = $flag;

		return $respuesta;
		
	}
	
	public function buscarMensaje($id) {
	    
	    $sql = new Sql($this->dbAdapter);
	    $select = $sql->select();
	    $select
	    ->columns(array('id', 'mensajeCreador' , 'idSimulacrogrupo'))
	    ->from(array('m' => $this->table))
	    ->where(array('idSismogrupo'=>$id));
	    $selectString = $sql->getSqlStringForSqlObject($select);
	    //print_r($selectString); exit;
	    $execute      = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
	    $result       = $execute->toArray();
	    //echo "<pre>"; print_r($result); exit;
	    
// 	    print_r($result);
	    return $result;;
	    	    
	}
	
	
	public function eliminaMensaje($dataPartSismo){
	    
	    $flag = false;
	    $respuesta = array();
	    try {
	        
	        $sql = new Sql($this->dbAdapter);
	        $delete = $sql->delete('mensajes');
	        $delete->where(array('idSimulacrogrupo' => $dataPartSismo));
	        
	        $selectString = $sql->getSqlStringForSqlObject($delete);
	        $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
	        
	        // $consulta=$this->dbAdapter->query("DELETE FROM participante_sismo_grupo where idSismo = '" . $dataPartSismo["idSismo"]."'" ,Adapter::QUERY_MODE_EXECUTE);
	        // 	        $res=$consulta->toArray();
	        $flag = true;
	    }catch (\PDOException $e) {
	        //echo "First Message " . $e->getMessage() . "<br/>";
	        $flag = false;
	    }catch (\Exception $e) {
	        //echo "Second Message: " . $e->getMessage() . "<br/>";
	    }
	    $respuesta['status'] = $flag;
	    
	    return $respuesta;
	    
	    
	    
	    // 	    print_r($res);
	    // 	    exit;
	    
	}
	
	

}
?>