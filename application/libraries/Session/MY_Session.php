<?php

class MY_Session extends CI_Session
{
	public function __construct(array $params = array())
	{
		if (is_cli() === true && ENVIRONMENT === 'testing')
		{
			log_message('debug', 'Session: Initialization under testing aborted.');
			return;
		}

		parent::__construct($params);
	}

	public function sess_destroy()
	{
		if (is_cli() === true && ENVIRONMENT === 'testing')
		{
			log_message('debug', 'Session: calling session_destroy() skipped under testing.');
			return;
		}

		parent::sess_destroy();
	}
}
