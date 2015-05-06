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
<td bgcolor="#EEEEEE">新規投稿</td>
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

<?=form_open('bbs/confirm');?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td bgcolor="#EEEEEe">名前<br><input type="text" name="name" value="<?=$name?>"></td>
</tr>
<tr>
<td>ﾒｰﾙｱﾄﾞﾚｽ<br><input type="text" name="email" value="<?=$email?>"></td>
</tr>
<tr>
<td bgcolor="#EEEEEE">件名<br><input type="text" name="subject" value="<?=$subject?>"></td>
</tr>
<tr>
<td>内容<br><textarea name="body" rows="3"><?=$body?></textarea></td>
</tr>
<tr>
<td bgcolor="#EEEEEE">削除ﾊﾟｽﾜｰﾄﾞ<br><input type="text" name="password" value="<?=$password?>"></td>
</tr>
<tr>
<td>画像認証ｺｰﾄﾞ<br><?=$image?>
<br>
<input type="text" name="captcha" value="" />
<?=form_hidden('key', $key);?>
<br>
<input type="submit" value="確認画面に進む"></td>
</tr>
</table>
<?=form_close();?>

<hr>
<?=anchor('bbs', 'ﾄｯﾌﾟに戻る');?>

</body>
</html>
