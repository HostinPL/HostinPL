<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class firewallController extends Controller {
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
		$this->load->model('serversFirewalls');
		$error = $this->validate($serverid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'servers/index');
		}
		
		$userid = $this->user->getId();

		$this->data['server'] = $server = $this->serversModel->getServerById($serverid, array('games', 'locations'));
		$this->data['Firewalls'] = $Firewalls = $this->serversFirewallsModel->getFirewallsById($serverid);


		$this->getChild(array('common/footer'));
		return $this->load->view('servers/firewall', $this->data);
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

		$this->load->model('servers');
		$this->load->model('serversFirewalls');

		$error = $this->validate($serverid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'servers/index');
		}

		$server = $this->serversModel->getServerById($serverid);
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			if($server['server_status'] == 1){
				if(!$this->validatePOST($serverid)) {
					$address = @$this->request->post['address'];
					
					$firewallData = array(
						'server_id'		=> $serverid,
						'server_ip'  	=> $address
					);
					$firewallid = $this->serversFirewallsModel->createFirewall($firewallData);
					
					$this->serversFirewallsModel->addFirewall($firewallid);
					$this->data['status'] = "success";
					$this->data['success'] = "Вы успешно добавили IP адресс!";				
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
	
	public function action($action = null, $serverid = null, $firewallid = null) {
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
		$this->load->model('serversFirewalls');

		$server = $this->serversModel->getServerById($serverid);
		
		if($server['server_status'] == 1){
			switch($action) {
				case 'delete': {
					$this->serversFirewallsModel->deleteFirewall($firewallid);
					$this->data['status'] = "success";
					$this->data['success'] = "Вы успешно разблокировали IP адресс!";
					break;
				}
				case 'deleteall': {
					$this->serversFirewallsModel->deleteFirewalls($gameid);
					$this->data['status'] = "success";
					$this->data['success'] = "Вы успешно удалили все заблокированные IP адреса!";
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

		if(!$this->serversModel->getTotalServerOwners(array('server_id' => (int)$serverid, 'user_id' => (int)$userid, 'owner_status' => 1))) {
			if(!$this->serversModel->getTotalServers(array('server_id' => (int)$serverid, 'user_id' => (int)$userid))) {
				$result = "Запрашиваемый сервер не существует!";
			}
		}

		return $result;
	}
	
	private function validatePOST($serverid) {
		$this->load->checkLicense();
		$this->load->library('validate');
		$validateLib = new validateLibrary();

		$result = null;

		$address = @$this->request->post['address'];
				
		if(!$validateLib->ip($address)) {
			$result = "Вы указали недоступный IP адресс!";
		}
		elseif($this->serversFirewallsModel->getTotalFirewalls(array('server_ip' => $address, 'server_id' => $serverid))) {
			$result = "Добавляемый IP адресс уже заблокирован!";
		}
		
		return $result;
	}

}