<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CodeIgniterへようこそ！</title>
<link href="<?=base_url('css/top.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=base_url('js/bbs.js');?>"></script>
</head>

<body onload="MM_preloadImages('<?=base_url('images/icons/top_link_1on.jpg');?>','<?=base_url('images/icons/top_link_2on.jpg');?>','<?=base_url('images/icons/top_link_3on.jpg');?>')">
<div id="header">
	<div class="top_title"></div>
	<div class="navi">
		<ul class="sitenavi">
		<li class="menu_1"><img src="<?=base_url('images/icons/navi_icon-3.jpg');?>" alt="from" /></li>
		<li class="menu_2"><a href="<?=$this->config->site_url('form');?>">CIコンタクトフォーム</a></li>
		<li class="menu_1"><img src="<?=base_url('images/icons/navi_icon-2.jpg');?>" alt="bbs" /></li>
		<li class="menu_2"><a href="<?=$this->config->site_url('bbs');?>">CI掲示板</a></li>
		<li class="menu_1"><img src="<?=base_url('images/icons/navi_icon-1.jpg');?>" alt="shop" /></li>
		<li class="menu_2"><a href="<?=$this->config->site_url('shops');?>">CIショッピング</a></li>
		<li class="menu_1"><img src="<?=base_url('images/icons/navi_icon-4.jpg');?>" alt="home" /></li>
		<li class="menu_2"><a href="<?=$this->config->site_url();?>">ＨＯＭＥ</a></li>
		</ul>
	</div>	
	<div class="top_kage"></div>
</div>

<div id="main">
	<div class="top_navi">
		<div class="top_sitenavi">
		<a href="<?=$this->config->site_url();?>form" target="_top">
		<img src="<?=base_url('images/icons/top_link_3off.jpg');?>" alt="CIコンタクトフォーム" name="navi3" width="220" height="220" border="0" id="navi3" onmouseover="MM_swapImage('navi3','','<?=base_url('images/icons/top_link_3on.jpg');?>',1)" onmouseout="MM_swapImgRestore()" /></a>
		</div>
		<div class="top_sitenavi">
		<a href="<?=$this->config->site_url();?>bbs" target="_top">
		<img src="<?=base_url('images/icons/top_link_2off.jpg');?>" alt="CI掲示板" name="navi2" width="220" height="220" border="0" id="navi2" onmouseover="MM_swapImage('navi2','','<?=base_url('images/icons/top_link_2on.jpg');?>',1)" onmouseout="MM_swapImgRestore()" /></a>
		</div>
		<div class="top_sitenavi">
		<a href="<?=$this->config->site_url();?>shop" target="_top">
		<img src="<?=base_url('images/icons/top_link_1off.jpg');?>" alt="CIショッピング" name="navi1" width="220" height="220" border="0" id="navi1" onmouseover="MM_swapImage('navi1','','<?=base_url('images/icons/top_link_1on.jpg');?>',1)" onmouseout="MM_swapImgRestore()" /></a>
		</div>
	</div>
</div>

<!-- footer -->
<?php $this->load->view('ci_footer'); ?>
</body>
</html>
