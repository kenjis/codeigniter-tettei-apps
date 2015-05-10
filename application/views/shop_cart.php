<div class="shop_title">買い物かご</div>

<?php if ($item_count > 0): ?>
<div align="center">
<table width="95%" border="0" cellspacing="0">
<tbody>

<tr>
<th bgcolor="#E8DF8E" class="line_2">&nbsp;</th>
<th bgcolor="#E8DF8E" class="line_1">商品名</th>
<th bgcolor="#E8DF8E" class="line_1">数量</th>
<th bgcolor="#E8DF8E" class="line_1">単価</th>
<th bgcolor="#E8DF8E" class="line_1">金額</th>
<th bgcolor="#FFFFFF"></th>
</tr>

<?php foreach($cart as $line => $item): ?>
<tr>
<td width="30" align="center" bgcolor="#E1E1E1" class="line_2"><?=html_escape($line);?></td>
<td bgcolor="#FFFFFF" class="line_1"><?=html_escape($item['name']);?></td>
<td align="center" bgcolor="#FFFFCC" class="line_1">
<?=form_open('shop/add/' . $item['id']);?>
<input type="text" name="qty" size="2" value="<?=html_escape($item['qty']);?>" />
<input type="submit" value="変更" />
<?=form_close();?>
</td>
<td align="right" bgcolor="#FFFFFF" class="line_1"><?=number_format($item['price']);?>円</td>
<td align="right" bgcolor="#FFFFFF" class="line_1"><?=number_format($item['amount']);?>円</td>
<td align="center" bgcolor="#ECE1BF" class="line_1">
<?=form_open('shop/add/' . $item['id']);?>
<input type="hidden" name="qty" value="0" />
<input type="submit" value="削除" />
<?=form_close();?>
</td>
</tr>
<?php endforeach; ?>

<tr>
<td colspan="3" class="line_2"></td>
<td align="center" bgcolor="#FFCC00" class="line_2">合計</td>
<td align="right" bgcolor="#FFFFFF" class="line_2"><?=number_format($total);?>円</td>
<td align="center" bgcolor="#333333" class="line_1">
<?=form_open('shop/customer_info');?>
<input type="submit" value="レジに進む" />
<?=form_close();?>
</td>
</tr>

</tbody>
</table>
</div>

<?php else: ?>
<p class="coment">買い物カゴには何も入っていません。</p>
<?php endif; ?>
