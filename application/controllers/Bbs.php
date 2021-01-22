<?php
/* モバイル対応簡易掲示板
 * 
 */

/**
 * @property CI_DB_query_builder $db
 * @property CI_User_agent $agent
 * @property CI_Pagination $pagination
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Config $config
 */
class Bbs extends CI_Controller {

# 記事表示ページで、1ページに表示する記事の件数を設定します。
	public $limit = 5;

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(['form', 'url']);
# データベースを使うため、データベースクラスをロードします。
		$this->load->database();

		//$this->output->enable_profiler(TRUE);
	}

	// 日付順に記事を表示
	public function index($offset = '')
	{
# 引数から$offsetに値が渡されます。これは、3番目のURIセグメントの値です。
# ユーザが変更可能なデータですので、int型へ変換し、必ず整数値にします。
		$offset = (int) $offset;

# 新しい記事ID順に、limit値とoffset値を指定し、bbsテーブルから記事データ
# (オブジェクト)を取得し、$data['query']に代入します。order_by()メソッドは、
# フィールド名とソート順を引数にとり、ORDER BY句を指定します。
		$this->db->order_by('id', 'desc');
		$data = [];
		$data['query'] = $this->db->get('bbs', $this->limit, $offset);

# ページネーションを生成します。
		$this->load->library('pagination');
		$config = [];
		$config['base_url'] = $this->config->site_url('/bbs/index/');
# 記事の総件数をbbsテーブルから取得します。count_all()メソッドは、テーブル名
# を引数にとり、そのテーブルのレコード数を返します。
		$config['total_rows'] = $this->db->count_all('bbs');
		$config['per_page'] = $this->limit;
		$config['first_link']      = '&laquo;最初';
		$config['last_link']       = '最後&raquo;';
		$config['num_tag_open']    = ' ';
		$config['num_tag_close']   = ' ';
		$config['last_tag_open']   = ' ';
		$config['last_tag_close']  = ' ';
		$config['first_tag_open']  = ' ';
		$config['first_tag_close'] = ' ';
# 携帯端末かどうかを判定し、ページネーションの前後に挿入するタグを変更します。
		if ($this->agent->is_mobile())
		{
			$config['full_tag_open']  = '<tr><td bgcolor="#EEEEEE">';
			$config['full_tag_close'] = '</td></tr>';
		}
		else
		{
			$config['full_tag_open']  = '<p class="pagination">';
			$config['full_tag_close'] = '</p>';
		}
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

# _load_view()メソッドは、携帯端末かどうかで、読み込むビューファイルを
# 切り替えするためのメソッドです。
		$this->_load_view('bbs_show', $data);
	}

	// 新規投稿ページ
	public function post()
	{
# バリデーションを設定し、新規投稿ページを表示します。実際の処理は、他でも
# 使いますので、プライベートメソッドにしています。
		$this->_set_validation();
		$this->_show_post_page();
	}

	// 確認ページ
	public function confirm()
	{
# 検証ルールを設定します。
		$this->_set_validation();

# 検証をパスしなかった場合は、新規投稿ページを表示します。検証をパスした場合
# は、投稿確認ページ(bbs_confirm)を表示します。
		if ($this->form_validation->run() == FALSE)
		{
			$this->_show_post_page();
		}
		else
		{
			$data = [];
			$data['name']       = $this->input->post('name');
			$data['email']      = $this->input->post('email');
			$data['subject']    = $this->input->post('subject');
			$data['body']       = $this->input->post('body');
			$data['password']   = $this->input->post('password');
			$data['key']        = $this->input->post('key');
			$data['captcha']    = $this->input->post('captcha');
			$this->_load_view('bbs_confirm', $data);
		}
	}

# 新規投稿ページを表示します。
	private function _show_post_page()
	{
# 画像キャプチャを生成します。ランダムな文字列を生成するために文字列ヘルパーを
# ロードし、キャプチャプラグインをロードします。
		$this->load->helper('string');
		$this->load->helper('captcha');
# 画像キャプチャ生成に必要な設定をします。文字列ヘルパーのrandom_string()
# メソッドを使い、ランダムな4桁の数字を取得します。
		$vals = [
					'word'      => random_string('numeric', 4),
					'img_path'  => FCPATH . 'captcha/',
					'img_url'   => base_url() . 'captcha/'
				];
		$cap = create_captcha($vals);
		$data = [
					'captcha_id'   => '',
					'captcha_time' => $cap['time'],
					'word'         => $cap['word'],
				];
# 生成したキャプチャの情報をcaptchaテーブルに登録します。
		$this->db->insert('captcha', $data);
# 登録時に付けられたキャプチャのID番号を取得します。
		$key = $this->db->insert_id();

		$data['image']      = $cap['image'];
		$data['key']        = $key;
		$data['name']       = $this->input->post('name');
		$data['email']      = $this->input->post('email');
		$data['subject']    = $this->input->post('subject');
		$data['body']       = $this->input->post('body');
		$data['password']   = $this->input->post('password');
		$this->_load_view('bbs_post', $data);
	}

	// 削除ページ
	public function delete($id = '')
	{
# 第1引数、つまり、3番目のURIセグメントのデータをint型に変換します。
		$id = (int) $id;
# POSTされたpasswordフィールドの値を$passwordに代入します。
		$password = $this->input->post('password');
# POSTされたdeleteフィールドの値を$deleteに代入します。この値が
# 1の場合は、削除を実行します。1以外は、削除の確認ページを表示します。
		$delete = (int) $this->input->post('delete');

# 削除パスワードが入力されていない場合は、エラーページを表示します。
		if ($password == '')
		{
			$this->_load_view('bbs_delete_error');
		}
		else
		{
# 記事IDと削除パスワードを条件として、bbsテーブルを検索します。
			$this->db->where('id', $id);
			$this->db->where('password', $password);
			$query = $this->db->get('bbs');

# レコードが存在した場合は、削除パスワードが一致したことになりますので、
# 次の処理に移ります。
			if ($query->num_rows() == 1)
			{
# POSTされたデータのdeleteフィールドが1の場合は、確認ページからのPOSTなの
# で、記事を削除します。
				if ($delete == 1)
				{
					$this->db->where('id', $id);
					$this->db->delete('bbs');
					$this->_load_view('bbs_delete_finished');
				}
# deleteフィールドが1以外の場合は、記事表示ページからのPOSTですので、確認
# ページを表示します。
				else
				{
					$row = $query->row();

					$data = [];
					$data['id']       = $row->id;
					$data['name']     = $row->name;
					$data['email']    = $row->email;
					$data['subject']  = $row->subject;
					$data['datetime'] = $row->datetime;
					$data['body']     = $row->body;
					$data['password'] = $row->password;
					$this->_load_view('bbs_delete_confirm', $data);
				}
			}
# 削除パスワードが一致しなかった場合は、エラーページを表示します。
			else
			{
				$this->_load_view('bbs_delete_error');
			}
		}
	}

# バリデーションを設定します。
	private function _set_validation()
	{
		$this->load->library('form_validation');

# 携帯端末かどうかを判定して、エラー表示の前後に挿入するタグを変更します。
		if ($this->agent->is_mobile())
		{
			$this->form_validation->set_error_delimiters('<div>', '</div>');
		}
		else
		{
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		}

# 整形・検証ルールを設定します。alpha_numericは英数字のみ、numericは数字のみ
# となります。callback_captcha_checkは、ユーザが定義したcaptcha_check()メソッド
# で検証することを意味します。
		$this->form_validation->set_rules(
			'name', '名前', 'trim|required|max_length[16]'
		);
		$this->form_validation->set_rules(
			'email', 'メールアドレス', 'trim|valid_email|max_length[64]'
		);
		$this->form_validation->set_rules(
			'subject', '件名', 'trim|required|max_length[32]'
		);
		$this->form_validation->set_rules(
			'body', '内容', 'trim|required|max_length[200]'
		);
		$this->form_validation->set_rules(
			'password', '削除パスワード', 'max_length[32]'
		);
		$this->form_validation->set_rules(
			'captcha', '画像認証コード', 'trim|required|alpha_numeric|callback_captcha_check'
		);
# keyフィールドは、キャプチャのID番号です。隠しフィールドに仕込まれるのみで
# ユーザの目に触れることはありません。
		$this->form_validation->set_rules('key', 'key', 'numeric');
	}

# 投稿された記事をデータベースに登録します。
	public function insert()
	{
# 検証ルールを設定します。
		$this->_set_validation();

# 検証にパスしない場合は、新規投稿ページを表示します。
		if ($this->form_validation->run() == FALSE)
		{
			$this->_show_post_page();
		}
		else
		{
# 検証にパスした場合は、送られたデータとIPアドレスをbbsテーブルに登録します。
			$data = [];
			$data['name']       = $this->input->post('name');
			$data['email']      = $this->input->post('email');
			$data['subject']    = $this->input->post('subject');
			$data['body']       = $this->input->post('body');
			$data['password']   = $this->input->post('password');
			$data['ip_address'] = $this->input->server('REMOTE_ADDR');
			$this->db->insert('bbs', $data);

# URLヘルパーのredirect()メソッドで記事表示ページにリダイレクトします。
			redirect('/bbs');
		}
	}

# キャプチャの検証をするメソッドです。バリデーション(認証)クラスより呼ばれます。
	public function captcha_check($str)
	{
# 環境がtestingの場合は、キャプチャの検証をスキップします。
		if (ENVIRONMENT === 'testing' && $str === '8888')
		{
			return TRUE;
		}

# 有効期限を2時間に設定し、それ以前に生成されたキャプチャをデータベースから
# 削除します。delete()メソッドの第2引数では、「captcha_time <」を配列のキーに
# していますが、このように記述することで、WHERE句の条件の演算子を指定できます。
		$expiration = time() - 7200;	// 有効期限 2時間
		$this->db->delete('captcha', ['captcha_time <' => $expiration]);

# バリデーション(検証)クラスより引数$strに渡された、ユーザからの入力値がデータ
# ベースに保存されている値と一致するかどうかを調べます。隠しフィールドである
# keyフィールドの値と$strを条件に、有効期限内のレコードをデータベースから
# 検索します。条件に合うレコードが存在すれば、一致したと判断します。
# where()メソッドは、複数回呼ばれると、AND条件になります。
		$this->db->select("COUNT(*) AS count");
		$this->db->where('word', $str);
		$this->db->where('captcha_id', $this->input->post('key'));
		$this->db->where('captcha_time >', $expiration);
		$query = $this->db->get('captcha');
		$row = $query->row();

# 投稿されたIDのキャプチャを削除します。
		$this->db->delete('captcha', ['captcha_id' => $this->input->post('key')]);

# レコードが0件の場合、つまり、一致しなかった場合は、captcha_checkルール
# のエラーメッセージを設定し、FALSEを返します。
		if ($row->count == 0)
		{
			$this->form_validation->set_message('captcha_check', '画像認証コードが一致しません。');
			return FALSE;
		}
# 一致した場合は、TRUEを返します。
		else
		{
			return TRUE;
		}
	}

# 携帯端末かどうかを判定し、ビューをロードするプライベートメソッドです。
	private function _load_view($file, $data = '')
	{
# 携帯端末の場合は、「_mobile」がファイル名に付くビューファイルをロードします。
		if ($this->agent->is_mobile())
		{
			$this->load->view($file . '_mobile', $data);
		}
		else
		{
			$this->load->view($file, $data);
		}
	}

# _outputメソッドは、コントローラで定義されている特殊なメソッドです。
# 引数には、出力されるデータの文字列が渡されます。
	public function _output($output)
	{
# 携帯端末の場合は、HTTPヘッダのContent-Typeヘッダで文字エンコードがShift_JIS
# である旨を出力し、送信するコンテンツもShift_JISに変換したものを送ります。
		if ($this->agent->is_mobile())
		{
			header('Content-Type: text/html; charset=Shift_JIS');
			echo mb_convert_encoding($output, 'SJIS-win', 'UTF-8');
		}
# 携帯端末でない場合は、文字エンコードはUTF-8ですので、Content-Typeヘッダでも
# UTF-8を送り、コンテンツもデフォルトのまま送信します。
		else
		{
			header('Content-Type: text/html; charset=UTF-8');
			echo $output;
		}
	}
}
