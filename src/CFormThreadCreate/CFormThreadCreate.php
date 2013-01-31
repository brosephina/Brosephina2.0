<?php
class CFormThreadCreate extends CForm {

   public function __construct($object = null) {
    parent::__construct();
     $this->AddElement(new CFormElementText('topic', array('required'=>true)))
      
         ->AddElement(new CFormElementSubmit('create', array('callback'=>array($object, 'createThread'))));
    
    $this->SetValidation('topic', array('not_empty')); 

  }
  
}
