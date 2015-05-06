<div class="shop_navi">
<img src="<?=base_url();?>images/icons/shop_menu_top.jpg" />
<ul>
<?php foreach($list as $row): ?>
	<li class="shop_navi2">
	<img src="<?=base_url();?>images/icons/botan_1.gif" />
	<?=anchor('shop/index/' . $row->id, $row->name);?>
	</li>
<?php endforeach; ?>
</ul>
<img src="<?=base_url();?>images/icons/shop_menu_bottom.jpg" />
</div>
