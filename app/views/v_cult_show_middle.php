<div id="cult_show_middle">
	<!-- 文章区域 -->
	<div id="cult_show_middle_article">
		<div>
			<?php if ($this->uri->segment(6) == 'en'):?>
				<a href="<?=site_url()?>/cult/show/<?=$this->uri->segment(3)?>/<?=$this->uri->segment(4)?>/<?=$this->uri->segment(5)?>">view chinese version</a>
			<?php else:?>
				<a href="<?=site_url()?>/cult/show/<?=$this->uri->segment(3)?>/<?=$this->uri->segment(4)?>/<?=$this->uri->segment(5)?>/en">view english version</a>
			<?php endif;?>
		</div>
	
		<h3>title:<?=$current_article->article_title?></h3>
		
		<ul>
			<li>testimony people:<?=$current_article->testimony_people?></li>
			<li>testimony date:<?=$current_article->testimony_date?></li>
			<li>origin_address:<?=anchor($current_article->origin_address,$current_article->origin_address)?></li>
		</ul>
		
		<div>
			<?php if ($this->uri->segment(6) == 'en'): ?>
				<?=$current_article->article_en?>
			<?php else: ?>
				<?=$current_article->article_zh?>
			<?php endif; ?>
		</div>
	</div>
	

	<!-- 文章评论区域 -->
	<div id="cult_show_middle_comment">
		<!-- 文章评论列表 -->
		<h3>评论：</h3>
		<?php if ($comment_exist == TRUE):?>
			<table>
				<?php foreach ($authorized_comment as $k => $comment):?>
					<tr>
						<td><a href="maito:<?=$comment->email_address?>"><?=$comment->comment_nickname?></a></td>
						<td><?=unix_to_human(mysql_to_unix($comment->comment_time));?></td>
					</tr>
					<tr>
						<td><?=$comment->comment?></td>
					</tr>
				<?php endforeach;?>
			</table>
		<?php else:?>
			<p>当前文章暂无评论</p>
		<?php endif;?>

		
		<!-- 文章评论表单 -->	
		<h3>您可以在这里评论：</h3>
		<p>评论说明。。。。。。。。。。。。。。。。。。。。。。。。。。。。。</p>
		<?php
		//评论的表单
		echo validation_errors('<p class="error">');
		if (isset($inserted) && ($inserted==TRUE)) echo '<p>感谢您的评论，请等待审核</p>';
		if (isset($cap_right) && ($cap_right == FALSE)) echo '<p>验证码的填写不正确</p>';
		$attributes = array('class' => 'article_comment', 'id' => 'article_comment');
		echo form_open($this->uri->uri_string(),$attributes) . "\n"; //让当前控制器处理提交的表单信息
		
		//隐藏域：article_id,client_ip,验证码数字
		echo form_hidden('article_id', $current_article->article_id)."\n";
		echo form_hidden('client_ip', getIP())."\n";
		echo form_hidden('captcha_word', $captcha['word'])."\n";
		
		//文本框：comment_nickname
		echo '<lable>comment_nickname:</label>'."\n";
		echo form_input(
						array(
				              'name'        => 'comment_nickname',
				              'id'          => 'comment_nickname',
				              'value'       => '',
				              'maxlength'   => '50',
				              'size'        => '50',
				              'style'       => 'width:20%',
				            )
						) . "\n";
						
		echo '<br />';
						
		//文本框：email_address
		echo '<lable>email_address:</label>'."\n";
		echo form_input(
						array(
				              'name'        => 'email_address',
				              'id'          => 'email_address',
				              'value'       => '',
				              'maxlength'   => '100',
				              'size'        => '50',
				              'style'       => 'width:20%',
							)
						) . "\n";							
		
		echo '<br />';
						
		//文本域：comment
		echo '<lable>comment:</label>'."\n";
		echo form_textarea(
						array(
				              'name'        => 'comment',
				              'id'          => 'comment',
				              'value'       => '',
				              'rows'  		=> '5',
				              'cols'        => '10',
				              'style'       => 'width:40%',
							)
						) . "\n";
		
		echo '<br />';
						
		//验证码
		echo '<lable>验证码:</label>'."\n";
		echo form_input(
						array(
				              'name'        => 'captcha',
				              'id'          => 'captcha',
				              'value'       => '',
				              'maxlength'   => '10',
				              'size'        => '10',
				              'style'       => 'width:6%',
							)
						) . "\n";	
		echo $captcha['image'];
		
		echo '<br />';
		
		//提交按钮、关闭表单
		echo form_submit('submit', '提交评论') . "\n";
		echo form_close() . "\n";


		?>		
		
		
		
		

	
	</div>
	
</div>























