<div id="login_form">

	<h1>Login Here</h1>
	
	<p><!-- 如果有传过来变量的值xxx，就打印登录失败信息 --></p>
    <?php 
	echo form_open('member/validate_credentials') . "\n";
	echo form_input('username', '') . "\n";
	echo form_password('password', '') . "\n";
	echo form_submit('submit', 'Login') . "\n";
	echo anchor('member/signup', 'Create Account') . "\n";
	echo form_close();
	?>

</div><!-- end login_form-->
