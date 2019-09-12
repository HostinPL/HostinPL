<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class settingController extends Controller {
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
		
		$this->load->library('query');
		$this->load->model('servers');
		$this->load->model('serversStats');
		$this->load->model('adaps');
	    $this->load->model('tickets');
		$this->load->model('ticketsMessages');
		$this->load->model('users');
		$error = $this->validate($serverid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'servers/control/index/$serverid');
		}
		
		$userid = $this->user->getId();
		
		$server = $this->serversModel->getServerById($serverid, array('games', 'locations'));
		$this->data['server'] = $server;
		$total = $this->adapsModel->getTotalAdaps();
		$adaps = $this->adapsModel->getAdaps(array('adap_status' => 1),array('games'),array(), $options);
		$rtickets = $this->ticketsModel->getTickets($getData, array('users'), $getSort, $getOptions);
		$total = $this->ticketsModel->getTotalTickets(array('user_id' => (int)$userid));
		$tickets = $this->ticketsModel->getTickets(array('user_id' => (int)$userid), array(), $sort, $options);
		$ticket = $this->ticketsModel->getTicketById($ticketid, array('users'));
		$messages = $this->ticketsMessagesModel->getTicketsMessages(array('ticket_id' => $ticketid), array('users'));

		
		$stats = $this->serversStatsModel->getServerStats($serverid, "NOW() - INTERVAL 1 DAY", "NOW()");
		$this->data['rtickets'] = $rtickets;
		$this->data['ticket'] = $ticket;
		$this->data['messages'] = $messages;
		$this->data['tickets'] = $tickets;
		$visitors = $this->usersModel->getAuthLog($userid);
		$this->data['visitors'] = $visitors;
		$this->data['stats'] = $stats;
        $this->data['adaps'] = $adaps;
		$this->getChild(array('common/footer'));
		return $this->load->view('servers/setting', $this->data);
	}
	public function send_config($serverid = null) {
		 if(!$this->user->isLogged()) {
   $this->session->data['error'] = "Вы не авторизированы!";
   $this->response->redirect($this->config->url . 'account/login');
  }
  if($this->user->getAccessLevel() < 0) {
   $this->session->data['error'] = "У вас нет доступа к данному разделу!";
   $this->response->redirect($this->config->url);
  }
  
  $this->load->model('servers');
  $this->load->library('ssh2');
  $ssh2Lib = new ssh2Library();
  $server = $this->serversModel->getServerById($serverid, array('users', 'locations', 'games'));
  $error = $this->validate($serverid);
  if($error) {   
    $this->session->data['error'] = $error;
    $this->response->redirect($this->config->url . 'servers/index');
  }
  if($this->request->server['REQUEST_METHOD'] == 'POST') {
	  
  $text = @$this->request->post['text'];
  $file = 'ftp://gs'.$server['server_id'].':'.$server['server_password'].'@'.$server['location_ip'].':21/server.cfg';
  if (@fopen($file, "r")) {
			
        $link = $ssh2Lib->connect($server['location_ip'], $server['location_user'], $server['location_password']);
        $output = $ssh2Lib->execute($link, "cd /home/gs$serverid; echo $text > server.cfg");
        $ssh2Lib->disconnect($link);
				$this->data['status'] = "success";
				$this->data['success'] = "Конфиг успешно сохранен!";
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = "Файла не существует!";
			}
  }
  
		return json_encode($this->data);
	}
	function validate($serverid) {
			$this->load->checkLicense(  );
			$result = null;
			$this->user->getId(  );
			$userid = $this->user->getId();

			if(!$this->serversModel->getTotalServerOwners(array('server_id' => (int)$serverid, 'user_id' => (int)$userid, 'owner_status' => 1))) {
				if(!$this->serversModel->getTotalServers(array('server_id' => (int)$serverid, 'user_id' => (int)$userid))) {
					$result = "Запрашиваемый сервер не существует!";
				}
			}

			return $result;
		}
		private function validatePOST() {
	
		$this->load->library('validate');
		
		$validateLib = new validateLibrary();
		

		return $result;
	}
}