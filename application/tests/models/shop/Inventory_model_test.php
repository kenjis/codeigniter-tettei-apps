<?php

class Inventory_model_test extends UnitTestCase
{
	public static function setUpBeforeClass()
	{
		parent::setUpBeforeClass();

		$CI =& get_instance();
		$CI->load->library('seeder');
		$CI->seeder->call('CategorySeeder');
	}

	public function setUp()
	{
		$this->obj = $this->newModel(Inventory_model::class);
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

	public function test_get_product_by_search()
	{
		$results = $this->obj->get_product_by_search('CodeIgniter', 10, 0);
		foreach ($results as $record)
		{
			$this->assertContains('CodeIgniter', $record->name);
		}
	}

	public function test_get_count_by_search()
	{
		$actual = $this->obj->get_count_by_search('CodeIgniter');
		$expected = 3;
		$this->assertEquals($expected, $actual);
	}

	public function test_is_available_product_item_not_available()
	{
		$actual = $this->obj->is_available_product_item(9999999999);
		$this->assertFalse($actual);
	}
}
