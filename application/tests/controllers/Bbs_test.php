<?php

use Symfony\Component\DomCrawler\Crawler;

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

	public function test_index_mobile()
	{
		$agent = $this->getMockBuilder('CI_User_agent')
			->getMock();
		$agent->method('is_mobile')
			->willReturn(true);

		get_new_instance();
		$obj = new Bbs();
		$obj->agent = $agent;

		ob_start();
		$obj->index();
		$output = ob_get_clean();

		$this->assertContains('<title>ﾓﾊﾞｲﾙ掲示板</title>', $output);
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
		$this->warning_off();
		
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
		$this->warning_on();

		$output = $this->request('GET', ['bbs', 'index'], [], $this->load_agent);
		$this->assertContains(html_escape($subject), $output);
	}

	public function test_delete()
	{
		// Warningを抑制する
		// Severity: WarningMessage:  Cannot modify header information - headers already sent
		$this->warning_off();
		
		$output = $this->request(
			'POST',
			['bbs', 'insert'],
			[
				'name' => "削除太郎",
				'email' => "test@example.jp",
				'subject' => "削除する投稿",
				'body' => "この投稿を削除します。",
				'password' => "delete",
				'captcha' => "8888",
				'key' => "139",
			],
			$this->load_agent
		);
		
		// error_reportingを戻す
		$this->warning_on();

		$output = $this->request('GET', ['bbs', 'index'], [], $this->load_agent);
		$crawler = new Crawler($output);
		
		// 最初の <h1><a>〜</a></h1> のテキストを取得
		$text = $crawler->filter('h1 > a')->eq(0)->text();
		$id = trim($text, '[]');
		
		$output = $this->request('POST', ['bbs', 'delete', $id], [], $this->load_agent);
		$this->assertContains('記事を削除できませんでした', $output);

		$output = $this->request(
			'POST',
			['bbs', 'delete', $id],
			['password' => 'delete'],
			$this->load_agent
		);
		$this->assertContains('削除の確認', $output);

		$output = $this->request(
			'POST',
			['bbs', 'delete', $id],
			[
				'password' => 'bad password',
				'delete' => '1',
			],
			$this->load_agent
		);
		$this->assertContains('記事を削除できませんでした', $output);

		$output = $this->request(
			'POST',
			['bbs', 'delete', $id],
			[
				'password' => 'delete',
				'delete' => '1',
			],
			$this->load_agent
		);
		$this->assertContains('記事の削除完了', $output);
	}

	public function test_captcha_check()
	{
		$obj = new Bbs();
		$obj->form_validation = new CI_Form_validation();
		$actual = $obj->captcha_check('bad_input');
		$this->assertFalse($actual);
	}
}
