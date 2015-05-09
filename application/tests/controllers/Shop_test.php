<?php

class Shop_test extends TestCase
{
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
}
