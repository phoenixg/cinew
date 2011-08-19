<?php echo validation_errors(); ?>

<?php echo form_open('manage/article/delete_one_article'); ?>

<input type="hidden" name="id" value="<?php if (isset($article_id)) echo $article_id;?>">

<h3>Are you sure to delete this article:<?php if(isset($article_title)) echo $article_title;?>?</h3>

<div><input type="submit" value="Submit" /></div>

</form>