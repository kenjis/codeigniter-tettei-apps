<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- URLヘルパーのbase_url()メソッドは、メイン設定ファイルで設定した
base_urlを返します。 -->
<link rel="stylesheet" href="<?=base_url('css/form.css');?>" type="text/css" />
<title>コンタクトフォーム</title>
</head>

<body>
<!-- ビューファイルform_header.phpを読み込んで、ヘッダ部分を表示します。 -->
<?php $this->load->view('form_header'); ?>

<!-- メイン部分です。 -->
<div id="main">
<div class="title_banner">
<img src="<?=base_url('images/icons/form_titile.jpg');?>" alt="お問い合わせ" width="580" height="70" />
</div>

<div class="outer_frame">
<!-- Formヘルパーのform_open()メソッドで<form>タグを生成します。 -->
<?=form_open('form/confirm');?>
<table>
<tr><th>名前</th>
<td>
<!-- Formヘルパーのset_value('name')は、POSTパラメータのnameフィールド
の入力値を返します。
入力フォームを最初に表示するのに、なぜこの値が必要なのかと疑問に思うかも
知れませんが、これは、検証でエラーの場合、この同じビューファイルを使って
フォームを表示するためです。このようにビューを使えば、最初のフォームの表示
とエラー時のフォームの再表示を、ひとつのビューで済ますことができます。 -->
	<input type="text" name="name" value="<?=set_value('name');?>" size="30" />
<!-- form_error('name')は、nameフィールドの検証で
エラーがあった場合に、表示するエラーメッセージを返します。 -->
	<?=form_error('name');?>
</td></tr>
<tr><th>メールアドレス</th>
<td>
	<input type="text" name="email" value="<?=set_value('email');?>" size="30" />
	<?=form_error('email');?>
</td></tr>
<tr><th>コメント</th>
<td>
	<textarea name="comment" rows="4" cols="30"><?=set_value('comment');?></textarea>
	<?=form_error('comment');?>
</td></tr>
<tr><td></td>
<td class="center">
	<input class="button" type="submit" value="確認" />
</td></tr>
</table>
<!-- Formヘルパーのform_close()メソッドで</form>タグを生成します。
form_open()メソッドを使った場合は、このメソッドを使うことでHTML文法
チェッカのエラーを回避できます。 -->
<?=form_close();?>
</div>
</div>

<!-- ビューファイルci_footer.phpを読み込んで、フッタ部分を表示します。 -->
<?php $this->load->view('ci_footer'); ?>
</body>
</html>
