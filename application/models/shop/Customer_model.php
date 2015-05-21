<?php

/**
 * @property CI_Session $session
 */
class Customer_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
	}

	/**
	 * @param array $data
	 */
	public function set($data)
	{
		foreach ($data as $key => $val)
		{
			$this->session->set_userdata($key, $val);
		}
	}

	/**
	 * @return array
	 */
	public function get()
	{
		$data = [];
		$data['name']  = $this->session->userdata('name');
		$data['zip']   = $this->session->userdata('zip');
		$data['addr']  = $this->session->userdata('addr');
		$data['tel']   = $this->session->userdata('tel');
		$data['email'] = $this->session->userdata('email');

		return $data;
	}

}
