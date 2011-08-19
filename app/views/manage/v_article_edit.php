<?=$pagelinks?>
<div id="article_total">

	<div><span>标题</span><span>见证人</span><span>见证时间</span><span>翻译状态</span><span>操作</span><span>删除</span></div>

	<?php foreach($article as $item): ?>
	<div>
		<span><?=$item->article_title?></span>
		<span><?=$item->testimony_people?></span>
		<span><?=$item->testimony_date?></span>
		<span><?=$item->translation_status?></span>
		<span><?=anchor('manage/article/edit_one_article/'.$item->id,'修改')?></span>
		<span><?=anchor('manage/article/delete_one_article/'.$item->id,'删除')?></span>	
	</div>
	<?php endforeach; ?>

</div><!-- end of article -->