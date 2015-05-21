<?php

class Generate_pagination
{
	private $CI;

	// ページネーションの生成
	public function get_links($path, $total, $uri_segment)
	{
# ページネーションクラスをロードします。
		$this->CI =& get_instance();
		$this->CI->load->library('pagination');

		$config = [];
# リンク先のURLを指定します。
		$config['base_url']       = $this->CI->config->site_url($path);
# 総件数を指定します。
		$config['total_rows']     = $total;
# 1ページに表示する件数を指定します。
		$config['per_page']       = $this->CI->limit;
# ページ番号情報がどのURIセグメントに含まれるか指定します。
		$config['uri_segment']    = $uri_segment;
# ページネーションでクエリ文字列を使えるようにします。
		$config['reuse_query_string'] = TRUE;
# 生成するリンクのテンプレートを指定します。
		$config['first_link']      = '&laquo;最初';
		$config['last_link']       = '最後&raquo;';
		$config['full_tag_open']   = '<p>';
		$config['full_tag_close']  = '</p>';
		$config['num_tag_open']    = ' ';
		$config['num_tag_close']   = ' ';
		$config['last_tag_open']   = ' ';
		$config['last_tag_close']  = ' ';
		$config['first_tag_open']  = ' ';
		$config['first_tag_close'] = ' ';
# $configでページネーションを初期化します。
		$this->CI->pagination->initialize($config);
# 生成したリンクの文字列を返します。
		return $this->CI->pagination->create_links();
	}
}
