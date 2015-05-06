<div class="shop_title">「<?=$category?>」のリスト</div>

<!-- ページネーションを表示します。 -->
<?=$pagination?>

<!-- 商品点数を表示します。 -->
<p class="coment"><?=$total_item?></p>

<?php foreach($list as $row): ?>
<a href="<?=base_url();?>shop/product/<?=$row->id?>">
<!-- 商品画像ファイル名が登録されている場合は、その画像へのリンクを表示
します。 -->
<?php if ($row->img): ?>
<img class="img" src="<?=base_url();?>images/<?=$row->img?>" alt="" />
<!-- 商品画像ファイル名が登録されていない場合は、Now Printing画像への
リンクを表示します。 -->
<?php else: ?>
<img class="img" src="<?=base_url();?>images/now_printing.jpg" alt="" />
<?php endif; ?>
</a>
<p class="shop_list">
<!-- 個別商品ページへのリンクをURLヘルパーのanchor()メソッドを使い生成
します。リンク先は
「http://localhost/CodeIgniter/shop/product/商品ID」とします。-->
<?=anchor('shop/product/' . $row->id, $row->name);?> <br />
価格: <?=number_format($row->price);?>円<br />
</p>
<hr />
<?php endforeach; ?>

<?=$pagination?>
