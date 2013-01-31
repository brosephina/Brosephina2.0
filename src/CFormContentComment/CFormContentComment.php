<?php
class CFormContentComment extends CForm{

	private $content;


	public function __construct($object, $id){
		parent::__construct();
		$this->AddElement(new CFormElementHidden('id', array('required'=>true, 'value'=>"$id")))
			 ->AddElement(new CFormElementTextarea('data', array('required'=>true, 'label'=>'Comment:')))
			 ->AddElement(new CFormElementSubmit('comment', array('callback'=>array($object, 'doComment'))));

		$this->SetValidation('data', array('not_empty'));
	}
}
