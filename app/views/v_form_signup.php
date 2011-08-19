<h1>Create an Account!</h1>
<fieldset>
<legend>个人信息</legend>
<?php
$attributes = array('class' => 'form_create_member', 'id' => 'form_create_member');
echo form_open('member/create_member',$attributes) . "\n";

$data = array(
              'name'        => 'username',
              'id'          => 'username',
              'value'       => '',
              'maxlength'   => '50',
              'size'        => '50',
              'style'       => 'width:50%',
            );

echo form_input($data) . "\n";
echo form_password('password1', '') . "\n";
echo form_password('password2', '') . "\n";

echo form_submit('submit', '创建用户') . "\n";
echo form_close() . "\n";
if(isset($error_registered_info)) echo $error_registered_info;
echo validation_errors('<p class="error">');
?>

</fieldset>

