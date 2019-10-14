<?php
/* 簡易ショッピングカート
 * 
 */

/**
 * @property Shop_model $shop_model
 * @property Inventory_model $inventory_model
 * @property Cart_model $cart_model
 * @property Customer_model $customer_model
 * @property Field_validation $field_validation
 * @property Generate_pagination $generate_pagination
 * @property Twig $twig
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property CI_Config $config
 * @property CI_Input $input
 */
class Shop extends MY_Controller {

	public $limit;	// 1ページに表示する商品の数
	public $admin;	// 管理者のメールアドレス

	public function __construct()
	{
		parent::__construct();
		$this->load->library(['session', 'twig']);
		$this->load->helper(['form', 'url']);

# モデルをロードします。ロード後のモデルオブジェクトは、$this->shop_modelなど
# として利用できます。
		$this->load->model([
			'shop/shop_model',
			'shop/inventory_model',
			'shop/cart_model',
			'shop/customer_model',
		]);

# このアプリケーション専用の設定ファイルconfig_shop.phpを読み込みます。
# load()メソッドの第2引数にTRUEを指定すると、他の設定ファイルで使われている
# 設定項目名との衝突を気にしなくても済みます。
		$this->config->load('config_shop', TRUE);
# 上記のように読み込んだ場合、設定値は、以下のようにitem()メソッドに引数で
# 「設定項目名」と「設定ファイル名」を渡すことで取得できます。
		$this->limit = $this->config->item('per_page', 'config_shop');
		$this->admin = $this->config->item('admin_email', 'config_shop');
	}

	// トップページ = カテゴリ別商品一覧
	public function index($cat_id = '1', $offset = '0')
	{
# カテゴリーIDとオフセットを検証します。
		$this->load->library('validation/field_validation');
		$this->field_validation->validate(
			$cat_id, 'required|is_natural|max_length[11]'
		);
		$this->field_validation->validate(
			$offset, 'required|is_natural|max_length[3]'
		);

		$data = [];

# モデルからカテゴリの一覧を取得します。
		$data['cat_list'] = $this->inventory_model->get_category_list();

# カテゴリIDとoffset値と、1ページに表示する商品の数を渡し、モデルより
# 商品一覧を取得します。
		$data['list'] = $this->inventory_model->get_product_list(
			$cat_id, $this->limit, $offset
		);
# カテゴリIDより、カテゴリ名を取得します。
		$data['category'] = $this->inventory_model->get_category_name($cat_id);

# モデルよりそのカテゴリの商品数を取得し、ページネーションを生成します。
		$this->load->library('generate_pagination');
		$path  = '/shop/index/' . $cat_id;
		$total = $this->inventory_model->get_product_count($cat_id);
		$data['pagination'] = $this->generate_pagination->get_links($path, $total, 4);

		$data['total'] = $total;

		$data['main'] = 'shop_list';

# モデルよりカートの中の商品アイテム数を取得します。
		$data['item_count'] = $this->cart_model->count();

# ビューを表示します。
		$this->twig->display('shop_tmpl_shop', $data);
	}

	// 商品詳細ページ
	public function product($prod_id = '1')
	{
# 商品IDを検証します。
		$this->load->library('validation/field_validation');
		$this->field_validation->validate(
			$prod_id, 'required|is_natural|max_length[11]'
		);

		$data = [];
		$data['cat_list'] = $this->inventory_model->get_category_list();

# モデルより商品データを取得します。
		$data['item'] = $this->inventory_model->get_product_item($prod_id);
		$data['main'] = 'shop_product';

		$data['item_count'] = $this->cart_model->count();
		$this->twig->display('shop_tmpl_shop', $data);
	}

	// カゴに入れる
	public function add($prod_id = '0')
	{
# 商品IDを検証します。
		$this->load->library('validation/field_validation');
		$this->field_validation->validate(
			$prod_id, 'required|is_natural|max_length[11]'
		);
# POSTされたqtyフィールドより、数量を取得します。
		$qty = $this->input->post('qty');
# 数量を検証します。
		$this->field_validation->validate(
			$qty, 'required|is_natural|max_length[3]'
		);

		$this->cart_model->add($prod_id, $qty);

# コントローラのcart()メソッドを呼び出し、カートを表示します。
		$this->cart();
	}

	// 買い物カゴページ
	public function cart()
	{
		$data = [];
		$data['cat_list'] = $this->inventory_model->get_category_list();

# モデルより、カートの情報を取得します。
		$cart = $this->cart_model->get_all();
		$data['total']      = $cart['total'];
		$data['cart']       = $cart['items'];
		$data['item_count'] = $cart['line'];

		$data['main'] = 'shop_cart';
		$this->twig->display('shop_tmpl_shop', $data);
	}

	// 検索ページ
	public function search($offset = '0')
	{
# オフセットを検証します。
		$this->load->library('validation/field_validation');
		$this->field_validation->validate(
			$offset, 'required|is_natural|max_length[3]'
		);

# 検索キーワードをクエリ文字列から取得します。
		$q = (string) $this->input->get('q');
# 全角スペースを半角スペースに変換します。
		$q = trim(mb_convert_kana($q, 's'));
# 検索キーワードを検証します。
		$this->field_validation->validate(
			$q, 'max_length[100]'
		);

		$data = [];
		$data['cat_list'] = $this->inventory_model->get_category_list();

# モデルから、キーワードで検索した商品データと総件数を取得します。
		$data['list'] = $this->inventory_model->get_product_by_search(
			$q, $this->limit, $offset
		);
		$total = $this->inventory_model->get_count_by_search($q);

# ページネーションを生成します。
		$this->load->library('generate_pagination');
		$path  = '/shop/search';
		$data['pagination'] = $this->generate_pagination->get_links($path, $total, 3);

		$data['q'] = $q;
		$data['total'] = $total;

		$data['main']   = 'shop_search';
		$data['item_count'] = $this->cart_model->count();
		$this->twig->display('shop_tmpl_shop', $data);
	}

	// お客様情報入力ページ
	public function customer_info()
	{
# 検証ルールを設定します。
		$this->load->library('validation/shop_validation_customer');
		$this->form_validation->run();

		$data = [
			'action' => 'お客様情報の入力',
			'main'   => 'shop_customer_info',
		];
		$this->twig->display('shop_tmpl_checkout', $data);
	}

	// 注文内容確認
	public function confirm()
	{
		$this->load->library('validation/shop_validation_customer');

		if ($this->form_validation->run() == TRUE)
		{
# 検証をパスした入力データは、モデルを使って保存します。
			$data = [
				'name'  => $this->input->post('name'),
				'zip'   => $this->input->post('zip'),
				'addr'  => $this->input->post('addr'),
				'tel'   => $this->input->post('tel'),
				'email' => $this->input->post('email'),
			];
			$this->customer_model->set($data);

			$cart = $this->cart_model->get_all();
			$data['total'] = $cart['total'];
			$data['cart']  = $cart['items'];

			$data['action'] = '注文内容の確認';
			$data['main']   = 'shop_confirm';
		}
		else
		{
			$data = [
				'action' => 'お客様情報の入力',
				'main'   => 'shop_customer_info',
			];
		}

		$this->twig->display('shop_tmpl_checkout', $data);
	}

	// 注文処理
	public function order()
	{
		if ($this->cart_model->count() == 0)
		{
			echo '買い物カゴには何も入っていません。';
		}
# モデルのorder()メソッドを呼び出し、注文データの処理を依頼します。
		elseif ($this->shop_model->order())
		{
			$data = [
				'action' => '注文の完了',
				'main'   => 'shop_thankyou',
			];
			$this->twig->display('shop_tmpl_checkout', $data);
# 注文が完了したので、セッションを破棄します。
			$this->session->sess_destroy();
		}
		else
		{
			echo 'システムエラー';
		}
	}
}
