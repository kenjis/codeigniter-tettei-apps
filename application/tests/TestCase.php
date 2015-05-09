<?php

class TestCase extends PHPUnit_Framework_TestCase
{
	/**
	 * Request to Controller
	 * 
	 * @param string $method HTTP method
	 * @param array $argv    controller, method [, arg1, ...]
	 * @param array $params  POST parameters/Query string
	 */
	public function request($method, $argv, $params = [])
	{
		$_SERVER['REQUEST_METHOD'] = $method;
		
		$_SERVER['argv'] = array_merge(['index.php'], $argv);
		
		if ($method === 'POST')
		{
			$_POST = $params;
		}
		elseif ($method === 'GET')
		{
			$_GET = $params;
		}
//		var_dump($_SERVER['REQUEST_METHOD'], $_SERVER['argv'], $_GET, $_POST); exit;
		
		$this->CI = get_new_instance();
		
		$controller = ucfirst($_SERVER['argv'][1]);
		$this->obj = new $controller;
		ob_start();
		call_user_func([$this->obj, $_SERVER['argv'][2]]);
		$output = ob_get_clean();
		
		return $output;
	}
}
