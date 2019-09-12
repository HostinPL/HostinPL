<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class ownerController extends Controller {
	public function index($serverid = null) {
		$this->load->checkLicense();
		$this->document->setActiveSection('servers');
		$this->document->setActiveItem('index');
		$this->data['title'] = $this->config->title;
		$this->data['description'] = $this->config->description;
		$this->data['keywords'] = $this->config->keywords;
		$this->data['logo'] = $this->config->logo;
		$this->data['url'] = $this->config->url;
		$this->data['public'] = $this->config->public;
		$this->data['webhosting'] = $this->config->webhosting;
		$this->data['styles'] = $this->config->styles;
		
		$this->data['activesection'] = $this->document->getActiveSection();
		$this->data['activeitem'] = $this->document->getActiveItem();

		if($this->user->isLogged()) {
			$this->data['logged'] = true;
			$this->data['user_email'] = $this->user->getEmail();
			$this->data['user_firstname'] = $this->user->getFirstname();
			$this->data['user_lastname'] = $this->user->getLastname();
			$this->data['user_balance'] = $this->user->getBalance();
			$this->data['user_access_level'] = $this->user->getAccessLevel();
			$this->data['user_img'] = $this->user->getUser_img();
		} else {
			$this->data['logged'] = false;
			$this->data['user_access_level'] = 0;
		}
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 0) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->model('servers');
		$this->load->model('serversOwners');
		$error = $this->validate($serverid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'servers/index');
		}
		
		$userid = $this->user->getId();

		$this->data['server'] = $server = $this->serversModel->getServerById($serverid, array('games', 'locations'));
		$this->data['serversOwners'] = $serversOwners = $this->serversOwnersModel->getOwners(array('server_id' => $serverid), array('users'));


		$this->getChild(array('common/footer'));
		return $this->load->view('servers/owner', $this->data);
	}
	
	public function ajax($serverid = null) {
		$this->load->checkLicense();
		if(!$this->user->isLogged()) {
			$this->data['status'] = "error";
			$this->data['error'] = "Вы не авторизированы!";
			return json_encode($this->data);
		}
		if($this->user->getAccessLevel() < 1) {
			$this->data['status'] = "error";
			$this->data['error'] = "У вас нет доступа к данному разделу!";
			return json_encode($this->data);
		}
		
		$this->data['userid'] = $userid = $this->user->getId();

		$this->load->library('mail');
		$this->load->model('users');
		$this->load->model('servers');
		$this->load->model('serversOwners');

		$error = $this->validate($serverid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'servers/index');
		}

		$server = $this->serversModel->getServerById($serverid);
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			if($server['server_status'] == 1){
				if(!$this->validatePOST($serverid)) {
					$ownerid = @$this->request->post['ownerid'];
					
					$ownerData = array(
						'server_id'				=> $serverid,
						'user_id'				=> $ownerid,
						'owner_status'  		=> 0
					);
					$serverOwnerId = $this->serversOwnersModel->createOwner($ownerData);
					
					$mailLib = new mailLibrary();
					
					$mailLib->setFrom($this->config->mail_from);
					$mailLib->setSender($this->config->mail_sender);
					$mailLib->setTo($this->user->getEmail());
					$mailLib->setSubject("Добавление совладельца");
					
					$mailData = array();
					
					$mailData['firstname'] = $this->user->getFirstname();
					$mailData['lastname'] = $this->user->getlastname();
					$mailData['server_id'] = $serverid;
					$mailData['user_id'] = $ownerid;
					$mailData['owner_id'] = $serverOwnerId;
					$mailData['token'] = md5($serverOwnerId."IK2uTaodFW");
					$mailData['url'] = $this->config->url;
					$mailData['title'] = $this->config->title;	
					
					$text = $this->load->view('mail/servers/owner', $mailData);
					
					$mailLib->setText($text);
					$mailLib->send();
					
					$this->data['status'] = "success";
					$this->data['success'] = "Подтвердите добавление совладельца через email сообщение!";			
				} else {
					$this->data['status'] = "error";
					$this->data['error'] = $this->validatePOST($serverid);
				}
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = "Сервер должен быть выключен!";
			}
		}

		return json_encode($this->data);
	}
	
	public function email_confirm($serverid = null, $ownerid = null, $token = null) {
		$this->load->checkLicense();
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 1) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->data['userid'] = $userid = $this->user->getId();
	
		$this->load->model('servers');
		$this->load->model('serversOwners');

		$error = $this->validate($serverid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'servers/index');
		}
		
		$gameOwner = $this->serversOwnersModel->getOwnerById($ownerid);
		
		if($token == md5($gameOwner['owner_id']."IK2uTaodFW")){		
			if($gameOwner['owner_status'] == 0){				
				$this->serversOwnersModel->updateOwner($gameOwner['owner_id'], array('owner_status' => 1));		

				$this->session->data['success'] = "Совладелец ".$gameOwner['user_id']." успешно добавлен!";
				$this->response->redirect($this->config->url . 'servers/owner/index/'.$serverid);
			} else {
				$this->session->data['warning'] = "Данный совладелец уже активирован.";
				$this->response->redirect($this->config->url . 'servers/owner/index/'.$serverid);
			}
		} else {
			$this->session->data['error'] = "Данный ключ добавления совладельца не действителен.";
			$this->response->redirect($this->config->url . 'servers/owner/index/'.$serverid);
		}

		$this->getChild(array('common/Sheader', 'common/footer'));
		return $this->load->view('servers/owner', $this->data);
	}	
	
	public function action($action = null, $serverid = null, $ownerid = null) {
		$this->load->checkLicense();
		if(!$this->user->isLogged()) {
			$this->data['status'] = "error";
			$this->data['error'] = "Вы не авторизированы!";
			return json_encode($this->data);
		}
		if($this->user->getAccessLevel() < 1) {
			$this->data['status'] = "error";
			$this->data['error'] = "У вас нет доступа к данному разделу!";
			return json_encode($this->data);
		}
		
		$this->data['userid'] = $userid = $this->user->getId();
		
		$this->load->model('servers');
		$this->load->model('serversOwners');

		$error = $this->validate($serverid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'servers/index');
		}
		
		$server = $this->serversModel->getServerById($serverid);
		
		if($server['server_status'] == 1){
			switch($action) {
				case 'delete': {
					if($this->serversModel->getTotalServerOwners(array('server_id' => $serverid, 'owner_id' => $ownerid))) {
						$this->serversOwnersModel->deleteOwner($ownerid);
					
						$this->data['status'] = "success";
						$this->data['success'] = "Вы успешно удалили совладельца!";
					} else {
						$this->data['status'] = "error";
						$this->data['error'] = "err!";
					}
					break;
				}
				default: {
					$this->data['status'] = "error";
					$this->data['error'] = "Вы выбрали несуществующее действие!";
					break;
				}
			}
		} else {
			$this->data['status'] = "error";
			$this->data['error'] = "Сервер должен быть выключен!";
		}

		return json_encode($this->data);
	}
	
	private function validate($serverid) {
		$result = null;
		$userid = $this->user->getId();

		if (!$this->serversModel->getTotalServers( array( 'server_id' => (int)$serverid, 'user_id' => (int)$userid ) )) {
			$result = 'Запрашиваемый сервер не существует!';
		}

		return $result;
	}

	private function validatePOST($serverid) {
		$result = null;
		$this->load->library('validate');
		
		$validateLib = new validateLibrary();
		$ownerid = @$this->request->post['ownerid'];
		$userid = $this->user->getId();
				
		if(!$validateLib->money($ownerid)) {
			$result = "Вы указали недоступный ID пользователя!";
		}elseif(!$this->usersModel->getTotalUsers(array('user_id' => $ownerid))) {
			$result = "Запрашиваемый пользователь не существует!";
		}elseif($this->serversModel->getTotalServerOwners(array('server_id' => $serverid, 'user_id' => $ownerid))) {
			$result = "Запрашиваемый пользователь уже добавлен!";
		}elseif($userid == $ownerid) {
			$result = "Запрашиваемый пользователь является владельцем сервера!";
		}
		
		return $result;
	}
}