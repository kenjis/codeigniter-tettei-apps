<?php

class Convert_encoding_test extends TestCase
{
	public function setUp()
	{
		require_once APPPATH . 'hooks/Convert_encoding.php';
		$this->obj = new Convert_encoding();
	}

	public function test_run_and_add_agent()
	{
		reset_instance();

		$str = '尾骶骨';
		$_SERVER['PATH_INFO'] = '/bbs';
		$_POST = [
			'name' => mb_convert_encoding($str, 'SJIS-win', 'UTF-8'),
			'email' => '',
		];
		$agent = $this->getDouble('CI_User_agent', ['is_mobile' => TRUE]);
		load_class_instance('User_agent', $agent);
		// is_cli()の返り値をfalseに変更
		set_is_cli(FALSE);

		$this->obj->run();
		$this->assertEquals('尾骨', $_POST['name']);

		new CI_Controller();

		$this->obj->add_agent();
		$CI =& get_instance();
		$this->assertSame($agent, $CI->agent);
		$this->assertFalse(isset($CI->user_agent));

		// is_cli()の返り値をtrueに戻す
		set_is_cli(TRUE);
	}

	public function test_check_route_false()
	{
		reset_instance();
		set_is_cli(FALSE);
		$_SERVER['PATH_INFO'] = '/shop';

		$this->obj->run();
		$loaded_classes = is_loaded();
		$this->assertFalse(isset($loaded_classes['User_agent']));

		$this->obj->add_agent();
		$this->assertFalse(isset($CI->agent));

		set_is_cli(TRUE);
		new CI_Controller();
	}
}
