<?php

/**
 * @property CI_Email $email
 */
class Mail_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('email');
	}

	/**
	 * メール送信処理
	 * 
	 * @param array $mail
	 * @return boolean
	 */
	public function sendmail($mail)
	{
# Emailクラスを初期化します。
		$config = [];
		$config['protocol'] = 'mail';
		$config['wordwrap'] = FALSE;
		$this->email->initialize($config);

# 差出人、あて先、Bcc、件名、本文を設定します。
		$this->email->from($mail['from'], $mail['from_name']);
		$this->email->to($mail['to']);
		$this->email->bcc($mail['bcc']);
		$this->email->subject($mail['subject']);
		$this->email->message($mail['body']);

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
