<div id="login_form">

	<h2>Login Here</h2>
	
    <?php 
	echo form_open('manage/login/validate_credentials') . "\n";
	echo form_input('username', '') . "\n";
	echo form_password('password', '') . "\n";
	echo form_submit('submit', 'Admin Login') . "\n";
	echo form_close();
	?>

</div><!-- end login_form-->
