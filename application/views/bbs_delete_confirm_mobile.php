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
<td bgcolor="#EEEEEe">以下の記事を削除しますか？</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td bgcolor="#EEEEEE"><a name="<?=html_escape($id);?>">[<?=html_escape($id);?>]</a> <?=html_escape($subject);?></td>
</tr>
<tr>
<td><?=html_escape($name);?>&nbsp;<?=html_escape($datetime);?>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#EEEEEE"><?=nl2br(html_escape($body));?></td>
</tr>
<tr>
<td>
<?=form_open('bbs');?>
<input type="submit" value="いいえ" />
<?=form_close();?>

<?=form_open('bbs/delete/'. $id);?>
<?=form_hidden('delete', '1');?>
<?=form_hidden('password', $password);?>
<input type="submit" value="はい" />
<?=form_close();?>
</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
</table>

<hr>
<?=anchor('bbs', 'ﾄｯﾌﾟに戻る');?>

</body>
</html>
