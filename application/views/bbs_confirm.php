<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="<?=base_url('css/bbs.css');?>" type="text/css" />
<title>掲示板: 投稿確認</title>
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
<img src="<?=base_url('images/icons/bbs_new.jpg');?>" alt="新規投稿" name="toukou" width="150" height="50" border="0" id="toukou" onmouseover="MM_swapImage('toukou','','<?=base_url('images/icons/bbs_new_on.jpg');?>',1)" onmouseout="MM_swapImgRestore()" />
</div>

<p class="center">投稿確認</p>

<div class="outer_frame">
<?=validation_errors();?>

<div class="confirm">

<div class="field">名前: </div>
<?=html_escape($name);?>

<div class="field">メールアドレス: </div>
<?php if ($email == '') { echo '(なし)'; } else { echo html_escape($email); } ?>

<div class="field">件名: </div>
<?=html_escape($subject);?>

<div class="field">内容: </div>
<?=nl2br(html_escape($body));?>

<div class="field">削除パスワード: </div>
<?php if ($password == '') { echo '(なし)'; } else { echo html_escape($password); } ?>
</div>

<?=form_open('bbs/post');?>
<?=form_hidden('name',     $name);?>
<?=form_hidden('email',    $email);?>
<?=form_hidden('subject',  $subject);?>
<?=form_hidden('body',     $body);?>
<?=form_hidden('password', $password);?>
<input type="submit" value="修正" />
<?=form_close();?>

<?=form_open('bbs/insert');?>
<?=form_hidden('name',     $name);?>
<?=form_hidden('email',    $email);?>
<?=form_hidden('subject',  $subject);?>
<?=form_hidden('body',     $body);?>
<?=form_hidden('password', $password);?>
<?=form_hidden('key',      $key);?>
<?=form_hidden('captcha',  $captcha);?>
<input type="submit" value="送信" />
<?=form_close();?>

</div>
</div>

<?php $this->load->view('ci_footer'); ?>
</body>
</html>
