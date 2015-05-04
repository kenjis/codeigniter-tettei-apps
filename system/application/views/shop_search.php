<div class="shop_title">「<?=form_prep($q);?>」の検索結果</div>

<?=$pagination?>

<p class="coment"><?=$total_item?></p>

<?php foreach($list as $row): ?>
<a href="<?=base_url();?>shop/product/<?=$row->id?>">
<?php if ($row->img): ?>
<img class="img" src="<?=base_url();?>images/<?=$row->img?>" alt="" />
<?php else: ?>
<img class="img" src="<?=base_url();?>images/now_printing.jpg" alt="" />
<?php endif; ?>
</a>
<p class="shop_list">
<?=anchor('shop/product/' . $row->id, $row->name);?> <br />
価格: <?=number_format($row->price);?>円<br />
</p>
<hr />
<?php endforeach; ?>

<?=$pagination?>
