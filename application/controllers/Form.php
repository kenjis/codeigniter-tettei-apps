<?php
/* コンタクトフォーム
 * 
 */

class Form extends Controller {

	function Form()
	{
# 親クラスのコンストラクタを呼び出します。コントローラにコンストラクタを
# 記述する場合は、忘れずに記述してください。
		parent::Controller();

# 必要なヘルパーをロードします。
		$this->load->helper(array('form', 'url'));
		
# セッションクラスをロードすることで、セッションを開始します。
		$this->load->library('session');

# 出力クラスのset_header()メソッドでHTTPヘッダのContent-Typeヘッダを指定
# します。
		$this->output->set_header('Content-Type: text/html; charset=UTF-8');

# バリデーション(検証)クラスをロードし、バリデーションの設定をします。
		$this->load->library('validation');
		$this->validation->set_error_delimiters('<div class="error">', '</div>');
		$fields['name']    = '名前';
		$fields['email']   = 'メールアドレス';
		$fields['comment'] = 'コメント';
		$this->validation->set_fields($fields);
		$rules['name']    = "trim|required|max_length[20]";
		$rules['email']   = "trim|required|valid_email";
		$rules['comment'] = "required|max_length[200]";
		$this->validation->set_rules($rules);

		//$this->output->enable_profiler(TRUE);
	}

	function index()
	{
# ランダムなチケットを生成し、セッションに保存します。
		$this->ticket = md5(uniqid(mt_rand(), TRUE));
		$this->session->set_userdata('ticket', $this->ticket);

# 入力ページ(form)のビューをロードし表示します。
		$this->load->view('form');
	}

	function confirm()
	{
# CSRF対策を行います。
		$this->ticket = $this->session->userdata('ticket');
		if (! $this->input->post('ticket') 
			|| $this->input->post('ticket') !== $this->ticket )
		{
			echo 'クッキーを有効にしてください。クッキーが有効な場合は、不正な操作がおこなわれました。';
			exit;
		}

# バリデーション(検証)クラスのrun()メソッドを呼び出し、送信されたデータの検証
# を行います。検証OKなら、確認ページ(form_confirm)を表示します。
		if ($this->validation->run() == TRUE)
		{
			$this->load->view('form_confirm');
		}
# 検証でエラーの場合、入力ページ(form)を表示します。
		else
		{
			$this->load->view('form');
		}
	}

	function send()
	{
# CSRF対策を行います。
		$this->ticket = $this->session->userdata('ticket');
		if (! $this->input->post('ticket') 
			|| $this->input->post('ticket') !== $this->ticket )
		{
			echo 'クッキーを有効にしてください。クッキーが有効な場合は、不正な操作が行われました。';
			exit;
		}

# 送信されたデータの検証を行い、検証OKなら、メールを送信します。
		if ($this->validation->run() == TRUE)
		{
# メールの内容を設定します。
			$mail['from_name'] = $this->validation->name;
			$mail['from']      = $this->validation->email;
			$mail['to']        = 'info@example.jp';
			$mail['subject']   = 'コンタクトフォーム';
			$mail['body']      = $this->validation->comment;

# _sendmail()メソッドを呼び出しメールの送信処理を行います。
# メールの送信に成功したら、完了ページ(form_end)を表示します。
			if ($this->_sendmail($mail))
			{
# 完了ページ(form_end)を表示し、セッションを破棄します。
				$this->load->view('form_end');
				$this->session->sess_destroy();
			}
# メールの送信に失敗した場合、エラーを表示します。
			else
			{
				echo 'メール送信エラー';
			}
		}
# 検証でエラーの場合、入力ページ(form)を表示します。
		else
		{
			$this->load->view('form');
		}
	}

	function _sendmail($mail)
	{
# Emailクラスをロードします。
		$this->load->library('email');
# メールの送信方法を指定します。ここでは、mail()関数を使います。
		$config['protocol'] = 'mail';
# メールの文字エンコードを指定します。日本語のメールを送信しますので、
# ISO-2022-JPに設定します。
		$config['charset'] = 'ISO-2022-JP';
# 日本語ではワードラップ機能は使えませんのでオフにします。
		$config['wordwrap'] = FALSE;
# $configでEmailクラスを初期化します。
		$this->email->initialize($config);

# メールの内容を変数に代入します。
		$from_name = $mail['from_name'];
		$from      = $mail['from'];
		$to        = $mail['to'];
		$subject   = $mail['subject'];
		$body      = $mail['body'];

# 日本語が含まれるメールヘッダをMIMEエンコードし、文字エンコードを
# ISO-2022-JPに変換します。
		$from_name = mb_encode_mimeheader($from_name, 'ISO-2022-JP');
		$subject   = mb_encode_mimeheader($subject,   'ISO-2022-JP');

# 本文の文字エンコードをISO-2022-JPに変換します。
		$body = mb_convert_encoding($body, 'ISO-2022-JP', 'UTF-8');

# 差出人、あて先、件名、本文をEmailクラスに設定します。
		$this->email->from($from, $from_name);
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($body);

# Emailクラスのsend()メソッドで、実際にメールを送信します。
# メールの送信が成功した場合はTRUEを、失敗した場合はFALSEを返します。
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

?>
