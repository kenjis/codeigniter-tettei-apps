<?php

class Form_test extends TestCase
{
	public function test_index()
	{
		$output = $this->request('GET', ['form', 'index']);
		$this->assertContains('<title>コンタクトフォーム</title>', $output);
	}

	public function test_confirm_error()
	{
		$output = $this->request('POST', ['form', 'confirm'], ['name' => '']);
		$this->assertContains('名前欄は必須フィールドです', $output);
	}

	public function test_confirm_ok()
	{
		$output = $this->request(
			'POST',
			['form', 'confirm'],
			[
				'name' => '<s>abc</s>',
				'email' => 'test@example.jp',
				'comment' => '<s>abc</s>',
			]
		);
		$this->assertContains('お問い合わせ内容の確認', $output);
		$this->assertContains('&lt;s&gt;abc&lt;/s&gt;', $output);
		$this->assertNotContains('<s>abc</s>', $output);
	}

	public function test_send()
	{
		$output = $this->request(
			'POST',
			['form', 'send'],
			[
				'name' => '<s>abc</s>',
				'email' => 'test@example.jp',
				'comment' => '<s>abc</s>',
			],
			function ($CI) {
				$email = $this->get_mock('CI_Email', ['send' => TRUE]);
				load_class_instance('email', $email);
			}
		);
		$this->assertContains('送信しました', $output);
	}
}
