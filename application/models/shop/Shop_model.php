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
# 注文日時をPHPのdate()関数から取得します。
		$date = date("Y/m/d H:i:s");
# カートの情報を取得します。
		$cart = $this->Cart_model->get_all();
		$total = number_format($cart['total']);

# お客様情報を取得します。
		$data = $this->Customer_model->get();
		$name  = $data['name'];
		$zip   = $data['zip'];
		$addr  = $data['addr'];
		$tel   = $data['tel'];
		$email = $data['email'];

# メールのヘッダを設定します。Bccで同じメールを管理者にも送るようにします。
		$mail['from_name'] = 'CIショップ';
		$mail['from']      = $this->admin;
		$mail['to']        = $email;
		$mail['bcc']       = $this->admin;
		$mail['subject']   = '【注文メール】CIショップ';

# ヒアドキュメントでメール本文を作成します。
		$mail['body'] = <<< END
CIショップにご注文いただきありがとうございます。ご注文内容は以下のとおりです。

***********************************************************
 お名前とご請求金額
***********************************************************
       お名前: $name
メールアドレス: $email

     注文合計： {$total}円

***********************************************************
 注文内容
***********************************************************
注文日時: $date


END;

		foreach ($cart['items'] as $line => $item)
		{
			$mail['body'] .= $item['name'] . "\n";
			$mail['body'] .= '数量: ' . $item['qty'] . "\n";
			$mail['body'] .= '単価: ' . number_format($item['price']) . "円\n";
			$mail['body'] .= '金額: ' . number_format($item['amount']) . "円\n\n";
		}
		$mail['body'] .= '合計金額: ' . $total ."円\n\n";

		$mail['body'] .= <<< END
***********************************************************
 お届け先
***********************************************************
$zip
$addr
$name
$tel

***********************************************************
今後ともCIショップをよろしくお願いいたします。
------------------------------------------------------------- 
CIショップ

http://codeigniter.jp
------------------------------------------------------------- 
END;

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
