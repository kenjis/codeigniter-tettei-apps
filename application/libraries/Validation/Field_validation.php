<?php

class Field_validation
{
	private $CI;

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library('form_validation');
	}

	public function validate($value, $rules, $errors = [])
	{
		$this->CI->form_validation->reset_validation();

		$data = [
			'field' => $value
		];
		$this->CI->form_validation->set_data($data);

		$this->CI->form_validation->set_rules('field', '', $rules, $errors);

		if ($this->CI->form_validation->run() === FALSE)
		{
			show_error('不正な入力です。');
		}
		else
		{
			return TRUE;
		}
	}
}
