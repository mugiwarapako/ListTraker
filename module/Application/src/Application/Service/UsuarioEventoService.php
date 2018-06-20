<?php
namespace Application\Service;

use Application\Model\EventoModel;
use Application\Model\UsuarioEventoModel;

class UsuarioEventoService
{

    private $usuarioEventoModel;

    private $eventoModel;
    
    private function getUsuarioEventoModel()
    {
        return $this->usuarioEventoModel = new UsuarioEventoModel();
    }
    
    private function getEventoModel()
    {
        return $this->eventoModel = new EventoModel();
    }

    public function getAll()
    {
        $usuarioEventos = $this->getUsuarioEventoModel()->getAll();
        
        return $usuarioEventos;
    }

    public function addUsuarioEvento($dataUsuarioEvento)
    {
        $usuariosEventos = $this->getUsuarioEventoModel()->existe($dataUsuarioEvento);
        
        
        if (count($usuariosEventos) == 0) {
//             $usuariosEventos = $this->getUsuarioEventoModel()->addUsuarioEvento($dataUsuarioEvento);
            $buscaTotalParticipantes = $this->getUsuarioEventoModel()->numeroVoluntario($dataUsuarioEvento["idEvento"]);
            print_r($buscaTotalParticipantes); 
            $actualizaParticipates = $this->getEventoModel()->updateEvent($buscaTotalParticipantes, $dataUsuarioEvento["idEvento"]);
        } else {
            $usuariosEventos = "Ya estas registrado en este evento ";
        }
        return $usuariosEventos;
    }

//     public function updateVoluntario($decodePostData)
//     {
//         $updateVoluntario = $this->getVoluntarioSimulacroModel()->updateVoluntario($decodePostData);
        
//         return $updateVoluntario;
//     }

//     public function buscarDetalleVoluntario($decodePostData)
//     {
//         $detallesVoluntario = $this->getVoluntarioSimulacroModel()->buscarDetalleVoluntario($decodePostData);
        
//         return $detallesVoluntario;
//     }

//     public function listaVoluntario($decodePostData)
//     {
//         $arrayRespuesta = array();
        
//         $listaVoluntario = $this->getVoluntarioSimulacroModel()->listaVoluntario($decodePostData);
        
//         $eliminaVoluntario = $this->getVoluntarioSimulacroModel()->eliminaVoluntario($decodePostData);
//         $eliminaMensaje = $this->getMensajeModel()->eliminaMensaje($decodePostData['idSimulacro']);
        
//         $eliminaSismo = $this->getSimulacroGrupoModel()-> eliminarSimulacro($decodePostData);
        
//         $arrayRespuesta['lista'] = $listaVoluntario;
//         $arrayRespuesta['sismo'] = $eliminaSismo;
        
//         return $arrayRespuesta;
//     }

//     public function eliminarVolDeSimulacro($decodePostData)
//     {
//         // print_r($decodePostData['id']);
//         // $idSismo = $this->getVoluntarioSismoModel()->buscarSismo($decodePostData['id']);
//         // $eliminarVoluntario = $this->getVoluntarioSismoModel()->eliminarPartDeSismo($decodePostData);
//         // $buscaTotalVoluntario = $this->getVoluntarioSismoModel()->numeroVoluntarios($idSismo[0]['idSismo']);
//         // $actualizaParticipates = $this->getSimulacroGrupoModel()->updateNumeroVoluntario($buscaTotalVoluntario, $idSismo[0]['idSismo']);
        
//         // return $eliminarVoluntario;
//         $arrayR = array();
//         // print_r($decodePostData['id']);
//         // --$idSismo = $this->getVoluntarioSismoModel()->buscarSismo($decodePostData['id']);
        
//         $eliminarVoluntario = $this->getVoluntarioSimulacroModel()->eliminarVolDeSimulacro($decodePostData);
//         $buscaTotalVoluntario = $this->getVoluntarioSimulacroModel()->numeroVoluntario($decodePostData['idSimulacro']);
//         $actualizaParticipates = $this->getSimulacroGrupoModel()->updateNumeroVoluntario($buscaTotalVoluntario, $decodePostData['idSimulacro']);
//         $arrayR['respuesta'] = $eliminarVoluntario;
//         $arrayR['totalVoluntario'] = ($buscaTotalVoluntario[0]['totalVoluntario']) + 1;
//         return $arrayR;
//     }
}
?>