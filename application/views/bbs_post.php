<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="<?=base_url('css/bbs.css');?>" type="text/css" />
<script type="text/javascript" src="<?=base_url('js/bbs.js');?>"></script>
<title>掲示板: 新規投稿</title>
</head>

<body>
<!-- header -->
<?php $this->load->view('bbs_header'); ?>

<!-- main -->
<div id="main">
<div class="title_banner">
<img src="<?=base_url('images/icons/bbs_titile.jpg');?>" alt="掲示板" width="580" height="70" />
</div>
<div class="bbs_new_post_icon">
<img src="<?=base_url('images/icons/bbs_new.jpg');?>" alt="新規投稿" name="toukou" width="150" height="50" border="0" id="toukou" />
</div>
<div class="outer_frame">
<?=validation_errors();?>
<?=form_open('bbs/confirm');?>
<p>
<label for="name">名前: </label>
<input type="text" name="name" size="50" value="<?=html_escape($name);?>"/>
<br />
<label for="email">メールアドレス: </label>
<input type="text" name="email" size="50" value="<?=html_escape($email);?>"/>
<br />
<label for="subject">件名: </label>
<input type="text" name="subject" size="50" value="<?=html_escape($subject);?>"/>
<br />
<label for="body">内容: </label>
<textarea name="body" rows="10" cols="50"><?=html_escape($body);?></textarea>
<br />
<label for="password">削除パスワード: </label>
<input type="text" name="password" size="20" value="<?=html_escape($password);?>"/>
<br />
<label for="captcha">画像認証コード: </label>
<input type="text" name="captcha" value="" />
<?=$image?> 
<?=form_hidden('key', $key);?>
<input type="submit" value="送信" />
</p>
<?=form_close();?>
</div>
</div>

<!-- footer -->
<?php $this->load->view('ci_footer'); ?>
</body>
</html>
