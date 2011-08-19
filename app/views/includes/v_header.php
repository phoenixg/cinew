<?php echo doctype('xhtml1-trans')."\n";?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title></title>
	<?php echo link_tag('public/css/global.css');?>
	<?php if (($this->uri->segment(1)=='article')&&($this->uri->segment(2)=='translate')):?>
		<script src="http://dict.cn/hc/" type="text/javascript"></script>
	<?php endif;?>
</head>


<body>
<div id="wrapper"><!-- full display region -->
	<div id="header">
		<h1><?=CULT_SITE_NAME?></h1>
		
		<small>
		<?php if (isset($login)):?>	
			<?php if ($login==TRUE):?>
				<?=anchor('member/logout','注销')?>&nbsp;[Welcome&nbsp;<?=$this->session->userdata['username']?>!]
			<?php else:?>
				<?=anchor('member/login','登陆')?>
			<?php endif;?>
		<?php else:?>
			<?php //nothing here?>
		<?php endif;?>
		</small>
		<hr>
	</div><!-- end of #header -->
	
	<div id="container">




