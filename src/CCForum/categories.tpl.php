<div id='navbar'>

<?php if($contents != null):?>
  <?php foreach($contents as $val):?>
    <?=userLinks("forum/threads/{$val['id']}", $val['name'])?>
  <?php endforeach; ?>
<?php endif;?>

</div> 
