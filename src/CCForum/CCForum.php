<?php

class CCForum extends CObject implements IController {

  public function __construct() { parent::__construct(); }

  public function Index() {
    $forum = new CMForum();
    $this->views->SetTitle('Forum');
    $this->views->AddInclude(__DIR__ . '/index.tpl.php', array(
                  'contents' => $forum->ListAllCategories(),
                ));
  }
  
  public function init()
  {
    $forum = new CMForum();
    $forum->init();
    $this->RedirectToController();
  }
  
  public function Threads($categories = null)
  {
      if($categories == null)
        $this->RedirectToController();
      else
      {
        $this->session->__set("categoryNr", $categories);
        $this->session->__set("currentCat", $categories);
        $forumModel = new CMForum();
        $this->views->SetTitle('Forum');
        $this->views->AddInclude(__DIR__ . '/index.tpl.php', array(
                  'contents' => $forumModel->ListAllCategories(),
                  'auth' => $this->user->IsAuthenticated(),
                ));
            $this->views->AddInclude(__DIR__ . '/threads.tpl.php', array(
                    'contents'   => $forumModel->ListAllThreads($categories),
                    'category'     => $categories,
                ), "sidebar");

        }
  }
  
  public function Posts($thread = null, $whatPost = null)
  {
      if($thread == null)
        $this->RedirectToController();
      else
      {
        $this->session->__set("threadNr", $thread);
        $categories = $this->session->__get("currentCat");
        $forumModel = new CMForum();
        $this->views->SetTitle('Forum');
        $this->views->AddInclude(__DIR__ . '/posts.tpl.php', array(
                    'contents'   => $forumModel->ListAllPosts($thread),
                    'catagory' => $forumModel->ListAllCategories(),
                    'whatPost'     => $whatPost,
                ));
            $this->views->AddInclude(__DIR__ . '/threads.tpl.php', array(
                    'contents'   => $forumModel->ListAllThreads($categories),
                    'category'     => $categories,
                ), "sidebar");

            
        }
  }
  
  public function newPost($id)
  {
      if($id == null)
        $this->RedirectToController();
      else
      {
        $form = new CFormPostCreate($this);
        $form->Check();
        
        $forumModel = new CMForum();
        $this->views->SetTitle('Forum');
        $this->views->AddInclude(__DIR__ . '/create.post.tpl.php', array(
        	    'user'     =>$this->user,
                    'form'     => $form->GetHTML(),
                ));
        }
      
  }
  
  public function newThread($id = null)
    {
      if($id == null)
        $this->RedirectToController();
      else
      {
        $form = new CFormThreadCreate($this);
        $form->Check();
        
        $forumModel = new CMForum();
        $this->views->SetTitle('Forum');
        $this->views->AddInclude(__DIR__ . '/create.thread.tpl.php', array(
        	    'user'     =>$this->user,
                    'form'     => $form->GetHTML(),
                ));
        }  
   }
   
   public function addCategories()
    {
      if(!$this->user->IsAuthenticated())
        $this->RedirectToController();
      else
      {
        $form = new CFormCategoryCreate($this);
        $form->Check();
        
        $forumModel = new CMForum();
        $this->views->SetTitle('Forum');
        $this->views->AddInclude(__DIR__ . '/create.categorie.tpl.php', array(
                    'form'     => $form->GetHTML(),
                ));
        }  
   }

  public function createPost($form)
   {
     $forumModel = new CMForum();
     $threadNr = $forumModel->createPost($form);
     $this->RedirectTo('forum/posts/' . $threadNr);
   }
   
    public function createThread($form)
   {
     $forumModel = new CMForum();
     $category = $forumModel->createThread($form);
     $this->RedirectTo('forum/threads/' . $category);
   }
   
   public function createCategory($form)
   {
     $forumModel = new CMForum();
     $forumModel->createCategory($form);
     $this->RedirectToController('');
   }
}
?>
