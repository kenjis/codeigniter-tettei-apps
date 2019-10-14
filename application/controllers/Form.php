<?php
/* コンタクトフォーム
 * 
 */

/**
 * @property CI_Email $email
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Output $output
 */
class Form extends CI_Controller {

	public function __construct()
	{
# 親クラスのコンストラクタを呼び出します。コントローラにコンストラクタを
# 記述する場合は、忘れずに記述してください。
		parent::__construct();

# 必要なヘルパーをロードします。
		$this->load->helper(['form', 'url']);
		
# セッションクラスをロードすることで、セッションを開始します。
		$this->load->library('session');

# 出力クラスのset_header()メソッドでHTTPヘッダのContent-Typeヘッダを指定
# します。
		$this->output->set_header('Content-Type: text/html; charset=UTF-8');

# バリデーション(検証)クラスをロードします。
		$this->load->library('form_validation');

		//$this->output->enable_profiler(TRUE);
	}

	private function _set_validation()
	{
# バリデーションの設定をします。
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('name', '名前', 'trim|required|max_length[20]');
		$this->form_validation->set_rules('email', 'メールアドレス', 'trim|required|valid_email');
		$this->form_validation->set_rules('comment', 'コメント', 'required|max_length[200]');
	}

	public function index()
	{
# 入力ページ(form)のビューをロードし表示します。
		$this->load->view('form');
	}

	public function confirm()
	{
# 検証ルールを設定します。
		$this->_set_validation();

# バリデーション(検証)クラスのrun()メソッドを呼び出し、送信されたデータの検証
# を行います。検証OKなら、確認ページ(form_confirm)を表示します。
		if ($this->form_validation->run() == TRUE)
		{
			$this->load->view('form_confirm');
		}
# 検証でエラーの場合、入力ページ(form)を表示します。
		else
		{
			$this->load->view('form');
		}
	}

	public function send()
	{
# 検証ルールを設定します。
		$this->_set_validation();

# 送信されたデータの検証を行い、検証OKなら、メールを送信します。
		if ($this->form_validation->run() == TRUE)
		{
# メールの内容を設定します。
			$mail = [];
			$mail['from_name'] = $this->input->post('name');
			$mail['from']      = $this->input->post('email');
			$mail['to']        = 'info@example.jp';
			$mail['subject']   = 'コンタクトフォーム';
			$mail['body']      = $this->input->post('comment');

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

	private function _sendmail($mail)
	{
# Emailクラスをロードします。
		$this->load->library('email');
		$config = [];
# メールの送信方法を指定します。ここでは、mail()関数を使います。
		$config['protocol'] = 'mail';
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
//			echo $this->email->print_debugger();
			return FALSE;
		}
	}

}
