<?php
namespace Application\Service;

use Application\Model\UserModelModel;

class UserModelsService
{

    private $usModModel;

    private function getUserModelModel()
    {
        return $this->usModModel = new UserModelModel();
    }

    /**
     * Obtenermos todos los participantes
     */
    public function getAll()
    {
        return $this->getUserModelModel()->getAll();
    }

    public function addUserModels($dataUserModel)
    {
        return $this->getUserModelModel()->addUserModels($dataUserModel);
    }
    
    // public function buscarUserModel($id)
    // {
    // $UserModel = $this->getUserModelModel()->buscarUserModel($id);
    
    // return $UserModel;
    // }
}
?>