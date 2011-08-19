<?=$pagelinks?>
<ol>
<?php foreach($article as $article_item): ?>
<li>
	<div>标题：<?=$article_item->article_title?><br />
		  见证时间：<?=$article_item->testimony_date?>
		  见证人：<?=$article_item->testimony_people?>
		  翻译状态：<?=$article_item->translation_status?><br />
		<?php echo character_limiter($article_item->article_zh, 20);?>
	</div>
</li>
<?php endforeach; ?>
</ol>

