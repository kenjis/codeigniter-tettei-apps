<div class="shop_title">「<?php echo $q == '' ? '全商品' : html_escape($q); ?>」の検索結果</div>

<?=$pagination?>

<p class="coment">
<?php if ($total): ?>
<?=html_escape($total);?>点の商品がヒットしました。
<?php else: ?>
"<?=html_escape($q);?>"の検索に一致する商品はありませんでした。
<?php endif; ?>
</p>

<?php foreach($list as $row): ?>
<a href="<?=base_url('shop/product/'.$row->id);?>">
<?php if ($row->img): ?>
<img class="img" src="<?=base_url('images/'.$row->img);?>" alt="" />
<?php else: ?>
<img class="img" src="<?=base_url('images/now_printing.jpg');?>" alt="" />
<?php endif; ?>
</a>
<p class="shop_list">
<?=anchor('shop/product/' . html_escape($row->id), html_escape($row->name));?> <br />
価格: <?=number_format($row->price);?>円<br />
</p>
<hr />
<?php endforeach; ?>

<?=$pagination?>
