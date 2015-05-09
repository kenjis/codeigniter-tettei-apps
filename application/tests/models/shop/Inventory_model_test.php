<?php

class Inventory_model_test extends PHPUnit_Framework_TestCase
{
	public static function setUpBeforeClass()
	{
		$CI =& get_instance();
		$CI->load->library('Seeder');
		$CI->seeder->exec('CategorySeeder');
	}

	public function setUp()
	{
		$this->CI =& get_instance();
		$this->CI->load->model('shop/Inventory_model');
		$this->obj = $this->CI->Inventory_model;
	}

	public function test_get_category_list()
	{
		$expected = [
			1 => '本',
			2 => 'CD',
			3 => 'DVD',
		];
		$list = $this->obj->get_category_list();
		foreach ($list as $category) {
			$this->assertEquals($expected[$category->id], $category->name);
		}
	}

	public function test_get_category_name()
	{
		$actual = $this->obj->get_category_name(1);
		$expected = '本';
		$this->assertEquals($expected, $actual);
	}

	public function test_get_product_count()
	{
		$actual = $this->obj->get_product_count(1);
		$expected = 36;
		$this->assertEquals($expected, $actual);
	}
}
