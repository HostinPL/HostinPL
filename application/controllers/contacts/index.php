<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class indexController extends Controller {
	private $limit = 20;
	public function index() {
		$this->load->checkLicense();
		$this->document->setActiveSection('contacts');
		$this->document->setActiveItem('index');
		
        if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 0) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		
		$this->load->model('users');
		$users = $this->usersModel->getUsers(array(), array(), $options);
		$this->data['users'] = $users;
		
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('contacts/index', $this->data);
	}
}
?>
