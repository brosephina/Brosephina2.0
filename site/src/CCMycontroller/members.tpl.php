<h1>Clan Members</h1>
<?php if($contents != null): ?>
	<?php foreach($contents as $val):?>
	<p>Name: <?=esc($val['name'])?></p>
	<p>Acronym: <?=esc($val['acronym'])?></p>
	<p>Email :<?=esc($val['email'])?></p>
	<p>Created: <?=esc($val['created'])?></p>
	<?php endforeach; ?>
<?php else: ?>
	<p>No posts exists.</p>
<?php endif; ?>
