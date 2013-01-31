<h1>Forum</h1>
<p>Pick one of the categories to see the threads.</p>
<?php require_once('categorie2.tpl.php'); ?>
<h1><?=$contents[0]['thrname']?></h1>
<?php if($contents == null){ echo "<p> Contents is empty. </p>";?>
	<?php if(isAuthenticated()){ ?>
    <li><?=userLinks("forum/newPost/{$val['id']}", "Make New Post");?>
    <li><?=userLinks("forum", "Back");?>
<?php }} ?>
<?php if($contents != null):?>
  <ul>
  <?php foreach($contents as $val):?>
  <?= "<div style='border-style:solid; border-width:medium;'>" . $val['content'] . "<br/><br/><br/></div>";?>
  <div style='text-align: center; border-style:solid; border-width:medium;'>
  <?php echo "Made by " . $val['owner'];?>
  <?php if($val['updated'] != null) {echo "Updated at " . $val['updated'];}
  else {echo "<br/>Created at " . $val['created'];}?>
  </div>
  <br/>
  <?php endforeach; ?>
  <?php if(isAuthenticated()){ ?>
    <li><?=userLinks("forum/newPost/{$val['id']}", "Make New Post");?>
    <li><?=userLinks("forum", "Back");?>
  <?php } ?>
  </ul>
<?php endif;?> 
