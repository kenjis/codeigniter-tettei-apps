<?php

class Customer_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
	}

	public function set_customer_info($data)
	{
		foreach ($data as $key => $val)
		{
			$this->session->set_userdata($key,  $val);
		}
	}

	public function get_customer_info()
	{
		$data['name']  = $this->session->userdata('name');
		$data['zip']   = $this->session->userdata('zip');
		$data['addr']  = $this->session->userdata('addr');
		$data['tel']   = $this->session->userdata('tel');
		$data['email'] = $this->session->userdata('email');

		return $data;
	}

}
