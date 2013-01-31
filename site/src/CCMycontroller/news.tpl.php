<h1>News & Blog</h1>
<h3>All nice news and blogposts.</h3>

<?php if($contents != null): ?>
	<?php foreach($contents as $val):?>
		<h2><a href='<?=create_url("page/view/{$val['id']}")?>'><?=esc($val['title'])?></a></h2>
		<p class='smaller-text'><em>Posted on <?=$val['created']?> by <?=$val['owner']?></em></p>
		<p><?=filter_data($val['data'], $val['filter'])?></p>
		<?php if(hasAdminRole()){ ?>
		<p class='smaller-text' silent><a href='<?=create_url("content/edit/{$val['id']}")?>'>edit</a></p>
		<?php } ?>
	<?php endforeach; ?>
<?php else: ?>
	<p>No posts exists.</p>
<?php endif; ?>

