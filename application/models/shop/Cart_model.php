<?php

class Cart_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('shop/Inventory_model');
	}

	// カゴに追加/削除
	public function add_to_cart($id, $qty)
	{
# 商品IDと数量を引数として渡され、数量が0以下の場合は、セッションクラスの
# unset_userdata()メソッドで、セッションデータからその商品を削除します。
		if ($qty <= 0) {
			$this->session->unset_userdata('item' . $id);
		}
# 指定の数量が1以上の場合は、その商品が存在するかチェックした後に、商品と数量を
# セッションデータに追加します。セッションの項目名は「item+商品ID」とします。
		else if ($this->Inventory_model->is_available_product_item($id))
		{
			$this->session->set_userdata('item' . $id, $qty);
		}
	}

	// 買い物カゴの情報を取得
	public function get_cart()
	{
		$items = [];	// 商品情報の配列
		$total = 0;			// 合計金額
		$line  = 0;			// 行数

# セッションクラスのall_userdata()メソッドですべてのセッションデータを取得し、 
# ループで回して必要な情報を取り出します。
		foreach ($this->session->all_userdata() as $key => $val)
		{
# 配列のキーが「item」で始まる場合、商品情報です。
			if (substr($key, 0, 4) == 'item')
			{
				$line++;
# 配列のキーから商品IDを取り出します。
				$id     = (int) substr($key, 4);
# get_product_item()メソッドを使い、商品データを取得します。
				$item   = $this->Inventory_model->get_product_item($id);
# 単価に数量を掛けて金額を計算します。
				$amount = $item->price * $val;
# 以上の情報を連想配列に代入します。
				$items[$line] = [ 	'id'     => $id,
									'qty'    => $val,
									'name'   => $item->name,
									'price'  => $item->price,
									'amount' => $amount
								];
# 合計金額を計算します。
				$total = $total + $amount;
			}
		}

		$cart['items'] = $items;	// 商品情報の配列
		$cart['line']  = $line;		// 商品アイテム数
		$cart['total'] = $total;	// 合計金額

		return $cart;
	}

	public function get_cart_item_count()
	{
		$cart = $this->get_cart();
		return $cart['line'];
	}

}
