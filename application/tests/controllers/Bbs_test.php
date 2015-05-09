<?php

class Bbs_test extends TestCase
{
	public function setUp()
	{
		$this->load_agent = function ($CI) {
			$CI->load->library('user_agent');
		};
	}

	public function test_index()
	{
		$output = $this->request('GET', ['bbs', 'index'], [], $this->load_agent);
		$this->assertContains('<title>掲示板</title>', $output);
	}

	public function test_post()
	{
		$output = $this->request('GET', ['bbs', 'post'], [], $this->load_agent);
		$this->assertContains('<title>掲示板: 新規投稿</title>', $output);
	}

	public function test_confirm()
	{
		$output = $this->request(
			'POST', ['bbs', 'confirm'], ['name' => ''], $this->load_agent
		);
		$this->assertContains('名前欄は必須フィールドです', $output);
	}
}
