<?php
namespace Login\Form;
 
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Form\Factory;
 
class Formulario extends Form
{
    public function __construct($name = null)
     {
        parent::__construct($name);
         
      // $this->setInputFilter(new \Modulo\Form\AddUsuarioValidator());
         
//        $this->setAttributes(array(
//             //'action' => $this->url.'/modulo/recibirformulario',
//             'action'=>"",
//             'method' => 'post'
//         ));

//         $this->add(array(
//             'name' => 'correo',
//             'options' => array(
//                 'label' => 'Correo',
//             ),
//             'attributes' => array(
//                 'type' => 'text',
//                 'class' => 'input'
//             ),
//         ));
        
        
        $this->add(array(
            'name' => 'correo',
            'attributes' => array(
                'type' => 'correo',
                'class' => 'input form-control',
                'required'=>'required'
            )
        ));
         
         $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type' => 'password',
                'class' => 'input form-control',
                'required'=>'required'
            )
        ));
          
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(     
                'type' => 'submit',
                'value' => 'Entrar',
                'title' => 'Entrar',
                'class' => 'btn btn-success'
            ),
        ));
  
     }
}
 
?>