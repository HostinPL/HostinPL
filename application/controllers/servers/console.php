<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class consoleController extends Controller {
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
		if(isset($this->request->get['open'])) {
			$this->data['fileid'] = $this->request->get['open'];
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
		
		if(isset($_COOKIE["data-theme-console"])){
			$this->data['theme'] = $_COOKIE['data-theme-console'];
		} else{
			$this->data['theme'] = "color: white; background-color: black; font-family: Inconsolata; resize: none; min-height: 500px;";
		}

		$this->getChild(array('common/footer'));
		return $this->load->view('servers/console', $this->data);
	}

//
	public function getconsole($serverid = null, $file = null) {
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
		$this->load->library('ssh2');

		$error = $this->validate($serverid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'servers/index');
		}

		$server = $this->serversModel->getServerById($serverid, array('games', 'locations'));

		$ssh = new ssh2Library();
		$connect = $ssh->connect($server['location_ip'], $server['location_user'], $server['location_password']);
		
		switch($file) {
			case 'samp_1': {
				$fileLog = "server_log.txt";
				break;
			}
			case 'samp_2': {					
				$fileLog = "mysql_log.txt";
				break;
			}
			case 'crmp_1': {					
				$fileLog = "server_log.txt";
				break;
			}
			case 'mtasa_1': {					
				$fileLog = "mods/deathmatch/logs/server.log";
				break;
			}
			case 'Hurtworld_1': {					
				$fileLog = "output.txt";
				break;
			}
			default: {
				$fileLog = "screenlog.0";
				break;
			}
		}

		$screenlog = $ssh->get($connect, "cat /home/gs".$server['server_id']."/".$fileLog);
		$ssh->disconnect($connect);
				
		return $screenlog;
	}		

	public function sendconsole($serverid = null) {
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
		$this->load->library('ssh2');

		$error = $this->validate($serverid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'servers/index');
		}

		$server = $this->serversModel->getServerById($serverid, array('games', 'locations'));
		$command = @$this->request->post['cmd'];

		if($server['server_status'] == 2){
			if($command == ""){
				$this->data['status'] = "error";
				$this->data['error'] = "Введите команду!";
			}elseif($command != ""){
				if($server['game_code'] == "samp" || $server['game_code'] == "crmp") {
					$this->load->library('SampRconAPI');
					
					$cfg = file_get_contents('ftp://gs'.$server['server_id'].':'.$server['server_password'].'@'.$server['location_ip'].':21/server.cfg');
					$pass = explode("\n",$cfg);
					$pass = substr($pass[2], 14);
					
					$SampRcon = new SampRconAPI($server['location_ip'], $server['server_port'], $pass);
					if ($SampRcon->connect()) {
						$SampRcon->call($command, false);
						
						$this->data['status'] = "success";
						$this->data['success'] = "Команда успешно отправлена!";
					} else { 
						$this->data['status'] = "error";
						$this->data['error'] = "Ошибка подключения к rcon!";
					}
					$SampRcon->close();
				} else {					
					$ssh = new ssh2Library();
					$connect = $ssh->connect($server['location_ip'], $server['location_user'], $server['location_password']);
						$ssh->execute($connect, "su -lc \"screen -p 0 -r gameserver -X stuff '".$command."\\n'\" gs".$server['server_id']);
					$ssh->disconnect($connect);
					
					$this->data['status'] = "success";
					$this->data['success'] = "Команда успешно отправлена!";
				}
			}
		}else{
			$this->data['status'] = "error";
			$this->data['error'] = "Сервер должен быть включён!";
		}
		return json_encode($this->data);
	}
	
	public function clearcon($serverid = null) {
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
		
		$this->load->model('users');
		$this->load->model('servers');		
		$this->load->library('ssh2');
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$server = $this->serversModel->getServerById($serverid, array('games','locations'));	
					   
			if($server['server_status'] == 2) {
				$ssh2Lib = new ssh2Library();
				$link = $ssh2Lib->connect($server['location_ip'], $server['location_user'], $server['location_password']);
					if($server['game_query'] == 'samp') {				
						$output = $ssh2Lib->execute($link, "echo 'Console clear!' > /home/gs$serverid/server_log.txt;");
					}
					if($server['game_query'] == 'valve') {				
						$output = $ssh2Lib->execute($link, "echo 'Консоль успешно очищена!' > /home/gs$serverid/screenlog.0;");
					}
					if($server['game_code'] == 'mcpe') {				
						$output = $ssh2Lib->execute($link, "echo 'Консоль успешно очищена!' > /home/gs$serverid/server.log;");
					}
					if($server['game_code'] == 'mtasa') {				
						$output = $ssh2Lib->execute($link, "echo 'Консоль успешно очищена!' > /home/gs$serverid/screenlog.0;");
					}
				$ssh2Lib->disconnect($link);
				$this->data['status'] = "success";
				$this->data['success'] = "Консоль успешно очищена!";
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = "Сервер должен быть включен!";
			}
		}
		return json_encode($this->data);
	}
	
	public function action_theme_console($action = null) {
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

		switch($action) {
			case 'default': {	
					$name = 'color: white; background-color: black; font-family: Inconsolata; resize: none; min-height: 500px;';
					setcookie('data-theme-console',$name,time() + (86400 * 5), '/' );
					$this->data['status'] = "success";
					$this->data['success'] = "Тема установлена!";
				break;
			}
			case 'Amethyst': {	
					$name = 'color: #323e42; background-color: #a48ad4; font-family: Inconsolata; resize: none; min-height: 500px;';
					setcookie('data-theme-console',$name,time() + (86400 * 5), '/' );
					$this->data['status'] = "success";
					$this->data['success'] = "Тема установлена!";
				break;
			}
			case 'City': {	
					$name = 'color: #323e42; background-color: #ff6b6b; font-family: Inconsolata; resize: none; min-height: 500px;';
					setcookie('data-theme-console',$name,time() + (86400 * 5), '/' );
					$this->data['status'] = "success";
					$this->data['success'] = "Тема установлена!";
				break;
			}
			case 'Flat': {	
					$name = 'color: #323e42; background-color: #44b4a6; font-family: Inconsolata; resize: none; min-height: 500px;';
					setcookie('data-theme-console',$name,time() + (86400 * 5), '/' );
					$this->data['status'] = "success";
					$this->data['success'] = "Тема установлена!";
				break;
			}
			case 'Modern': {	
					$name = 'color: #323e42; background-color: #14adc4; font-family: Inconsolata; resize: none; min-height: 500px;';
					setcookie('data-theme-console',$name,time() + (86400 * 5), '/' );
					$this->data['status'] = "success";
					$this->data['success'] = "Тема установлена!";
				break;
			}
			case 'Smooth': {	
					$name = 'color: #323e42; background-color: #ff6c9d; font-family: Inconsolata; resize: none; min-height: 500px;';
					setcookie('data-theme-console',$name,time() + (86400 * 5), '/' );
					$this->data['status'] = "success";
					$this->data['success'] = "Тема установлена!";
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
		
		$result = null;
		return $result;
	}
}