<div class="shop_title">お客様情報の入力</div>

<div class="outer_frame">
<?=form_open('shop/confirm');?>

<table>
<tbody>
<tr><td>お名前</td>
<td>
<input type="text" name="name" value="<?=$this->validation->name;?>" size="50" />
<?=$this->validation->name_error;?>
</td>
</tr>
<tr><td>郵便番号</td>
<td>
<input type="text" name="zip" value="<?=$this->validation->zip;?>" size="8" />
<?=$this->validation->zip_error;?>
</td>
</tr>
<tr><td>住所</td>
<td>
<input type="text" name="addr" value="<?=$this->validation->addr;?>" size="50" />
<?=$this->validation->addr_error;?>
</td>
</tr>
<tr><td>電話番号</td>
<td>
<input type="text" name="tel" value="<?=$this->validation->tel;?>" size="20" />
<?=$this->validation->tel_error;?>
</td>
</tr>
<tr><td>メールアドレス</td>
<td>
<input type="text" name="email" value="<?=$this->validation->email;?>" size="50" />
<?=$this->validation->email_error;?>
</td>
</tr>
<tr><td></td>
<td>
<input type="submit" value="確認" />
</td>
</tr>
</tbody>
</table>

<?=form_close();?>
</div>
