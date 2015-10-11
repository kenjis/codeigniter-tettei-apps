<?php

class Customer_model_test extends TestCase
{
	public function setUp()
	{
		$this->CI =& get_instance();
		$this->CI->load->model('shop/customer_model');
		$this->obj = $this->CI->customer_model;
	}

	public function test_set_and_get()
	{
		$expected = [
			'name'  => '名前',
			'zip'   => '111-1111',
			'addr'  => '東京都千代田区',
			'tel'   => '03-3333-3333',
			'email' => 'foo@example.jp'
		];
		$list = $this->obj->set($expected);

		$actual = $this->obj->get();
		$this->assertEquals($expected, $actual);
	}
}
