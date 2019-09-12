<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class mysqlController extends Controller {
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
		$this->load->model('tickets');
		$this->load->model('ticketsMessages');
		$this->load->model('users');
  		$error = $this->validate($serverid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'servers/index');
		}
		
		$userid = $this->user->getId();
		
		$server = $this->serversModel->getServerById($serverid, array('games', 'locations'));
		$this->data['server'] = $server;
		
		if($server['server_status'] == 2) {
			$queryLib = new queryLibrary($server['game_query']);
			$queryLib->connect($server['location_ip'], $server['server_port']);
			$query = $queryLib->getInfo();
			$queryLib->disconnect();
			
			$this->data['query'] = $query;
		}
		
		$stats = $this->serversStatsModel->getServerStats($serverid, "NOW() - INTERVAL 1 DAY", "NOW()");
				$rtickets = $this->ticketsModel->getTickets($getData, array('users'), $getSort, $getOptions);
		$total = $this->ticketsModel->getTotalTickets(array('user_id' => (int)$userid));
		$tickets = $this->ticketsModel->getTickets(array('user_id' => (int)$userid), array(), $sort, $options);
		$ticket = $this->ticketsModel->getTicketById($ticketid, array('users'));
		$messages = $this->ticketsMessagesModel->getTicketsMessages(array('ticket_id' => $ticketid), array('users'));
		$this->data['rtickets'] = $rtickets;
		$this->data['ticket'] = $ticket;
		$this->data['messages'] = $messages;
		$this->data['tickets'] = $tickets;
		$visitors = $this->usersModel->getAuthLog($userid);
		$this->data['visitors'] = $visitors;
		$this->data['stats'] = $stats;
		$this->getChild(array('common/footer'));
		return $this->load->view('servers/mysql', $this->data);
	}
	
public function action($serverid = null, $action = null) {
		$this->load->checkLicense();
		if(!$this->user->isLogged()) {
			$this->data['status'] = "error";
			$this->data['error'] = "Вы не авторизированы!";
			return json_encode($this->data);
		}
		if($this->user->getAccessLevel() < 0) {
	  		$this->data['status'] = "error";
			$this->data['error'] = "У вас нет доступа к данному разделу!";
			return json_encode($this->data);
		}
		
		$this->load->model('servers');
		
		$error = $this->validate($serverid);
		if($error) {
			$this->data['status'] = "error";
			$this->data['error'] = $error;
			return json_encode($this->data);
		}
		
		$server = $this->serversModel->getServerById($serverid);
		switch($action) {
			case 'mysqlon': {
				if($server['server_mysql'] == 2) {
						$this->serversModel->updateServer($serverid, array('server_mysql' => 1));
						$this->data['status'] = "success";
						$this->data['success'] = "Вы успешно включили MySQL!";
				} else {
					$this->data['status'] = "error";
					$this->data['error'] = "MySQL и так включен либо вы его еще не создали!";
				}
				break;
			}	
			case 'mysqloff': {
				if($server['server_mysql'] == 1) {
						$this->serversModel->updateServer($serverid, array('server_mysql' => 2));
						$this->data['status'] = "success";
						$this->data['success'] = "Вы успешно выключили MySQL!";
				} else {
					$this->data['status'] = "error";
					$this->data['error'] = "MySQL и так выключен!";
				}
				break;
			}		
			case 'mysqlcr': {
				if($server['server_mysql'] == 0) {
						$this->serversModel->createMySQL($serverid);
						$this->serversModel->updateServer($serverid, array('server_mysql' => 2));
						$this->data['status'] = "success";
						$this->data['success'] = "Вы успешно создали MySQL! (БД: gs$serverid)";
				} else {
					$this->data['status'] = "error";
					$this->data['error'] = "MySQL и так создан!";
				}
				break;
			}				
			default: {
				$this->data['status'] = "error";
				$this->data['error'] = "Вы выбрали несуществующее действие!";
				break;
			}
		}
		
		return json_encode($this->data);
	}
	

	
	private function validate($serverid) {
		$this->load->checkLicense();
		$result = null;
		
		$userid = $this->user->getId();
		
		if(!$this->serversModel->getTotalServerOwners(array('server_id' => (int)$serverid, 'user_id' => (int)$userid, 'owner_status' => 1))) {
			if(!$this->serversModel->getTotalServers(array('server_id' => (int)$serverid, 'user_id' => (int)$userid))) {
				$result = "Запрашиваемый сервер не существует!";
			}
		}
		return $result;
	}
	 

}
?>
