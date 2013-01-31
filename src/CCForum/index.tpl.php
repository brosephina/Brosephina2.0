<h1>Forum</h1>
<p>Pick one of the categories to see the threads.</p>
  <?php
    
    require_once('categories.tpl.php');
    if(isAuthenticated()){
      echo "<ul>" . userLinks('forum/addCategories', 'Add Category');
	 }
  ?>
  </ul> 
