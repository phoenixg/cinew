<?php
echo $error . "\n";
$attributes = array('class' => 'form_article_upload', 'id' => 'form_article_upload');
echo form_open_multipart('article/do_upload',$attributes) . "\n";
echo form_upload('uploadArticle') . "\n";
echo form_submit('submit', '提交一篇文章') . "\n";
echo form_close() . "\n";
?>

