<div id='navbar'>

<?php if($catagory != null):?>
  <?php foreach($catagory as $val):?>
    <?=links2("forum/threads/{$val['id']}", $val['name'])?>
  <?php endforeach; ?>
<?php endif;?>
<?php if(isAuthenticated()){
      echo "<ul>" . userLinks('forum/addCategories', 'Add Category');
	 }?>
</div> 

