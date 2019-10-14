<?php

/**
 * @property CI_Output $output
 */
class MY_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->output->set_header('Content-Type: text/html; charset=UTF-8');
		
		if (ENVIRONMENT === 'development') {
			$this->output->enable_profiler(TRUE);
		}
	}
}
