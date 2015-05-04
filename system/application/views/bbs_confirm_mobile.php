<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=shift_jis">
<title>ﾓﾊﾞｲﾙ掲示板</title>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td bgcolor="#9999FF">ﾓﾊﾞｲﾙ掲示板</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#EEEEEE">内容の確認</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#FFCCFF"><?=$this->validation->error_string?></td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td bgcolor="#EEEEEE">名前<br><?=form_prep($name);?></td>
</tr>
<tr>
<td>ﾒｰﾙｱﾄﾞﾚｽ<br><?php if ($email == '') { echo '(なし)'; } else { echo form_prep($email); } ?></td>
</tr>
<tr>
<td bgcolor="#EEEEEE">件名<br><?=form_prep($subject);?></td>
</tr>
<tr>
<td>内容<br><?=nl2br(form_prep($body));?></td>
</tr>
<tr>
<td bgcolor="#EEEEEE">削除ﾊﾟｽﾜｰﾄﾞ<br><?php if ($password == '') { echo '(なし)'; } else { echo form_prep($password); } ?></td>
</tr>
<tr>
<td>
<?=form_open('bbs/post');?>
<?=form_hidden('name',     $name);?>
<?=form_hidden('email',    $email);?>
<?=form_hidden('subject',  $subject);?>
<?=form_hidden('body',     $body);?>
<?=form_hidden('password', $password);?>
<input type="submit" value="修正する" />
<?=form_close();?>
<br>
<?=form_open('bbs/insert');?>
<?=form_hidden('name',     $name);?>
<?=form_hidden('email',    $email);?>
<?=form_hidden('subject',  $subject);?>
<?=form_hidden('body',     $body);?>
<?=form_hidden('password', $password);?>
<?=form_hidden('key',      $key);?>
<?=form_hidden('captcha',  $captcha);?>
<input type="submit" value="送信する" />
<?=form_close();?>
</td>
</tr>
</table>

<hr>
<?=anchor('bbs', 'ﾄｯﾌﾟに戻る');?>

</body>
</html>
