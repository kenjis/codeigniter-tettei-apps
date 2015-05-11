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

	public function test_confirm_error()
	{
		$output = $this->request(
			'POST', ['bbs', 'confirm'], ['name' => ''], $this->load_agent
		);
		$this->assertContains('名前欄は必須フィールドです', $output);
	}

	public function test_confirm_ok()
	{
		$output = $this->request(
			'POST',
			['bbs', 'confirm'],
			[
				'name' => "<s>abc</s>",
				'email' => "test@example.jp",
				'subject' => "<s>abc</s>",
				'body' => "<s>abc</s>",
				'password' => "<s>abc</s>",
				'captcha' => "8888",
				'key' => "139",
			],
			$this->load_agent
		);
		$this->assertContains('投稿確認', $output);
	}

	public function test_insert()
	{
		// Warningを抑制する
		// Severity: WarningMessage:  Cannot modify header information - headers already sent
		$er = error_reporting(E_ALL & ~E_WARNING);
		
		$subject = "<s>xyz</s> " . time();
		$output = $this->request(
			'POST',
			['bbs', 'insert'],
			[
				'name' => "<s>xyz</s>",
				'email' => "test@example.jp",
				'subject' => $subject,
				'body' => "<s>xyz</s>",
				'password' => "<s>xyz</s>",
				'captcha' => "8888",
				'key' => "139",
			],
			$this->load_agent
		);
		
		// error_reportingを戻す
		error_reporting($er);

		$output = $this->request('GET', ['bbs', 'index'], [], $this->load_agent);
		$this->assertContains(html_escape($subject), $output);
	}
}
