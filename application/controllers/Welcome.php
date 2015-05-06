<?php

class Welcome extends CI_Controller {

	public function index()
	{
		$this->output->set_header('Content-Type: text/html; charset=UTF-8');
		$this->load->helper('url');
		$this->load->view('index');
	}
}
