<?php

class Shop_model_test extends TestCase
{
	public function setUp()
	{
		$this->CI =& get_instance();
		$this->CI->load->model('shop/Shop_model');
		$this->obj = $this->CI->Shop_model;
		$this->CI->email = new Mock_Libraries_Email();
		$this->CI->admin = 'admin@example.jp';
	}

	public function test_order()
	{
		$this->CI->Cart_model->add(1, 1);
		$this->CI->Cart_model->add(2, 2);
		
		$actual = $this->obj->order();
		$this->assertTrue($actual);
		
		$mail = $this->CI->email->_get_data();
		$this->assertEquals($this->CI->admin, $mail['from']);
		$this->assertContains('注文合計： 11,400円', $mail['message']);
	}
}
