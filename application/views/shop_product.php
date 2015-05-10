<div class="shop_title">商品の詳細</div>
<div class="title_name"><?=html_escape($item->name);?></div>
<!-- 商品画像ファイル名が登録されている場合は、その画像へのリンクを表示
します。 -->
<?php if ($item->img): ?>
<img class="img" src="<?=base_url('images/'.$item->img);?>" alt="" />
<!-- 商品画像ファイル名が登録されていない場合は、Now Printing画像への
リンクを表示します。 -->
<?php else: ?>
<img class="img" src="<?=base_url('images/now_printing.jpg');?>" alt="" />
<?php endif; ?>
<p class="shop_list">
価格: <?=number_format($item->price);?>円<br />
</p>
<div class="center">
<?=form_open('shop/add/'. $item->id);?>
数量: <input type="text" name="qty" size="2" value="1" />
<input type="submit" value="カゴに入れる" />
<?=form_close();?>
<br /><br />
</div>
<p class="coment">
<?=html_escape($item->detail);;?>
</p>
<hr />
