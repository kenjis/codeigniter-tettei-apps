<?php
/* 簡易ショッピングカート
 * 
 */

class Shop extends Controller {

	var $limit;	// 1ページに表示する商品の数
	var $admin;	// 管理者のメールアドレス

	function Shop()
	{
		parent::Controller();
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));

# モデルをロードします。ロード後のモデルオブジェクトは、$this->Shop_model
# として利用できます。
		$this->load->model('Shop_model');

# このアプリケーション専用の設定ファイルconfig_shop.phpを読み込みます。
# load()メソッドの第2引数にTRUEを指定すると、他の設定ファイルで使われている
# 設定項目名との衝突を気にしなくても済みます。
		$this->config->load('config_shop', TRUE);
# 上記のように読み込んだ場合、設定値は、以下のようにitem()メソッドに引数で
# 「設定項目名」と「設定ファイル名」を渡すことで取得できます。
		$this->limit = $this->config->item('per_page', 'config_shop');
		$this->admin = $this->config->item('admin_email', 'config_shop');

		$this->output->set_header('Content-Type: text/html; charset=UTF-8');

# Scaffoldingを読み込みます。productテーブルを編集可能にします。
		$this->load->scaffolding('product');

		//$this->output->enable_profiler(TRUE);
	}

	// トップページ = カテゴリ別商品一覧
	function index()
	{
# モデルからカテゴリの一覧を取得し、shop_menuビューに渡します。このとき、
# view()メソッドの第2引数にTRUEを指定することで、処理されたページデータを
# ブラウザに送信させずに、文字列として取得し、変数に代入します。
		$data['list'] = $this->Shop_model->get_category_list();
		$data['menu'] = $this->load->view('shop_menu', $data, TRUE);

# 3番目のURIセグメントより、カテゴリIDを取得します。セグメントデータがない
# 場合は、1を設定します。
		$cat_id = (int) $this->uri->segment(3, 1);
# 4番目のURIセグメントより、offset値を取得します。セグメントデータがない場合
# は、0を設定します。
		$offset = (int) $this->uri->segment(4, 0);

# カテゴリIDとoffset値と、1ページに表示する商品の数を渡し、モデルより
# 商品一覧を取得します。
		$data['list'] = $this->Shop_model->get_product_list($cat_id, $this->limit, $offset);
# カテゴリIDより、カテゴリ名を取得します。
		$data['category'] = $this->Shop_model->get_category_name($cat_id);

# モデルよりそのカテゴリの商品数を取得し、ページネーションを生成します。
		$path  = '/shop/index/' . $cat_id;
		$total = $this->Shop_model->get_product_count($cat_id);
		$data['pagination'] = $this->_generate_pagination($path, $total, 4);

		if ($total)
		{
			$data['total_item'] = $total . '点の商品が登録されています。';
		}
		else
		{
			$data['total_item'] = 'このカテゴリにはまだ商品が登録されていません。';
		}

		$data['main']   = $this->load->view('shop_list', $data, TRUE);

# モデルよりカートの中の商品アイテム数を取得します。
		$data['item_count'] = $this->Shop_model->get_cart_item_count();
# ショップヘッダのページデータを文字列として取得し、変数に代入します。
		$data['header'] = $this->load->view('shop_header', $data, TRUE);
# ビューを表示します。
		$this->load->view('shop_tmpl_shop', $data);
	}

	// 商品詳細ページ
	function product()
	{
		$data['list'] = $this->Shop_model->get_category_list();
		$data['menu'] = $this->load->view('shop_menu', $data, TRUE);

# 3番目のURIセグメントより、商品IDを取得します。セグメントデータがない
# 場合は、1を設定します。
		$prod_id = (int) $this->uri->segment(3, 1);
# モデルより商品データを取得します。
		$data['item'] = $this->Shop_model->get_product_item($prod_id);
		$data['main']   = $this->load->view('shop_product', $data, TRUE);

		$data['item_count'] = $this->Shop_model->get_cart_item_count();
		$data['header'] = $this->load->view('shop_header', $data, TRUE);
		$this->load->view('shop_tmpl_shop', $data);
	}

	// カゴに入れる
	function add()
	{
# 3番目のURIセグメントより、商品IDを取得します。セグメントデータがない
# 場合は、0を設定します。
		$prod_id = (int) $this->uri->segment(3, 0);
# POSTされたqtyフィールドより、数量を取得します。
		$qty     = (int) $this->input->post('qty');
		$this->Shop_model->add_to_cart($prod_id, $qty);

# コントローラのcart()メソッドを呼び出し、カートを表示します。
		$this->cart();
	}

	// 買い物カゴページ
	function cart()
	{
		$data['list'] = $this->Shop_model->get_category_list();
		$data['menu'] = $this->load->view('shop_menu', $data, TRUE);

# モデルより、カートの情報を取得します。
		$cart = $this->Shop_model->get_cart();
		$data['total']      = $cart['total'];
		$data['cart']       = $cart['items'];
		$data['item_count'] = $cart['line'];

		$data['main']  = $this->load->view('shop_cart', $data, TRUE);
		$data['header'] = $this->load->view('shop_header', $data, TRUE);
		$this->load->view('shop_tmpl_shop', $data);
	}

	// 検索ページ
	function search()
	{
		$q       = '';	// 検索キーワード(検索用)
		$q_disp  = '';	// 検索キーワード(表示用)
		$q_uri   = '';	// 検索キーワード(URIセグメント用)

		$data['list'] = $this->Shop_model->get_category_list();
		$data['menu'] = $this->load->view('shop_menu', $data, TRUE);

# 検索キーワードがPOSTされた場合は、qフィールドより取得します。
		if ($this->input->post('q'))
		{
			$q = $this->input->post('q');
		}
# ページネーションのリンクをクリックした場合は、3番目のURIセグメントに
# 検索キーワードが含まれますので、その値を取得します。
		else
		{
			$q = $this->uri->segment(3, '');
		}

# offset値を、4番目のURIセグメントより取得します。
		$offset = (int) $this->uri->segment(4, 0);

# 全角スペースを半角スペースに変換します。
		$q = trim(mb_convert_kana($q, "s"));

# 検索キーワードに「/」が含まれる場合は、3番目のURIセグメントに「/」が
# 含まれ、URIを適切に表示できなくなりますので、その例外処理をします。
# URIでの半角「/」を全角「／」に置換することにします。
		if (strpos($q, '/') !== FALSE)
		{
			$q_disp = $q;
			$q_uri  = str_replace('/', '／', $q);
		}
# 検索キーワードが空の場合は、3番目のURIセグメントも空になってしまい
# URIを適切に表示できなくなりますので、その例外処理をします。
# キーワードが「-」または空の場合は、検索キーワードのURIセグメントを
# 「-」とします。
		else if ($q == '-' || $q == '')
		{
			$q      = '';
			$q_disp = '全商品';
			$q_uri  = '-';
		}
		else
		{
			$q_disp = $q;
			$q_uri  = $q;
		}

# モデルから、キーワードで検索した商品データと総件数を取得します。
		$data['list'] = $this->Shop_model->get_product_by_search($q, $this->limit, $offset);
		$total = $this->Shop_model->get_count_by_search($q);

# ページネーションを生成します。検索キーワードには日本語が含まれます
# ので、URLエンコードします。
		$path  = '/shop/search/' . rawurlencode($q_uri);
		$data['pagination'] = $this->_generate_pagination($path, $total, 4);

		$data['q'] = $q_disp;

		if ($total)
		{
			$data['total_item'] = $total . '点の商品がヒットしました。';
		}
		else
		{
			$data['total_item'] = '"'. $q_disp . '"の検索に一致する商品はありませんでした。';
		}

		$data['main']   = $this->load->view('shop_search', $data, TRUE);
		$data['item_count'] = $this->Shop_model->get_cart_item_count();
		$data['header'] = $this->load->view('shop_header', $data, TRUE);
		$this->load->view('shop_tmpl_shop', $data);
	}

	// お客様情報入力ページ
	function customer_info()
	{
# 検証ルールを設定します。
		$this->_set_validation();

# 入力済みの情報があれば、モデルから取得します。
		$data = $this->Shop_model->get_customer_info();
		$this->validation->name  = $data['name'];
		$this->validation->zip   = $data['zip'];
		$this->validation->addr  = $data['addr'];
		$this->validation->tel   = $data['tel'];
		$this->validation->email = $data['email'];

		$data['action'] = 'お客様情報の入力';
		$data['main']  = $this->load->view('shop_customer_info', '', TRUE);
		$this->load->view('shop_tmpl_checkout', $data);
	}

	// 注文内容確認
	function confirm()
	{
		$this->_set_validation();

		if ($this->validation->run() == TRUE)
		{
# 検証をパスした入力データは、モデルを使って保存します。
			$data['name']  = $this->validation->name;
			$data['zip']   = $this->validation->zip;
			$data['addr']  = $this->validation->addr;
			$data['tel']   = $this->validation->tel;
			$data['email'] = $this->validation->email;
			$this->Shop_model->set_customer_info($data);

			$cart = $this->Shop_model->get_cart();
			$data['total'] = $cart['total'];
			$data['cart']  = $cart['items'];

# CSRF対策のワンタイムチケットを発行します。
			$this->ticket = md5(uniqid(mt_rand(), TRUE));
			$this->session->set_userdata('ticket', $this->ticket);

			$data['action'] = '注文内容の確認';
			$data['main']  = $this->load->view('shop_confirm', $data, TRUE);
		}
		else
		{
			$data['action'] = 'お客様情報の入力';
			$data['main']  = $this->load->view('shop_customer_info', '', TRUE);
		}

		$this->load->view('shop_tmpl_checkout', $data);
	}

	// 注文処理
	function order()
	{
# CSRF対策を行います。
		$this->ticket = $this->session->userdata('ticket');
		if (! $this->input->post('ticket') 
			|| $this->input->post('ticket') !== $this->ticket )
		{
			echo '不正な操作が行われました。';
			exit;
		}

		if ($this->Shop_model->get_cart_item_count() == 0)
		{
			echo '買い物カゴには何も入っていません。';
		}
# モデルのorder()メソッドを呼び出し、注文データの処理を依頼します。
		else if ($this->Shop_model->order())
		{
			$data['action'] = '注文の完了';
			$data['main']   = $this->load->view('shop_thankyou', '', TRUE);
			$this->load->view('shop_tmpl_checkout', $data);
# 注文が完了したので、セッションを破棄します。
			$this->session->sess_destroy();
		}
		else
		{
			echo 'システムエラー';
		}
	}

	// バリデーションの設定
	function _set_validation()
	{
		$this->load->library('validation');
		$this->validation->set_error_delimiters('<div class="error">', '</div>');

		$fields['name']  = '名前';
		$fields['zip']   = '郵便番号';
		$fields['addr']  = '住所';
		$fields['tel']   = '電話番号';
		$fields['email'] = 'メールアドレス';
		$this->validation->set_fields($fields);

		$rules['name']  = 'trim|required|max_length[64]';
		$rules['zip']   = 'trim|valid_emailmax_lenght[8]';
		$rules['addr']  = 'trim|required|max_length[128]';
		$rules['tel']   = 'trim|required|max_length[20]';
		$rules['email'] = 'trim|required|valid_email|max_lenght[64]';
		$this->validation->set_rules($rules);
	}

	// ページネーションの生成
	function _generate_pagination($path, $total, $uri_segment)
	{
# ページネーションクラスをロードします。
		$this->load->library('pagination');
# リンク先のURLを指定します。
		$config['base_url']       = $this->config->site_url($path);
# 総件数を指定します。
		$config['total_rows']     = $total;
# 1ページに表示する件数を指定します。
		$config['per_page']       = $this->limit;
# ページ番号情報がどのURIセグメントに含まれるか指定します。
		$config['uri_segment']    = $uri_segment;
# 生成するリンクのテンプレートを指定します。
		$config['first_link']     = '&laquo;最初';
		$config['last_link']      = '最後&raquo;';
		$config['full_tag_open']  = '<p>';
		$config['full_tag_close'] = '</p>';
# $configでページネーションを初期化します。
		$this->pagination->initialize($config);
# 生成したリンクの文字列を返します。
		return $this->pagination->create_links();
	}
}
?>