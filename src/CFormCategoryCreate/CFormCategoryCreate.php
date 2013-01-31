<?php
class CFormCategoryCreate extends CForm {

  public function __construct($object = null) {
    parent::__construct();
    $this->AddElement(new CFormElementText('name', array('required'=>true)))
         ->AddElement(new CFormElementSubmit('create', array('callback'=>array($object, 'createCategory'))));
         
    $this->SetValidation('name', array('not_empty'));
  }
  
} 
