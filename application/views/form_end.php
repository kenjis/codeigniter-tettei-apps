<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="<?=base_url('css/form.css');?>" type="text/css" />
<title>コンタクトフォーム(送信完了)</title>
</head>

<body>
<!-- header -->
<?php $this->load->view('form_header'); ?>

<!-- main -->
<div id="main">
<div class="title_banner">
<img src="<?=base_url('images/icons/form_titile.jpg');?>" alt="お問い合わせ" width="580" height="70" />
</div>

<div class="outer_frame">
<p class="center">送信しました</p>
<p>お問い合わせ、ありがとうございます。</p>
</div>
</div>

<!-- footer -->
<?php $this->load->view('ci_footer'); ?>
</body>
</html>
