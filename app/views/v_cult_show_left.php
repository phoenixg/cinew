<div id="cult_show_left">
	<select name="type_article" id="type_article" onchange="location='<?php echo site_url('cult/show/'); ?>/<?php echo $this->uri->segment(3,0);?>/'+this.value;">
		<option selected>-- CHOOSE AN ARTICLE TYPE --</option>
		
		<?php foreach($type_article_all_with_count as $item): ?>
		<option value="<?=strtolower($item->id)?>"><?=$item->type?>[<?=$item->count?>篇]</option>
		<?php endforeach; ?>
	</select>
	
	
	<!-- 下面是文章列表 -->
	<!-- x的计算方法：(canceled)
		(x（本片文章字体大小浮点值）-size['min'])/(size['max']-size['min'])
	   =($item->count（本篇文章点击数）-$count_min_max['min']->count（文章点击数最小值）)/($count_min_max['max']->count - $count_min_max['min']->count)
	-->
	<ul>
	
	<?php //配置min、max字体大小等
	/* canceled
		$size['min'] = 12;//最小12px
		$size['max'] = 18;//最大18px
		$view['max'] = $count_min_max['max']->count;
		$view['min'] = ($count_min_max['min']->count == $count_min_max['max']->count) ? ($count_min_max['min']->count - 1):$count_min_max['min']->count;
	*/
	?>
	<?php if ($this->uri->segment(4) > 0):?>
		<?php foreach ($list as $item):?>
			<?php
			/* canceled
			$count = empty($item->count)?'0':$item->count;//文章点击数
			$font_size = (($count - $view['min'])/($view['max'] - $view['min'])) * ($size['max']-$size['min']) + $size['min'];
			$font_size = floor($font_size);
			*/
			?>
			<li>
				<a href="<?=site_url('cult/show')?>/<?php echo $this->uri->segment(3,0);?>/<?php echo $this->uri->segment(4,0);?>/<?=$item->article_id?>"><?=$item->article_title?></a>
				[<?php echo empty($item->count)?'0':$item->count;?>]
			</li>
		<?php endforeach;?>
	<?php endif;?>
	</ul>
</div>















