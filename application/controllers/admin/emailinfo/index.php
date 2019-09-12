<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class indexController extends Controller {
	public function index($userid = null) {
		$this->load->checkLicense();
		$this->document->setActiveSection('admin');
		$this->document->setActiveItem('spam');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 2) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->getChild(array('common/admheader', 'common/footer'));
		return $this->load->view('admin/emailinfo/index', $this->data);
	}
	
	public function ajax($userid = null) {
		$this->load->checkLicense();
		if(!$this->user->isLogged()) {  
	  		$this->data['status'] = "error";
			$this->data['error'] = "Вы не авторизированы!";
			return json_encode($this->data);
		}
		if($this->user->getAccessLevel() < 3) {
			$this->data['status'] = "error";
			$this->data['error'] = "У вас нет доступа к данному разделу!";
			return json_encode($this->data);
		}
		
		$this->load->model('users');
		$this->load->library('mail');
		
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
				$text = @$this->request->post['text'];
				$data=$this->usersModel->getUsers();
				foreach($data as $tmp){
					$email=$tmp['user_email'];
					$firstname=$tmp['user_firstname'];
					$lastname=$tmp['user_lastname'];
					
					$mailLib = new mailLibrary();
					$mailLib->setFrom($this->config->mail_from);
					$mailLib->setSender($this->config->mail_sender);
					$mailLib->setTo($email);
					$mailLib->setSubject('Обратите внимание!');
					
					$mailData = array();
					$mailData['firstname'] = $firstname;
					$mailData['lastname'] = $lastname;
					$mailData['text'] = $text;
					
					$texts = $this->load->view('mail/info/users', $mailData);
				
					$mailLib->setText($texts);
					$mailLib->send();
				}
				$this->data['status'] = "success";
				$this->data['success'] = "Рассылка успешно завершенна.";
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = "Не POST данные";
			}
		return json_encode($this->data);
	}
}

?>
