<div id="">
	<h3>view translated articles by cults:</h3>
	<ul>
		<?php foreach($type_cult_all as $item): ?>
			<li><a href="<?=site_url()?>/cult/show/<?=strtolower($item->id)?>"><?=$item->fullname_en?></a></li>
		<?php endforeach; ?>
	</ul>
</div>
