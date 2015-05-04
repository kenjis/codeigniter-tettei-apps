<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="<?=base_url();?>css/form.css" type="text/css" />
<title>コンタクトフォーム(確認)</title>
</head>

<body>
<!-- header -->
<?=$this->load->view('form_header');?>

<!-- main -->
<div id="main">
<div class="title_banner">
<img src="<?=base_url();?>images/icons/form_titile.jpg" alt="お問い合わせ" width="580" height="70" />
</div>

<div class="outer_frame">
<p class="center">お問い合わせ内容の確認</p>
<table>
<tr><th>名前</th>
<!-- 検証をパスした後の「$this->validation->フィールド名」の値は、文字参照
に置換されませんので、表示する場合は、Formヘルパーのform_prep()メソッドなどを
通し、必ず、特殊文字を文字参照に置換します。 -->
	<td><?=form_prep($this->validation->name);?></td>
</tr>
<tr><th>メールアドレス</th>
	<td><?=form_prep($this->validation->email);?></td>
</tr>
<tr><th>コメント</th>
	<td><pre><?=form_prep($this->validation->comment);?></pre></td>
</tr>
<tr><td></td>
	<td class="center">
<!-- 入力を修正するための、隠しフィールドに入力値を仕込んだ
フォームを表示します。Formヘルパーで$this->validation->nameなどの
値を表示する場合は、自動的に文字参照に置換されるため、form_prep()メソッドなど
を通す必要はありません。 -->
	<?=form_open('form');?>
	<?=form_hidden('name',    $this->validation->name);?>
	<?=form_hidden('email',   $this->validation->email);?>
	<?=form_hidden('comment', $this->validation->comment);?>
	<input class="button" type="submit" value="修正" />
	<?=form_close();?>
<!-- 入力がOKの場合に、次の完了ページへ進むためのフォームを表示します。
ここでも、同様に、隠しフィールドに入力値を仕込み、次のページに渡します。
ワンタイムチケットを忘れないようにしましょう。 -->
	<?=form_open('form/send');?>
	<?=form_hidden('ticket',  $this->ticket);?>
	<?=form_hidden('name',    $this->validation->name);?>
	<?=form_hidden('email',   $this->validation->email);?>
	<?=form_hidden('comment', $this->validation->comment);?>
	<input class="button" type="submit" value="送信" />
	<?=form_close();?>
	</td>
</tr>
</table>
</div>
</div>

<!-- footer -->
<?=$this->load->view('ci_footer');?>
</body>
</html>
