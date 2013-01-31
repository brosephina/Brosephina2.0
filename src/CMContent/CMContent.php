<?php
class CMContent extends CObject implements IHasSQL, ArrayAccess, IModule {

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



  public static function SQL($key=null, $args=null){
		$order_order = isset($args['order-order']) ? $args['order-order'] : 'ASC';
		$order_by = isset($args['order-by']) ? $args['order-by'] : 'id';
		$limit = isset($args['limit']) ? 'LIMIT '.$args['limit'] : '';
		$queries = array(
			'drop table content'	=> "DROP TABLE IF EXISTS Content;",
			'drop table comments'	=> "DROP TABLE IF EXISTS ContentComments;",
			'create table content'	=> "CREATE TABLE IF NOT EXISTS Content (id INTEGER PRIMARY KEY, key TEXT KEY, type TEXT, title TEXT, data TEXT, filter TEXT, idUser INT, created DATETIME default (datetime('now')), updated DATETIME default NULL, deleted DATETIME default NULL, FOREIGN KEY(idUser) REFERENCES User(id));",
			'create table comments'	=> "CREATE TABLE IF NOT EXISTS ContentComments (id INTEGER PRIMARY KEY, data TEXT, idContent INT, created DATETIME default (datetime('now')), updated DATETIME default NULL, deleted DATETIME default NULL, FOREIGN KEY(idContent) REFERENCES Content(id));",
			'insert content'	=> 'INSERT INTO Content (key,type,title,data,filter,idUser) VALUES (?,?,?,?,?,?);',
			'insert comment'	=> 'INSERT INTO ContentComments (data,idContent) VALUES (?,?);',
			'select * by id'	=> "SELECT c.*, u.acronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id WHERE c.id=? AND deleted IS NULL;",
			'select * by key'	=> "SELECT c.*, u.acronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id WHERE c.key=? AND deleted IS NULL ORDER BY {$order_by} {$order_order} {$limit};",
			'select * by type'	=> "SELECT c.*, u.acronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id WHERE type=? AND deleted IS NULL ORDER BY {$order_by} {$order_order} {$limit};",
			'select *'		=> "SELECT c.*, u.acronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id WHERE deleted IS NULL ORDER BY {$order_by} {$order_order} {$limit};",
			'select comments'	=> 'SELECT * FROM ContentComments WHERE idContent=? ORDER BY created DESC;',
			'update content'	=> "UPDATE Content SET key=?, type=?, title=?, data=?, filter=?, updated=datetime('now') WHERE id=?;",
			'update content as deleted' => "UPDATE Content SET deleted=datetime('now') WHERE id=?;",
		);
		if(!isset($queries[$key])){
			throw new Exception("No such SQL query, key '$key' was not found.");
		}
		return $queries[$key];
	}



  public function Manage($action=null){
		switch($action){
			case 'install':
				try {
					$this->db->ExecuteQuery(self::SQL('drop table content'));
					$this->db->ExecuteQuery(self::SQL('drop table comments'));
					$this->db->ExecuteQuery(self::SQL('create table content'));
					$this->db->ExecuteQuery(self::SQL('create table comments'));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('news', 'post', 'Starting the clan', "NOW it's time to start this clan website that will hopefully expand the clan and improve it.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('news', 'post', 'Now it goes on', "There is another one who has joined the clan, John Doe, Welcome.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('news', 'post', 'Now we want more', "Now we need to get more clan members, so invite your friends so we'll see what happens.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('home', 'page', 'Home page', "This is a demo page, this could be your personal home-page.\n\nLydia is a PHP-based MVC-inspired Content management Framework, watch the making of Lydia at: http://dbwebb.se/lydia/tutorial.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('about', 'page', 'About page', "This is a demo page, this could be your personal about-page.\n\nBrosephina is used as a tool to educate in MVC frameworks.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('download', 'page', 'Download page', "This is a demo page, this could be your personal download-page.\n\nYou can download your own copy of lydia from https://github.com/mosbth/lydia.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('bbcode', 'page', 'Page with BBCode', "This is a demo page with some BBCode-formatting.\n\n[b]Text in bold[/b] and [i]text in italic[/i] and [url=http://dbwebb.se]a link to dbwebb.se[/url]. You can also include images using bbcode, such as the lydia logo: [img]http://dbwebb.se/lydia/current/themes/core/logo_80x80.png[/img]", 'bbcode', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('htmlpurify', 'page', 'Page with HTMLPurifier', "This is a demo page with some HTML code intended to run through <a href='http://htmlpurifier.org/'>HTMLPurify</a>. Edit the source and insert HTML code and see if it works.\n\n<b>Text in bold</b> and <i>text in italic</i> and <a href='http://dbwebb.se'>a link to dbwebb.se</a>. JavaScript, like this: <javascript>alert('hej');</javascript> should however be removed.", 'htmlpurify', $this->user['id']));
					return array('success', 'Successfully created the database tables and created a default "Hello World" blog post, owned by you.');
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

  public function Save() {
    $msg = null;
    if($this['id']) {
      $this->db->ExecuteQuery(self::SQL('update content'), array($this['key'], $this['type'], $this['title'], $this['data'], $this['filter'], $this['id']));
      $msg = 'update';
    } else {
      $this->db->ExecuteQuery(self::SQL('insert content'), array($this['key'], $this['type'], $this['title'], $this['data'], $this['filter'], $this->user['id']));
      $this['id'] = $this->db->LastInsertId();
      $msg = 'created';
    }
    $rowcount = $this->db->RowCount();
    if($rowcount) {
      $this->AddMessage('success', "Successfully {$msg} content '" . htmlEnt($this['key']) . "'.");
    } else {
      $this->AddMessage('error', "Failed to {$msg} content '" . htmlEnt($this['key']) . "'.");
    }
    return $rowcount === 1;
  }
  
  public function Delete(){
		if(!$this->user->IsAdministrator()){
			$this->AddMessage('error', "Failed to set content '" . htmlEnt($this['key']) . "' as deleted. You need to be administrator for that!");
			return 0;
			exit;
		}
		if($this['id']){
			$this->db->ExecuteQuery(self::SQL('update content as deleted'), array($this['id']));
		}
		$rowcount = $this->db->RowCount();
		if($rowcount){
			$this->AddMessage('success', "Successfully set content '" . htmlEnt($this['key']) . "' as deleted.");
		}
		else{
			$this->AddMessage('error', "Failed to set content '" . htmlEnt($this['key']) . "' as deleted.");
		}
		return $rowcount === 1;
	}


  public function LoadById($id) {
    $res = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * by id'), array($id));
    if(empty($res)) {
      $this->AddMessage('error', "Failed to load content with id '$id'.");
      return false;
    } else {
      $this->data = $res[0];
    }
    return true;
  }
  

 public function ListAll($args=null) {    
    try {
      if(isset($args) && isset($args['type'])) {
        return $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * by type', $args), array($args['type']));
      } else {
        return $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select *', $args));
      }
    } catch(Exception $e) {
      echo $e;
      return null;
    }
  }
  
  public static function Filter($data, $filter) {
    switch($filter) {
      case 'htmlpurify': $data = nl2br(CHTMLPurifier::Purify($data)); break;
      case 'bbcode': $data = nl2br(bbcode2html(htmlEnt($data))); break;
      case 'plain': 
      default: $data = nl2br(makeClickable(htmlEnt($data))); break;
    }
    return $data;
  }
  
  public function GetFilteredData() {
    return $this->Filter($this['data'], $this['filter']);
  }
  
  public function Comment($data, $id){
		$this->db->ExecuteQuery(self::SQL('insert comment'), array($data, $id));
		if($this->db->RowCount() == 0){
			$this->AddMessage('error', 'Failed to insert comment.');
			return false;
		}
		return true;
	}
	public function LoadByIdWithComments($id) {
		try{
			$result = null;
			$res = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * by id'), array($id));
			if(!empty($res)){
				$result = $res[0];
				$res = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select comments'), array($id));
				if(!empty($res)){
					$result['comments'] = $res;
				}
			}
			return $result;
		}
		catch(Exception$e){
			echo $e;
			return null;
		}
	}
  
  
}
