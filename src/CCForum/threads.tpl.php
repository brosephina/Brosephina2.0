<?php if($contents != null):?>
<h2><?=$contents[0]['catname'];
if(isAuthenticated()){
      userLinks('forum/addCategories', 'Add Category');
	 }
	 ?></h2>
  <ul>
  <?php foreach($contents as $val):?>
    <li><?=userLinks("forum/posts/{$val['id']}", $val['name']) . "<br/>"?>
    <?="made by " . $val['owner'] . " at " . $val['created'];?>
  <?php endforeach; ?>
  <br/><br/>
  <?php if(isAuthenticated()){?>
  <li><?=userLinks("forum/newThread/{$category}", "Make New Thread");?>
  <li><?=userLinks("forum", "Back");?>
  <?php }?>
  </ul>
<?php endif;?>
<?php if($contents == null)
{
echo "<h2>Category is empty</h2>";
if(isAuthenticated()){
echo "<ul><li>" . userLinks("forum/newThread/{$category}", "Make New Thread");
echo "<li>"  . userLinks("forum", "Back") . "</ul>";
}}
?> 
