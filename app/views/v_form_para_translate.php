<?php
echo validation_errors('<p class="error">');
$attributes = array('class' => 'form_para_translate', 'id' => 'form_para_translate');
echo form_open('article/add_translation',$attributes) . "\n";

$data = array(
              'name'        => 'para_translate',
              'id'          => 'para_translate',
              'value'       => '',
              'rows'   		=> '10',
              'cols'        => '100',
              'style'       => 'width:100%',
            );
echo form_textarea($data) . "\n";
echo '<br />';
echo form_submit('submit', '提交译文') . "\n";
echo form_hidden('article_id', $random_article_id);
echo form_hidden('para_id', $random_para_id); 
if (isset($current_userid)) echo form_hidden('current_userid', $current_userid); 
echo form_close() . "\n";
?>
