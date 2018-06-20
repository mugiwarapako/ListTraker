<?php
namespace Application\Service;

use Application\Model\ModelsModel;

class ModelsService
{

    private $modelsModel;

    private function getVolCreadorModel()
    {
        return $this->modelsModel = new ModelsModel();
    }

    /**
     * Obtenermos todos los participantes
     */
    public function getAll()
    {
        $volCreador = $this->getVolCreadorModel()->getAll();
        
        return $volCreador;
    }

    public function addModel($dataModel)
    {
        $arrayResponse = array();
        try {
            
            $usuario = $this->getVolCreadorModel()->addVolModelo($dataModel);
            $arrayResponse = array(
                "flag" => 'true',
                "usuario" => $usuario
            );
        } catch (\PDOException $e) {
            echo "First Message " . $e->getMessage() . "<br/>";
            
            $arrayResponse = array(
                "flag" => 'false'
            );
        } catch (\Exception $e) {
            echo "Second Message: " . $e->getMessage() . "<br/>";
        }
        
        // echo print_r($arrayresponse);
        // exit;
        
        return $arrayResponse;
    }

    public function existModel($decodePostData)
    {
        $existeVolCreador = $this->getVolCreadorModel()->existe($decodePostData['folio']);
        return $existeVolCreador;
    }
    
    
    public function mostrarModeloId($id)
    {
        return $this->getVolCreadorModel()->mostrarModeloId($id);

    }
    
    public function viewAll()
    {
        return $this->getVolCreadorModel()->viewAll();
        
    }
    
    
}
?>