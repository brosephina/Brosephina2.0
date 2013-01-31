<?php
class CFormPostCreate extends CForm {


  public function __construct($object = null) {
    parent::__construct();
    $this->AddElement(new CFormElementTextarea('content', array('required'=>true)))
         ->AddElement(new CFormElementSubmit('create', array('callback'=>array($object, 'createPost'))));
         
    $this->SetValidation('content', array('not_empty'));
  }
  
} 
