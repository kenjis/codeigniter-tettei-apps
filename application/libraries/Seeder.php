<?php
/**
 * 『CodeIgniter徹底入門』のサンプルアプリケーションをCodeIgniter 3.0にアップデート
 *
 * @author     Kenji Suzuki <https://github.com/kenjis>
 * @license    BSD 3-Clause License
 * @copyright  2015 Kenji Suzuki
 * @link       https://github.com/kenjis/codeigniter-tettei-apps
 */

class Seeder
{
	private $ci;
	protected $db;
	protected $dbforge;

	public function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->database();
		$this->ci->load->dbforge();
		$this->db = $this->ci->db;
		$this->dbforge = $this->ci->dbforge;
	}

	public function exec($seeder)
	{
		$file = APPPATH . 'database/seeds/' . $seeder . '.php';
		require_once $file;
		$obj = new $seeder;
		$obj->run();
	}

	public function __get($property)
	{
		return $this->ci->$property;
	}
}
