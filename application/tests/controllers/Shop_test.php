<?php

class Shop_test extends UnitTestCase
{
	public static function setUpBeforeClass()
	{
		parent::setUpBeforeClass();

		$CI =& get_instance();
		$CI->load->library('Seeder');
		$CI->seeder->call('ProductSeeder');
	}

	public function test_index()
	{
		$output = $this->request('GET', 'shop');
		$this->assertContains('<title>CIショップ</title>', $output);
	}

	public function test_product()
	{
		$output = $this->request('GET', 'shop/product/1');
		$this->assertContains('CodeIgniter徹底入門', $output);
	}

	public function test_add()
	{
		$output = $this->request('POST', 'shop/add/3', ['qty' => '3']);
		$this->assertContains('CodeIgniter徹底入門 DVD', $output);
	}

	public function test_search()
	{
		$output = $this->request('GET', 'shop/search', ['q' => '徹底入門']);
		$this->assertContains('「徹底入門」の検索結果', $output);
	}

	public function test_customer_info()
	{
		$output = $this->request('POST', 'shop/add/1', ['qty' => '1']);
		$this->assertContains('CodeIgniter徹底入門', $output);
		$output = $this->request('GET', 'shop/cart');
		$this->assertContains('買い物かご', $output);
		$this->assertContains('CodeIgniter徹底入門', $output);
		$output = $this->request('POST', 'shop/customer_info');
		$this->assertContains('お客様情報の入力', $output);
	}

	public function test_confirm_pass()
	{
		$obj = $this->newController(Shop::class);

		$model = $this->getDouble('Customer_model', ['set' => NULL]);
		$this->verifyInvokedOnce($model, 'set');
		$validation = $this->getDouble(
			'CI_Form_validation', ['run' => TRUE], TRUE
		);
		$twig = $this->getDouble('Twig_Environment', ['display' => NULL]);
		$this->verifyInvokedMultipleTimes(
			$twig, 'display', 1,
			[
				['shop_tmpl_checkout', $this->anything()],
			]
		);
		$obj->form_validation = $validation;
		$obj->twig = $twig;
		$obj->customer_model = $model;
		
		$obj->confirm();
	}

	public function test_confirm_fail()
	{
		$obj = $this->newController(Shop::class);

		$model = $this->getDouble('Customer_model', ['set' => NULL]);
		$this->verifyNeverInvoked($model, 'set');
		$validation = $this->getDouble(
			'CI_Form_validation', ['run' => FALSE], TRUE
		);
		$twig = $this->getDouble('Twig_Environment', ['display' => NULL]);
		
		$data['action'] = 'お客様情報の入力';
		$data['main']   = 'shop_customer_info';
		$this->verifyInvokedMultipleTimes(
			$twig, 'display', 1,
			[
				['shop_tmpl_checkout', $data]
			]
		);
		$obj->form_validation = $validation;
		$obj->twig = $twig;
		$obj->Customer_model = $model;

		$obj->confirm();
	}

	public function test_order_cart_is_empty()
	{
		$obj = $this->newController(Shop::class);

		$cart = $this->getDouble('Cart_model', ['count' => 0]);
		$obj->cart_model = $cart;

		ob_start();
		$obj->order();
		$output = ob_get_clean();

		$this->assertContains('買い物カゴには何も入っていません', $output);
	}

	public function test_order()
	{
		$obj = $this->newController(Shop::class);

		$cart = $this->getDouble('Cart_model', ['count' => 1]);
		$shop = $this->getDouble('Shop_model', ['order' => TRUE]);
		$obj->cart_model = $cart;
		$obj->shop_model = $shop;

		$obj->order();
		$output = $this->CI->output->get_output();

		$this->assertContains('ご注文ありがとうございます', $output);
	}

	public function test_order_system_error()
	{
		$obj = $this->newController(Shop::class);

		$cart = $this->getDouble('Cart_model', ['count' => 1]);
		$shop = $this->getDouble('Shop_model', ['order' => FALSE]);
		$obj->cart_model = $cart;
		$obj->shop_model = $shop;

		ob_start();
		$obj->order();
		$output = ob_get_clean();

		$this->assertContains('システムエラー', $output);
	}
}
