<?php echo validation_errors(); ?>
<?php $attributes = array('class' => 'article', 'id' => 'article');?>
<?php echo form_open('manage/article/edit_one_article', $attributes); ?>

<input type="hidden" name="id" value="<?php if (isset($article->id)) echo $article->id;?>">

<h3>article_title</h3>
<input type="text" name="article_title" value="<?php if (isset($article->article_title)) echo $article->article_title;?>" size="50" />

<h3>testimony_people</h3>
<input type="text" name="testimony_people" value="<?php if (isset($article->testimony_people))echo $article->testimony_people;?>" size="50" />

<h3>testimony_date</h3>
<input type="text" name="testimony_date" value="<?php if (isset($article->testimony_date)) echo $article->testimony_date;?>" size="50" />

<h3>origin_address</h3>
<input type="text" name="origin_address" value="<?php if (isset($article->origin_address)) echo $article->origin_address;?>" size="100" />

<h3>translation_status</h3>
<select name="translation_status">
	<option value="1">Yes</option>
	<option value="0">No</option>
</select> 

<h3>type_article</h3>
<select name="type_article">
	<?php foreach($type_article as $item): ?>
	<option value="<?=$item->id?>"><?=$item->type?></option>	
	<?php endforeach; ?>
</select> 

<h3>type_cult</h3>
<select name="type_cult">
	<?php foreach($type_cult as $item): ?>
	<option value="<?=$item->id?>"><?=$item->name?></option>	
	<?php endforeach; ?>
</select> 

<!-- 仅加载中文表单、英文的WYSIWYG文本域 -->
<?php $this->load->view('manage/v_edit_one_article_form')?>

<div><input type="submit" value="Submit" /></div>

</form>