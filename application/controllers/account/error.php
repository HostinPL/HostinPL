<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class errorController extends Controller {
	public function index() {
		$this->document->setActiveSection('account');
		$this->document->setActiveItem('pay');
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 0) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		$this->load->model('users');
		$this->load->model('invoices');
        
 		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('account/error', $this->data);
	}
}
?>