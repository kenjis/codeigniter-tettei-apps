<?php

class Shop_validation
{
	private $CI;

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library('form_validation');

		$this->set_validation_rules();
	}

	// バリデーションの設定
	protected function set_validation_rules()
	{
		$this->set_error_delimiters(
			'<div class="error">', '</div>'
		);

		$this->set_rules('name', '名前', 'trim|required|max_length[64]');
		$this->set_rules('zip', '郵便番号', 'trim|max_length[8]');
		$this->set_rules('addr', '住所', 'trim|required|max_length[128]');
		$this->set_rules('tel', '電話番号', 'trim|required|max_length[20]');
		$this->set_rules(
			'email', 'メールアドレス', 'trim|required|valid_email|max_length[64]'
		);
	}

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
}
