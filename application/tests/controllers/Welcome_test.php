<?php

class Welcome_test extends TestCase
{
	public function test_index()
	{
		$output = $this->request('GET', 'welcome');
		$this->assertContains('<title>CodeIgniterへようこそ！</title>', $output);
	}
}
