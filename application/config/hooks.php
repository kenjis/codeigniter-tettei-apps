<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/
$hook['pre_system'] = array(
	'class'    => 'Convert_encoding',
	'function' => 'run',
	'filename' => 'Convert_encoding.php',
	'filepath' => 'hooks'
);

$hook['post_controller_constructor'] = array(
	'class'    => 'Convert_encoding',
	'function' => 'add_agent',
	'filename' => 'Convert_encoding.php',
	'filepath' => 'hooks'
);

$hook['display_override'][] = array(
	'class'     => 'DebugBarHook',
	'function'  => 'addHeader',
	'filename'  => 'DebugBarHook.php',
	'filepath'  => 'third_party/codeigniter-debugbar/hooks'
);
