<?php

class Shop_validation
{
	// バリデーションの設定
	public function set()
	{
		$this->CI =& get_instance();

		$this->CI->load->library('form_validation');
		$this->CI->form_validation->set_error_delimiters('<div class="error">', '</div>');

		$this->CI->form_validation->set_rules(
			'name', '名前', 'trim|required|max_length[64]'
		);
		$this->CI->form_validation->set_rules(
			'zip', '郵便番号', 'trim|max_length[8]'
		);
		$this->CI->form_validation->set_rules(
			'addr', '住所', 'trim|required|max_length[128]'
		);
		$this->CI->form_validation->set_rules(
			'tel', '電話番号', 'trim|required|max_length[20]'
		);
		$this->CI->form_validation->set_rules(
			'email', 'メールアドレス', 'trim|required|valid_email|max_length[64]'
		);
	}
}
