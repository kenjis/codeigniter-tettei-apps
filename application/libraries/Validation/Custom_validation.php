<?php

abstract class Custom_validation
{
	private $CI;

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library('form_validation');

		$this->set_validation_rules();
	}

	// バリデーションの設定
	abstract protected function set_validation_rules();

	protected function set_error_delimiters($prefix = '<p>', $suffix = '</p>')
	{
		$this->CI->form_validation->set_error_delimiters($prefix, $suffix);
	}

	protected function set_rules(
		$field, $label = '', $rules = array(), $errors = array()
	)
	{
		$this->CI->form_validation->set_rules($field, $label, $rules, $errors);
	}

	public function validate(array $data = [])
	{
		if ($data !== [])
		{
			$this->CI->form_validation->set_data($data);
			$this->set_validation_rules();
		}

		return $this->run();
	}

	public function run()
	{
		return $this->CI->form_validation->run();
	}
}
