<?php
namespace Application\Service;

use Application\Model\EventoModel;

class EventoService
{

    private $eventoModel;

    private function getEventoModel()
    {
        return $this->eventoModel = new EventoModel();
    }

    function getAll()
    {
        return $this->getEventoModel()->getAll();
    }

    function addEvent($dataEvento)
    {
        $respuesta = array();
        $evento = $this->getEventoModel()->searchEvent($dataEvento);
        
        if (count($evento) == 0) {
            $respuesta = $this->getEventoModel()->addEvent($dataEvento);
            $respuesta["mensaje"] = "Evento Registrado";
        } else {
            $respuesta["status"] = false;
            $respuesta["mensaje"] = "Ya existe evento en  : " . $evento['direccion'] . "<br />Con fecha : " . $evento["fecha"];
        }
        
        return $respuesta;
    }

    function searchEvent($decodePostData)
    {
        return $this->getEventoModel()->searchEvent($decodePostData);
    }

    function deleteEvent($decodePostData)
    {
        return $this->getEventoModel()->deleteEvent($decodePostData);
    }
    
    function updateEvent($decodePostData)
    {
        return $this->getEventoModel()->updateEvent($decodePostData);
    }
}
?>