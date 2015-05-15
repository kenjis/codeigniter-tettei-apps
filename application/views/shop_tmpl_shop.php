<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="<?=base_url('css/shop.css');?>" type="text/css" />
<title>CIショップ</title>

<!-- codeigniter-debugbar表示用 -->
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.5/highlight.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.5/styles/github.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css">

</head>

<body>
<!-- ヘッダ -->
<?php $this->load->view('shop_ci_header'); ?>

<div id="main">
<!-- ショップヘッダ -->
	<div class="header"><?=$header?></div>
<!-- ショップメニュー -->
	<div class="menu"><?=$menu?></div>
<!-- ショップメイン -->
	<div class="main_shop"><?=$main?></div>
</div>

<!-- フッタ -->
<?php $this->load->view('ci_footer'); ?>
</body>
</html>
