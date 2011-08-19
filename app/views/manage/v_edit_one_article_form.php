<!-- 使用方法：请在视图里加载本视图 -->

<!-- xheditor start-->
<script type="text/javascript" src="<?=base_url()?>public/xheditor-1.1.8/jquery/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>public/xheditor-1.1.8/xheditor-1.1.8-zh-cn.min.js"></script>


<script type="text/javascript">
	$(pageInit);
	
	function pageInit()	{
		$('#article_zh').xheditor({ skin:'nostyle',
									shortcuts:{'ctrl+enter':submitForm},
									tools:'Source,Removeformat,|,Cut,Copy,Pastetext,|,Blocktag,Fontface,FontSize,|,Bold,Italic,Underline,Strikethrough,|,FontColor,BackColor,|,Align,List,|,Outdent,Indent,|Anchor,|,Link,Unlink,|,Img,Table,Hr,|,Preview,Fullscreen,About'});
		$('#article_en').xheditor({ skin:'nostyle',
									shortcuts:{'ctrl+enter':submitForm},
									tools:'Source,Removeformat,|,Cut,Copy,Pastetext,|,Blocktag,Fontface,FontSize,|,Bold,Italic,Underline,Strikethrough,|,FontColor,BackColor,|,Align,List,|,Outdent,Indent,|Anchor,|,Link,Unlink,|,Img,Table,Hr,|,Preview,Fullscreen,About'});
	}
	
	function submitForm(){
		$('#article').submit();
	}
</script>
<!-- xheditor end -->

<h3>article_zh</h3>
<textarea name="article_zh" id="article_zh" style="width:100%;" cols="100" rows="15">
	<?php if (isset($article->article_zh)) echo $article->article_zh;?>
</textarea>

<h3>article_en</h3>
<textarea name="article_en" id="article_en" style="width:100%;" cols="100" rows="15">
	<?php if (isset($article->article_en)) echo $article->article_en;?>
</textarea>
