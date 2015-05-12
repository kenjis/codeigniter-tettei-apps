<?php

class Shop_test extends TestCase
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
		$output = $this->request('GET', ['shop', 'index']);
		$this->assertContains('<title>CIショップ</title>', $output);
	}

	public function test_product()
	{
		$output = $this->request('GET', ['shop', 'product', '1']);
		$this->assertContains('CodeIgniter徹底入門', $output);
	}

	public function test_add()
	{
		$output = $this->request('POST', ['shop', 'add', '3'], ['qty' => '3']);
		$this->assertContains('CodeIgniter徹底入門 DVD', $output);
	}

	public function test_search()
	{
		$output = $this->request('GET', ['shop', 'search'], ['q' => '徹底入門']);
		$this->assertContains('「徹底入門」の検索結果', $output);
	}

	public function test_customer_info()
	{
		$output = $this->request('POST', ['shop', 'add', '1'], ['qty' => '1']);
		$this->assertContains('CodeIgniter徹底入門', $output);
		$output = $this->request('GET', ['shop', 'cart']);
		$this->assertContains('買い物かご', $output);
		$this->assertContains('CodeIgniter徹底入門', $output);
		$output = $this->request('POST', ['shop', 'customer_info']);
		$this->assertContains('お客様情報の入力', $output);
	}

	public function test_confirm_pass()
	{
		get_new_instance();
		$obj = new Shop();

		$validation = $this->getMockBuilder('CI_Form_validation')
			->getMock();
		$validation->method('run')
			->willReturn(true);
		$loader = $this->getMockBuilder('CITEST_Loader')
			->setMethods(['view'])
			->getMock();
		$loader->expects($this->exactly(2))
			->method('view')
			->withConsecutive(
				['shop_confirm', $this->anything(), TRUE],
				['shop_tmpl_checkout', $this->anything()]
			);
		$obj->form_validation = $validation;
		$obj->load = $loader;

		$obj->confirm();
	}

	public function test_confirm_fail()
	{
		get_new_instance();
		$obj = new Shop();

		$validation = $this->getMockBuilder('CI_Form_validation')
			->getMock();
		$validation->method('run')
			->willReturn(false);
		$loader = $this->getMockBuilder('CITEST_Loader')
			->setMethods(['view'])
			->getMock();
		$loader->expects($this->exactly(2))
			->method('view')
			->withConsecutive(
				['shop_customer_info', '', TRUE],
				['shop_tmpl_checkout', $this->anything()]
			);
		$obj->form_validation = $validation;
		$obj->load = $loader;

		$obj->confirm();
	}

	public function test_order_cart_is_empty()
	{
		get_new_instance();
		$obj = new Shop();

		$cart = $this->getMockBuilder('Cart_model')
			->setMethods(['count'])
			->getMock();
		$cart->method('count')
			->willReturn(0);
		$obj->Cart_model = $cart;

		ob_start();
		$obj->order();
		$output = ob_get_clean();

		$this->assertContains('買い物カゴには何も入っていません', $output);
	}

	public function test_order()
	{
		get_new_instance();
		$obj = new Shop();

		$cart = $this->getMockBuilder('Cart_model')
			->setMethods(['count'])
			->getMock();
		$cart->method('count')
			->willReturn(1);
		$shop = $this->getMockBuilder('Shop_model')
			->setMethods(['order'])
			->getMock();
		$shop->method('order')
			->willReturn(TRUE);
		$obj->Cart_model = $cart;
		$obj->Shop_model = $shop;

		// Warningを抑制する
		// Severity: WarningMessage:  session_destroy(): Trying to destroy uninitialized session
		$this->warning_off();

		ob_start();
		$obj->order();
		$output = ob_get_clean();

		// error_reportingを戻す
		$this->warning_on();

		$this->assertContains('ご注文ありがとうございます', $output);
	}

	public function test_order_system_error()
	{
		get_new_instance();
		$obj = new Shop();

		$cart = $this->getMockBuilder('Cart_model')
			->setMethods(['count'])
			->getMock();
		$cart->method('count')
			->willReturn(1);
		$shop = $this->getMockBuilder('Shop_model')
			->setMethods(['order'])
			->getMock();
		$shop->method('order')
			->willReturn(FALSE);
		$obj->Cart_model = $cart;
		$obj->Shop_model = $shop;

		// Warningを抑制する
		// Severity: WarningMessage:  session_destroy(): Trying to destroy uninitialized session
		$this->warning_off();

		ob_start();
		$obj->order();
		$output = ob_get_clean();

		// error_reportingを戻す
		$this->warning_on();

		$this->assertContains('システムエラー', $output);
	}
}
