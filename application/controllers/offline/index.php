<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class indexController extends Controller {
	public function index() {
		$this->load->checkLicense();
		$this->data['result'] = $this->request->get['result'];
        $this->data['public'] = $this->config->public;
		
		return $this->load->view('offline/index', $this->data);
	}
}
?>