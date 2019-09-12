<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class logoutController extends Controller {
	public function index() {
		$this->load->model('users');
		$this->load->checkLicense();
		$this->document->setActiveSection('account');
		$this->document->setActiveItem('logout');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = 'Вы не авторизированы';
			$this->response->redirect($this->config->url . 'account/login');
		}
		
		$userid=$this->user->getId();$ip=$this->request->server['REMOTE_ADDR'];
		$this->usersModel->createAuthLog($userid,$ip,'2','NONE');
		
		$this->user->logout();
		$this->session->data['success'] = 'Вы успешно вышли из своего аккаунта';
		$this->response->redirect($this->config->url);
		
		return null;
	}
}
?>
