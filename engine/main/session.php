<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class Session {
	public $data = array();
			
  	public function __construct() {
		if(!session_id()) session_start();
		$this->data = &$_SESSION;
	}
}
?>
