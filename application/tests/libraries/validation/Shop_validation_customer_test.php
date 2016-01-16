<?php

class Shop_validation_customer_test extends TestCase
{
	public function setUp()
	{
		$this->resetInstance();

		// Form_validaton::set_rules()が影響を受けるので、インスタンス生成前に
		// POSTメソッドにしておく必要がある
		$_SERVER['REQUEST_METHOD'] = 'POST';
		$this->CI->load->library('validation/shop_validation_customer');
		$this->obj = $this->CI->form_validation;
	}

	public function test_run_empty_data()
	{
		$_POST = [];
		$this->assertFalse($this->obj->run());
	}

	public function test_run_minimum_valid_data()
	{
		$_POST = [
			'name' => 'abc',
			'addr' => 'abc',
			'tel' => '03-3333-3333',
			'email' => 'foo@example.jp',
		];
		$this->assertTrue($this->obj->run(), $this->obj->error_string());
	}

	public function test_run_name_error()
	{
		$_POST = [
			'name' => '',
			'addr' => 'abc',
			'tel' => '03-3333-3333',
			'email' => 'xxx@example.jp',
		];
		$this->obj->run();
		$test = $this->obj->error_array();
		$expected = [
			'name' => '名前欄は必須フィールドです',
		];
		$this->assertEquals($expected, $test);
	}
}
