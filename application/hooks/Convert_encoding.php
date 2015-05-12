<?php

class Convert_encoding
{
	private function check_route()
	{
		if (isset($_SERVER['PATH_INFO']) && substr($_SERVER['PATH_INFO'], 0, 4) === '/bbs')
		{
			return true;
		}

		return false;
	}

	public function run()
	{
		if (is_cli())
		{
			return;
		}

		if ( ! $this->check_route())
		{
			return;
		}

# 携帯端末からのアクセスを判定するためユーザエージェントクラスをロードします。
		$agent =& load_class('User_agent');

# 携帯端末からの入力文字エンコードを変換します。
		if (count($_POST) > 1 && $agent->is_mobile())
		{
			$_POST = $this->convert_to_utf8($_POST);
		}
	}

	public function add_agent()
	{
		if (is_cli())
		{
			return;
		}

		if (! $this->check_route()) {
			return;
		}

		// load_class()でuser_agentをロードしたため、$this->user_agentとして
		// して代入されているので、それを$this->agentに変更する
		$CI =& get_instance();
		$CI->agent = $CI->user_agent;
		unset($CI->user_agent);
	}

	// 入力文字エンコード変換
	private function convert_to_utf8($array)
	{
# 引数が配列の場合は、配列の各々の要素を自分自身に渡し処理します。
# array_map()関数の第1引数は、コールバック関数ですが、ここでは、クラス内の
# メソッドを指定しますので、[$this, 'convert_to_utf8']と配列
# で渡す必要があります。
		if (is_array($array))
		{
			return array_map([$this, 'convert_to_utf8'], $array);
		}
# 引数が配列でない場合は、文字エンコードをUTF-8に変換し、返します。
		else
		{
			return mb_convert_encoding($array, 'UTF-8', 'SJIS-win');
		}
	}
}
