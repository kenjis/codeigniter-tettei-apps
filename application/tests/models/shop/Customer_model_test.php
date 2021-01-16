<?php

class Customer_model_test extends UnitTestCase
{
	public function setUp()
	{
		$this->obj = $this->newModel(Customer_model::class);
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
		$this->obj->set($expected);

		$actual = $this->obj->get();
		$this->assertEquals($expected, $actual);
	}
}
