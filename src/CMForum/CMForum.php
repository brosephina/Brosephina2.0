<?php

class CMForum extends CObject implements IHasSQL, ArrayAccess, IModule {


  public $data;  
  

  public function __construct($id=null) {
    parent::__construct();
    if($id) {
      $this->LoadById($id);
    } else {
      $this->data = array();
    }
  }
  

  public function offsetSet($offset, $value) { if (is_null($offset)) { $this->data[] = $value; } else { $this->data[$offset] = $value; }}
  public function offsetExists($offset) { return isset($this->data[$offset]); }
  public function offsetUnset($offset) { unset($this->data[$offset]); }
  public function offsetGet($offset) { return isset($this->data[$offset]) ? $this->data[$offset] : null; }

  public static function SQL($key=null) {
    $queries = array(
      'drop table categories'   => "DROP TABLE IF EXISTS Categories;",
      'drop table threads'      => "DROP TABLE IF EXISTS Threads;",
      'drop table posts'        => "DROP TABLE IF EXISTS Posts;",
      
      'create table categories' => "CREATE TABLE IF NOT EXISTS Categories ( id INTEGER PRIMARY KEY, name TEXT);",
      'create table threads'    => "CREATE TABLE IF NOT EXISTS Threads ( id INTEGER PRIMARY KEY, name TEXT, categories INTEGER DEFAULT NULL, idUser INT, created DATETIME default (datetime('now')), updated DATETIME default NULL);",
      'create table posts'      => "CREATE TABLE IF NOT EXISTS Posts ( id INTEGER PRIMARY KEY, threadId INTEGER DEFAULT NULL, content TEXT, idUser INT, created DATETIME default (datetime('now')), updated DATETIME default NULL);",
            
      'insert category'     	=> 'INSERT INTO Categories (name) VALUES (?);',
      'insert threads'     	=> 'INSERT INTO Threads (name, categories, idUser, created) VALUES (?, ?, ?, ?);',
      'insert post'        	=> 'INSERT INTO Posts (threadId, content, idUser, created) VALUES (?, ?, ?, ?);',
      
      'select * categories'     => 'SELECT * FROM Categories',
      'select * threads'        => "SELECT t.*, c.name AS catname, u.acronym AS owner FROM Threads AS t INNER JOIN Categories AS c ON t.categories=c.id INNER JOIN User AS u ON t.idUser=u.id WHERE t.categories = ? ORDER BY created DESC;",
      'select * posts'          => 'SELECT p.*, t.name as thrname, u.acronym AS owner FROM Posts AS p INNER JOIN Threads as t ON p.threadId=t.id INNER JOIN User AS u ON p.idUser=u.id WHERE p.threadId = ?;',    
     );
    if(!isset($queries[$key])) {
      throw new Exception("No such SQL query, key '$key' was not found.");
    }
    return $queries[$key];
  }
  
 public function init()
  {
      $theDate = date('c');

  }
  
  public function Manage($action=null){
		switch($action){
			case 'install':
				try {
				$theDate = date('c');	
      $this->db->ExecuteQuery(self::SQL('drop table categories'));
      $this->db->ExecuteQuery(self::SQL('drop table threads'));
      $this->db->ExecuteQuery(self::SQL('drop table posts'));
      
      $this->db->ExecuteQuery(self::SQL('create table categories'));
      $this->db->ExecuteQuery(self::SQL('create table threads'));
      $this->db->ExecuteQuery(self::SQL('create table posts'));
      
      $this->db->ExecuteQuery(self::SQL('insert category'), array("Competition"));
      $this->db->ExecuteQuery(self::SQL('insert category'), array("Gamecenter"));
      $this->db->ExecuteQuery(self::SQL('insert threads'), array("WHY?", "1", $this->user['id'], $theDate));
      $this->db->ExecuteQuery(self::SQL('insert threads'), array("It is fun", "1", $this->user['id'], $theDate));
      $this->db->ExecuteQuery(self::SQL('insert threads'), array("What is Gamecenter", "2", $this->user['id'], $theDate));
      $this->db->ExecuteQuery(self::SQL('insert threads'), array("Test", "2", $this->user['id'], $theDate));
      $this->db->ExecuteQuery(self::SQL('insert post'), array("1", "There is not mutch to compiting for.", $this->user['id'], $theDate));
      $this->db->ExecuteQuery(self::SQL('insert post'), array("1", "OOO yes it is!!!", $this->user['id'], $theDate));
      $this->db->ExecuteQuery(self::SQL('insert post'), array("2", "Why no?", $this->user['id'], $theDate));
      $this->db->ExecuteQuery(self::SQL('insert post'), array("2", "Exactly", $this->user['id'], $theDate));
      $this->db->ExecuteQuery(self::SQL('insert post'), array("3", "??", $this->user['id'], $theDate));
      $this->db->ExecuteQuery(self::SQL('insert post'), array("4", "testytest", $this->user['id'], $theDate));
      $this->db->ExecuteQuery(self::SQL('insert post'), array("4", "hu?", $this->user['id'], $theDate));
      return array('success', 'Successfully created the database tables and created a default forum, owned by you.');
				}
				catch(Exception$e){
					die("$e<br />Failed to open database: " . $this->config['database'][0]['dsn']);
				}
			break;
			default:
				throw new Exception('Unsupported action for this module.');
			break;
		}
	}

  public function ListAllThreads($thread = null) {
    try {
        return $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * threads'), array($thread));
    } catch(Exception$e) {
      return null;
    }
  }

  public function ListAllCategories() {
    try {
        return $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * categories'));
    } catch(Exception$e) {
      return null;
    }
  }
  
  public function ListAllPosts($threadId) {
    try {
        return $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * posts'), array($threadId));
    } catch(Exception$e) {
      return null;
    }
  }
  
  public function createPost($form)
  {
      $threadId = $this->session->__get("threadNr");
      $date = date('c');
      $this->db->ExecuteQuery(self::SQL('insert post'), array($threadId, $form['content']['value'], $this->user['id'], $date));
      $this->session->__set("threadNr", null);
      return $threadId;
  }
  
  public function createThread($form)
  {
      $date = date('c');
      $category = $this->session->__get("categoryNr");
      $this->db->ExecuteQuery(self::SQL('insert threads'), array($form['topic']['value'], $category, $this->user['id'], $date));
      
      $this->session->__set("categoryNr", null);
      
      
      return $category;
  }
  
  public function createCategory($form)
  {
      $this->db->ExecuteQuery(self::SQL('insert category'), array($form['name']['value']));
  }

}

