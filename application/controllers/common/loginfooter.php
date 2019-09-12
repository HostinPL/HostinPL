<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class loginfooterController extends Controller {
	public function index() {
		$this->load->checkLicense();
		$this->data['title'] = $this->config->title;
		$this->data['description'] = $this->config->description;
		$this->data['count'] = $this->config->count;
		
		return $this->load->view('common/loginfooter', $this->data);
	}
}
?>
