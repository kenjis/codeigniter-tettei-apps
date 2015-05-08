<?php

class Mail_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('email');
	}

	// メール送信処理
	public function sendmail($mail)
	{
# Emailクラスを初期化します。
		$config['protocol'] = 'mail';
		$config['wordwrap'] = FALSE;
		$this->email->initialize($config);

# メールの内容を変数に代入します。
		$from_name = $mail['from_name'];
		$from      = $mail['from'];
		$to        = $mail['to'];
		$bcc       = $mail['bcc'];
		$subject   = $mail['subject'];
		$body      = $mail['body'];

# 差出人、あて先、Bcc、件名、本文を設定します。
		$this->email->from($from, $from_name);
		$this->email->to($to);
		$this->email->bcc($bcc);
		$this->email->subject($subject);
		$this->email->message($body);

# send()メソッドで実際にメールを送信します。
		if ($this->email->send())
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

}
