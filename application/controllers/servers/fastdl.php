<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class fastdlController extends Controller {
//Главная страница FastDL
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
		$this->data['server'] = $server;
		$this->getChild(array('common/footer'));
		return $this->load->view('servers/fastdl', $this->data);
	}

	public function action($action = null, $serverid = null) {
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

		$server = $this->serversModel->getServerById($serverid, array('games', 'locations'));
		
		if($server['server_status'] == 1){
			switch($action) {
				case 'on': {
					if($server['fastdl_status'] == 0){			
						$this->load->library('ssh2');
						
						$ssh = new ssh2Library();
						
						$ip = $server['location_ip'];
						$user = $server['location_user'];
						$pass = $server['location_password'];
						
						
						$connect = $ssh->connect($ip, $user, $pass);

						$txt_end = "Options Indexes FollowSymLinks\n"; 
						$txt_end .= "AllowOverride None\n"; 
						$txt_end .= "Require all granted\n"; 
						$txt_end .= "<IfModule mod_php5.c>\n"; 
						$txt_end .= "php_admin_flag engine off\n"; 
						$txt_end .= "</IfModule>\n\n"; 
						$txt_end .= "</Directory>\n\n";
						
						$txt  = "Alias /gs" . $serverid . "/sound /home/gs" . $serverid . "/cstrike/sound\n";
						$txt .= "<Directory /home/gs" . $serverid . "/cstrike/sound>\n";
						$txt .= $txt_end;
						$txt .= "Alias /gs" . $serverid . "/models /home/gs" . $serverid . "/cstrike/models\n";
						$txt .= "<Directory /home/gs" . $serverid . "/cstrike/models>\n";
						$txt .= $txt_end;
						$txt .= "Alias /gs" . $serverid . "/materials /home/gs" . $serverid . "/cstrike/materials\n";
						$txt .= "<Directory /home/gs" . $serverid . "/cstrike/materials>\n";
						$txt .= $txt_end;
						$txt .= "Alias /gs" . $serverid . "/maps /home/gs" . $serverid . "/cstrike/maps\n";
						$txt .= "<Directory /home/gs" . $serverid . "/cstrike/maps>\n";
						$txt .= $txt_end;
						$txt .= "Alias /gs" . $serverid . "/sprites /home/gs" . $serverid . "/cstrike/sprites\n";
						$txt .= "<Directory /home/gs" . $serverid . "/cstrike/sprites>\n";
						$txt .= $txt_end;
						$txt .= "Alias /gs" . $serverid . "/overviews /home/gs" . $serverid . "/cstrike/overviews\n";
						$txt .= "<Directory /home/gs" . $serverid . "/gs/overviews>\n";
						$txt .= $txt_end;
						$txt .= "Alias /gs" . $serverid . "/gfx /home/gs" . $serverid . "/cstrike/gfx\n";
						$txt .= "<Directory /home/gs" . $serverid . "/cstrike/gfx>\n";
						$txt .= $txt_end;
						
						$ssh->execute($connect, 'echo "' . $txt . '" > /etc/apache2/fastdl/' . $serverid . '.conf;screen -mdS ' . $server['server_id'] . '_installfastdl service apache2 restart;');
						$ssh->disconnect($connect);
						$this->serversModel->updateServer($serverid, array('fastdl_status' => 1));
						$this->data['status'] = "success";
						$this->data['success'] = "FastDL подключается!";
					}elseif($server['fastdl_status'] == 1){
						$this->data['status'] = "error";
						$this->data['error'] = "FastDL Уже включён!";
					}
					break;
				}
				case 'off': {
					if($server['fastdl_status'] == 1){
						$this->load->library('ssh2');
						
						$ssh = new ssh2Library();
						
						$ip = $server['location_ip'];
						$user = $server['location_user'];
						$pass = $server['location_password'];
						
						
						$connect = $ssh->connect($ip, $user, $pass);
						$ssh->execute($connect, 'rm -r /etc/apache2/fastdl/' . $server['server_id'] . '.conf;screen -mdS ' . $server['server_id'] . '_removevastdl service apache2 restart;');
						$ssh->disconnect($connect);
						$this->serversModel->updateServer($serverid, array('fastdl_status' => 0));
						$this->data['status'] = "success";
						$this->data['success'] = "FastDL успешно отключён!";
					}elseif($server['fastdl_status'] == 0){
						$this->data['status'] = "error";
						$this->data['error'] = "FastDL Уже отключён!";
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

	function validate($serverid) {
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