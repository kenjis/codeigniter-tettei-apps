<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="<?=base_url('css/bbs.css');?>" type="text/css" />
<title>掲示板: 削除の確認</title>
</head>

<body>
<!-- header -->
<?php $this->load->view('bbs_header'); ?>

<!-- main -->
<div id="main">
<div class="title_banner">
<img src="<?=base_url('images/icons/bbs_titile.jpg');?>" alt="掲示板" width="580" height="70" />
</div>
<p class="center">削除の確認</p>
<div class="outer_frame">
<p>
以下の記事を削除しますか？
</p>
<div class="confirm_delete">
<h2><a name="<?=html_escape($id);?>">[<?=html_escape($id);?>]</a> <?=html_escape($subject);?></h2>
<div><?=html_escape($name);?>&nbsp;
<?=html_escape($datetime);?>&nbsp;
</div>
<div><?=nl2br(html_escape($body));?></div>
</div>

<?=form_open('bbs');?>
<input type="submit" value="いいえ" />
<?=form_close();?>

<?=form_open('bbs/delete/'. $id);?>
<?=form_hidden('delete', '1');?>
<?=form_hidden('password', $password);?>
<input type="submit" value="はい" />
<?=form_close();?>

<p>
<span class="button">
<?=anchor('bbs', 'トップに戻る');?>
</span>
</p>
</div>
</div>

<!-- footer -->
<?php $this->load->view('ci_footer'); ?>
</body>
</html>
