<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="<?=base_url('css/bbs.css');?>" type="text/css" />
<script type="text/javascript" src="<?=base_url('js/bbs.js');?>"></script>
<title>掲示板</title>
</head>

<body onload="MM_preloadImages('<?=base_url('images/icons/bbs_new_on.jpg');?>')">
<!-- header -->
<?php $this->load->view('bbs_header'); ?>

<!-- main -->
<div id="main">
<div class="title_banner">
<img src="<?=base_url('images/icons/bbs_titile.jpg');?>" alt="掲示板" width="580" height="70" />
</div>

<div class="bbs_new_post_button">
<a href="<?=$this->config->site_url();?>bbs/post">
<img src="<?=base_url('images/icons/bbs_new_off.jpg');?>" alt="新規投稿" name="toukou" width="150" height="50" border="0" id="toukou" onmouseover="MM_swapImage('toukou','','<?=base_url('images/icons/bbs_new_on.jpg');?>',1)" onmouseout="MM_swapImgRestore()" />
</a>
</div>

<!-- ページネーションを表示します。 -->
<?=$pagination?>

<!-- ここから、php endforeachまで、記事を表示するループです。 -->
<?php foreach($query->result() as $row): ?>
<div class="article">
<h1 class="f_bbs_titile"><a id="id<?=html_escape($row->id);?>" name="id<?=html_escape($row->id);?>">[<?=html_escape($row->id);?>]</a>
<?=html_escape($row->subject);?></h1>
<div class="f_bbs_coment"><?=html_escape($row->name);?>&nbsp;
<?=html_escape($row->datetime);?>&nbsp;</div>
<div class="f_bbs_coment"><?=nl2br(html_escape($row->body));?></div>
<!-- 記事を削除するためのフォームを表示します。 -->
<div class="f_bbs_delete">
<?=form_open('bbs/delete/'. $row->id);?>
削除パスワード: <input type="text" name="password" size="12" value="" />
<input type="submit" value="削除" />
<?=form_close();?>
</div><!-- end of f_bbs_delete -->
</div><!-- end of article -->
<?php endforeach; ?>

<?=$pagination?>

</div>

<!-- footer -->
<?php $this->load->view('ci_footer'); ?>
</body>
</html>
