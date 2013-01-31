<?php
class CCPage extends CObject implements IController {

  public function __construct() {
    parent::__construct();
  }

  public function Index() {
    $content = new CMContent();
    $this->views->SetTitle('Page');
    $this->views->AddInclude(__DIR__ . '/index.tpl.php', array(
                  'content' => null,
                ));
  }



  public function View($id=null){
		$content = new CMContent();
		$form = new CFormContentComment($this, $id);
		if($form->Check() === false){
			$this->AddMessage('notice', 'You must fill in all values.');
			$this->RedirectToController('view', $id);
		}
		$this->views->SetTitle('News');
		$this->views->AddInclude(__DIR__ . '/index.tpl.php', array(
			'content' => $content->LoadByIdWithComments($id),
			'form' => $form->GetHTML(),
		));
	}
  
  public function DoComment($form){
		if(!$this->user->IsAuthenticated()){
			$this->RedirectTo('user', 'login');
			exit;
		}
		$content = new CMContent();
		if($content->Comment($form['data']['value'], $form['id']['value'])){
			$this->AddMessage('success', "Your comment was successfully created.");			
			$this->RedirectTo('page', 'view', $form['id']['value']);
		}
		else{
			$this->AddMessage('notice', 'Failed to create a comment.');
			$this->RedirectTo('page', 'view', $form['id']['value']);
		}
	}


}
