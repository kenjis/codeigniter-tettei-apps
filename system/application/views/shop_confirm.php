<div class="shop_title">注文内容の確認</div>

<div class="outer_frame">
<table>
<tbody>
<tr><th>お名前</th>
<td>
<?=form_prep($this->validation->name);?>
</td>
</tr>
<tr><th>郵便番号</th>
<td>
<?=form_prep($this->validation->zip);?>
</td>
</tr>
<tr><th>住所</th>
<td>
<?=form_prep($this->validation->addr);?>
</td>
</tr>
<tr><th>電話番号</th>
<td>
<?=form_prep($this->validation->tel);?>
</td>
</tr>
<tr><th>メールアドレス</th>
<td>
<?=form_prep($this->validation->email);?>
</td>
</tr>
</tbody>
</table>
</div>

<div align="center">
<table width="95%" border="0" cellspacing="0">
<tbody>
<tr>
<th bgcolor="#E8DF8E" class="line_2">&nbsp;</th>
<th bgcolor="#E8DF8E" class="line_1">商品名</th>
<th bgcolor="#E8DF8E" class="line_1">数量</th>
<th bgcolor="#E8DF8E" class="line_1">単価</th>
<th bgcolor="#E8DF8E" class="line_1">金額</th>
<th bgcolor="#E8DF8E" class="line_1">&nbsp;</th>
</tr>

<?php foreach($cart as $line => $item): ?>
<tr>
<td width="30" align="center" bgcolor="#E1E1E1" class="line_2"><?=$line?></td>
<td bgcolor="#FFFFFF" class="line_1"><?=$item['name']?></td>
<td align="center" bgcolor="#FFFFCC" class="line_1"><?=$item['qty']?></td>
<td align="right" bgcolor="#FFFFFF" class="line_1"><?=number_format($item['price'])?>円</td>
<td align="right" bgcolor="#FFFFFF" class="line_1"><?=number_format($item['amount'])?>円</td>
<td align="right" bgcolor="#FFFFFF" class="line_1">&nbsp;</td>
</tr>
<?php endforeach; ?>

<tr>
<td class="line_2"></td>
<td align="center" bgcolor="#333333" class="line_2">
<?=form_open('shop/customer_info');?>
<input type="submit" value="お客様情報の入力へ戻る" />
<?=form_close();?>
</td>
<td></td>
<td align="center" bgcolor="#FFCC00" class="line_2">合計</td>
<td align="right" bgcolor="#FFFFFF" class="line_2"><?=number_format($total);?>円</td>
<td align="center" bgcolor="#333333" class="line_2">
<?=form_open('shop/order');?>
<!-- CSRF対策のワンタイムチケットです。 -->
<?=form_hidden('ticket', $this->ticket);?>
<input type="submit" value="注文を確定する" />
<?=form_close();?>
</td>
</tr>
</tbody>
</table>
</div>

<br />
