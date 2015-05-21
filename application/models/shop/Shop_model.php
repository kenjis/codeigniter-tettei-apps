<?php

/**
 * @property Cart_model     $Cart_model
 * @property Customer_model $Customer_model
 * @property Mail_model     $Mail_model
 */
class Shop_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('shop/Cart_model');
		$this->load->model('shop/Customer_model');
		$this->load->model('shop/Mail_model');
	}

	// 注文の処理
	public function order()
	{
		$data = [];
# 注文日時をPHPのdate()関数から取得します。
		$data['date'] = date("Y/m/d H:i:s");
# カートの情報を取得します。
		$cart = $this->Cart_model->get_all();
		foreach ($cart['items'] as &$item)
		{
			$item['price']  = number_format($item['price']);
			$item['amount'] = number_format($item['amount']);
		}
		$data['items']  = $cart['items'];
		$data['line']  = $cart['line'];
		$data['total'] = number_format($cart['total']);

# お客様情報を取得します。
		$data = array_merge($data, $this->Customer_model->get());

# メールのヘッダを設定します。Bccで同じメールを管理者にも送るようにします。
		$mail = [];
		$mail['from_name'] = 'CIショップ';
		$mail['from']      = $this->admin;
		$mail['to']        = $data['email'];
		$mail['bcc']       = $this->admin;
		$mail['subject']   = '【注文メール】CIショップ';

# テンプレートパーサクラスでメール本文を作成します。
		$this->load->library('parser');
		$mail['body'] = $this->parser->parse(
			'templates/mail/shop_order', $data, TRUE
		);

# sendmail()メソッドを呼び出し、実際にメールを送信します。メール送信に成功
# すれば、TRUEを返します。
		if ($this->Mail_model->sendmail($mail))
		{
			return TRUE;
		}
# メール送信に失敗した場合は、FALSEを返します。
		else
		{
			return FALSE;
		}
	}

}
