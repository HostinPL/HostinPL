<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class controlController extends Controller {
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
  		$error = $this->validate($serverid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'servers/index');
		}
		
		$this->data['user_balance'] = $this->user->getBalance();
		
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
       //--
			$this->load->library('ssh2');
				
			$ssh = new ssh2Library();
			
			$ip = $server['location_ip'];
			$user = $server['location_user'];
			$pass = $server['location_password'];
			
			
			$connect = $ssh->connect($ip, $user, $pass);
			$output = $ssh->execute($connect, "cd /home/gs".$server['server_id']."/cstrike/maps/; ls | grep .bsp;");
			$disconnect = $ssh->disconnect($connect);
			$data = $output . $disconnect;
			$data = explode("\n", $data);
			
			$maps = '<option selected="selected" value="' . $query['mapname'] . '">' . $query['mapname'] . '</option>';
			
			foreach ($data as $map) {
				if (!preg_match('/\.(bsp.ztmp)/', $map)) {
					$map = str_replace(".bsp", "", $map);
					$maps .= '<option value="' . $map . '">' . $map . '</option>';
				}
			}
			$this->data['maps'] = $maps;
		}
		
		if($server['server_status'] == 3)
		{
			$this->serversModel->updateServer($serverid, array('server_install' => 2));
		}
		$stats = $this->serversStatsModel->getServerStats($serverid, "NOW() - INTERVAL 31 DAY", "NOW()");
		$this->data['stats'] = $stats;
		$this->load->model('games');
		$this->load->model('locations');
		$this->load->model('serverLog');
		$this->load->model('tickets');
		$this->load->model('ticketsMessages');
		$this->load->model('users');
		$logs = $this->serverLogModel->getLogs(array(),array('servers'),array(), $options);
		$games = $this->gamesModel->getGames(array('game_status' => 1));
		$locations = $this->locationsModel->getLocations(array('location_status' => 1));
		$rtickets = $this->ticketsModel->getTickets($getData, array('users'), $getSort, $getOptions);
		$total = $this->ticketsModel->getTotalTickets(array('user_id' => (int)$userid));
		$tickets = $this->ticketsModel->getTickets(array('user_id' => (int)$userid), array(), $sort, $options);
		$ticket = $this->ticketsModel->getTicketById($ticketid, array('users'));
		$messages = $this->ticketsMessagesModel->getTicketsMessages(array('ticket_id' => $ticketid), array('users'));
		$this->data['logs'] = $logs;
		$this->data['games'] = $games;
		$this->data['locations'] = $locations;
		$this->data['rtickets'] = $rtickets;
		$this->data['ticket'] = $ticket;
		$this->data['messages'] = $messages;
		$this->data['tickets'] = $tickets;
		$visitors = $this->usersModel->getAuthLog($userid);
		$this->data['visitors'] = $visitors;
		
		
		
		$this->data['portPrice'] = $portPrice = round($this->config->portPrice);
		$this->data['gameServerPorts'] = $gameServerPorts = $this->serversModel->getGameServerPortList($server['location_id'], $server['game_min_port'], $server['game_max_port']);

		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('servers/control', $this->data);
	}
	
	public function ajax_port($serverid = null) {
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
		$this->data['balance'] = $balance = $this->user->getBalance();
		$this->data['portPrice'] = $portPrice = round($this->config->portPrice);

		$this->load->model('users');
		$this->load->model('servers');
		$this->load->model('serversFirewalls');

		$gameServer = $this->serversModel->getServerById($serverid, array('games', 'locations'));
			
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$port = @(int)$this->request->post['port'];
						
			if($gameServer['server_status'] == 1){
				if($balance >= $portPrice){	
					if(!$this->serversFirewallsModel->getTotalFirewalls(array('server_id' => $serverid))){
						if(!$this->serversModel->getTotalServers(array('location_id' => $gameServer['location_id'], 'server_port' => $port))){
							$gameServerPorts = $this->serversModel->getGameServerPortList($gameServer['location_id'], $gameServer['game_min_port'], $gameServer['game_max_port']);
							
							if (in_array($port, $gameServerPorts)) {

								$this->serversModel->updateServer($serverid, array('server_port' => $port));
								$this->usersModel->downUserBalance($userid, $portPrice);
								
								$this->data['status'] = "success";
								$this->data['success'] = "Вы успешно сменили порт сервера на ".$port;
							} else {
								$this->data['status'] = 'error';
								$this->data['error'] = 'Выбранный порт не может быть использован!';
							}
						} else {
							$this->data['status'] = "error";
							$this->data['error'] = "Выбранный порт уже занят другим сервером!";
						}
					} else {
						$this->data['status'] = "error";
						$this->data['error'] = "Необходимо удалить все заблокированные IP адреса!";
					}
				} else {
					$this->data['status'] = "error";
					$this->data['error'] = "На Вашем счету не хватает ".(round($portPrice-$balance, 2))." руб";
				}
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = "Сервер должен быть выключен!";
			}
		}
		return json_encode($this->data);
	}
	
	
	
	public function changemap_go($serverid = null) {
		$this->document->setActiveSection('servers');
		$this->document->setActiveItem('control');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'news/index');
		}
		if($this->user->getAccessLevel() < 0) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->model('servers');
		
		$error = $this->validate($serverid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'servers/index');
		}
		
		$userid = $this->user->getId();
		
		$server = $this->serversModel->getServerById($serverid, array('games', 'locations'));

		if($server['server_status'] == 2){
			$this->load->library('ssh2');
			
			$ssh = new ssh2Library();
			
			$ip = $server['location_ip'];
			$user = $server['location_user'];
			$pass = $server['location_password'];
			
			
			$connect = $ssh->connect($ip, $user, $pass);
			$ssh->execute($connect, "su -lc \"screen -p 0 -r gameserver -X stuff ' changelevel ".$_POST['map']."\\n'\" gs".$server['server_id']);
			$ssh->disconnect($connect);
			$this->data['status'] = "success";
			$this->data['success'] = "Смена карты запущенна!";
		}else{
			$this->data['status'] = "error";
			$this->data['error'] = "Сервер должен быть включен!";
		}
		return json_encode($this->data);
	}
//Функция отправки запроса на смену карты (для valve серверов)
	public function deletelog($logid = null) {
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
		$this->load->model('serverLog');
		$this->serverLogModel->deleteLog($logid);
		$this->data['status'] = "success";
		$this->data['success'] = "Удалено!";
			return json_encode($this->data);
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
		$this->load->model('serverLog');
		$this->load->library('ssh2');
		$ssh2Lib = new ssh2Library();
		
		$error = $this->validate($serverid);
		if($error) {
			$this->data['status'] = "error";
			$this->data['error'] = $error;
			return json_encode($this->data);
		}
		
		$server = $this->serversModel->getServerById($serverid, array('users', 'locations', 'games'));		
		switch($action) {
			case 'start': {
				if($server['server_status'] == 1) {
					$result = $this->serversModel->execServerAction($serverid, 'start');
					if($result['status'] == "OK") {
						$this->serversModel->updateServer($serverid, array('server_status' => 2));
						$logData = array(
							'server_id'			=> $serverid,
							'reason'            => 'Успешный запуск сервера.',
							'status'            => 1
						);
                        $this->serverLogModel->createLog($logData);
						$this->data['status'] = "success";
						$this->data['success'] = "Вы успешно запустили сервер!";
					} else {
						$this->data['status'] = "error";
						$this->data['error'] = $result['description'];
					}
				} else {
					$this->data['status'] = "error";
																				$logData = array(
							'server_id'			=> $serverid,
							'reason'            => '[START] Сервер должен быть выключен!',
							'status'            => 3
						);
                        $this->serverLogModel->createLog($logData);
					$this->data['error'] = "Сервер должен быть выключен!";
				}
				break;
			}
			case 'reinstall': {
				if($server['server_status'] == 1) {
					//$result = $this->serversModel->execServerAction($serverid, 'reinstall');
					//if($result['status'] == "OK") {
						$this->serversModel->updateServer($serverid, array('server_status' => 4, 'server_install' => 2));
						$logData = array(
							'server_id'			=> $serverid,
							'reason'            => 'Сервер переустанавливается...',
							'status'            => 2
						);
                        $this->serverLogModel->createLog($logData);
						$this->data['status'] = "success";
						$this->data['success'] = "Сервер поставлен на переустановку!";
					/*} else {
						$this->data['status'] = "error";
						$this->data['error'] = $result['description'];
					}*/
				} else {
					$this->data['status'] = "error";
																				$logData = array(
							'server_id'			=> $serverid,
							'reason'            => '[ON] Сервер должен быть выключен!',
							'status'            => 3
						);
                        $this->serverLogModel->createLog($logData);
					$this->data['error'] = "Сервер должен быть выключен!";
				}
				break;
			}
			case 'restart': {
				if($server['server_status'] == 2) {
					$result = $this->serversModel->execServerAction($serverid, 'restart');
					if($result['status'] == "OK") {
						$this->serversModel->updateServer($serverid, array('server_status' => 2));
						$this->data['status'] = "success";
												$logData = array(
							'server_id'			=> $serverid,
							'reason'            => 'Успешный перезапуск сервера.',
							'status'            => 1
						);
                        $this->serverLogModel->createLog($logData);
						$this->data['success'] = "Вы успешно перезапустили сервер!";
					} else {
						$this->data['status'] = "error";
						$this->data['error'] = $result['description'];
					}
				} else {
					$this->data['status'] = "error";
																				$logData = array(
							'server_id'			=> $serverid,
							'reason'            => '[RESTART] Сервер должен быть выключен!',
							'status'            => 3
						);
                        $this->serverLogModel->createLog($logData);
					$this->data['error'] = "Сервер должен быть включен!";
				}
				break;
			}
			case 'stop': {
				if($server['server_status'] == 2) {
					$result = $this->serversModel->execServerAction($serverid, 'stop');
					if($result['status'] == "OK") {
						$this->serversModel->updateServer($serverid, array('server_status' => 1));
						$this->data['status'] = "success";
												$logData = array(
							'server_id'			=> $serverid,
							'reason'            => 'Успешное выключение сервера.',
							'status'            => 1
						);
                        $this->serverLogModel->createLog($logData);
						$this->data['success'] = "Вы успешно выключили сервер!";
					} else {
						$this->data['status'] = "error";
						$this->data['error'] = $result['description'];
					}
				} else {
					$this->data['status'] = "error";
						$logData = array(
							'server_id'			=> $serverid,
							'reason'            => '[OFF] Сервер должен быть включен!',
							'status'            => 3
						);
                        $this->serverLogModel->createLog($logData);
					$this->data['error'] = "Сервер должен быть включен!";
				}
				break;
			}
						case 'backup': {
				if($server['server_status'] == 1) {
					$link = $ssh2Lib->connect($server['location_ip'], $server['location_user'], $server['location_password']);
					$output = $ssh2Lib->execute($link, "cd /home/cp; sh ./backup.sh $serverid ".$server['db_pass']."");
                    $ssh2Lib->disconnect($link);
					$result = $this->serversModel->execServerAction($serverid, 'start');
					if($result['status'] == "OK") {
						$this->data['status'] = "success";
						$logData = array(
							'server_id'			=> $serverid,
							'reason'            => 'Успешный BackUP сервера.',
							'status'            => 1
						);
                        $this->serverLogModel->createLog($logData);
						$this->data['success'] = "Вы успешно сделали BackUP!";
					} else {
						$this->data['status'] = "error";
						$this->data['error'] = $result['description'];
					}
				} else {
					$this->data['status'] = "error";
						$logData = array(
							'server_id'			=> $serverid,
							'reason'            => '[BACKUP] Сервер должен быть выключен!',
							'status'            => 3
						);
                        $this->serverLogModel->createLog($logData);
					$this->data['error'] = "Сервер должен быть выключен!";
				}
				break;
			}
			default: {
				$this->data['status'] = "error";
						$logData = array(
							'server_id'			=> $serverid,
							'reason'            => 'Вы выбрали несуществующее действие!',
							'status'            => 3
						);
                        $this->serverLogModel->createLog($logData);
				$this->data['error'] = "Вы выбрали несуществующее действие!";
				break;
			}
		}
		
		return json_encode($this->data);
	}
	public function buy_months($serverid = null) {
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
		
		$this->load->model('waste');
		$this->load->model('users');
		$this->load->model('games');
		$this->load->model('servers');
		$this->load->model('serverLog');
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$months = @$this->request->post['months'];
			// $months = $this->request->post['months'];
			$userid = $this->user->getId();
			$balance = $this->user->getBalance();
			
			$server = $this->serversModel->getServerById($serverid, array('games'));
			
			$price = $server['server_slots'] * $server['game_price'];
					switch($months) {
						case "3":
							$months = 3;
							$price = $price * 0.95;
							break;
						case "6":
							$months = 6;
							$price = $price * 0.90;
							break;
						case "12":
							$months = 12;
							$price = $price * 0.85;
							break;
						default:
							$months = 1;
					}
			$price = $price * $months;
			if($balance >= $price) {
				if($server['server_status'] == 0) {
					$this->serversModel->updateServer($serverid, array('server_status' => 1));
					$this->serversModel->extendServer($serverid,$months,true);
				} else {
					$this->serversModel->extendServer($serverid,$months,false);
				}
				$this->usersModel->downUserBalance($userid, $price);
				$wasteData = array(
					'user_id'			=> $userid,
					'waste_ammount'	=> $price,
					'waste_status'	=> 1,
					'waste_usluga'	=> "Продление сервера gs$serverid на $months месяц(а/ев)"
				);
				$this->wasteModel->createWaste($wasteData);
				$this->usersModel->upUserRMoney($userid, 10.00);
				
				$this->data['status'] = "success";
				$logData = array(
							'server_id'			=> $serverid,
							'reason'            => 'Сервер успешно продлен!',
							'status'            => 1
						);
                        $this->serverLogModel->createLog($logData);
				$this->data['success'] = "Вы успешно оплатили сервер на $months месяцев.";
				$this->data['info'] = "Вам начислено 10 монет.";
			    } else {
				$this->data['status'] = "error";
				$logData = array(
							'server_id'			=> $serverid,
							'reason'            => '[PAY] На счету не достаточно средств!',
							'status'            => 3
						);
                $this->serverLogModel->createLog($logData);
				$this->data['error'] = "На Вашем счету недостаточно средств!";
			}
		}

				return json_encode($this->data);
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
		
		$this->load->model('waste');
		$this->load->model('users');
		$this->load->model('games');
		$this->load->model('servers');
				$this->load->model('serverLog');
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$slots = $this->request->post['slots'];
			$userid = $this->user->getId();
			$balance = $this->user->getBalance();

			$server = $this->serversModel->getServerById($serverid, array('games'));
			$price = $server['game_price'] * ($slots-$server['server_slots']);
			
			if($slots == $server['server_slots'])
			{
			$this->data['status'] = "success";
			$this->data['success'] = "Слоты не были изменены.";
            return json_encode($this->data);			
			}
			if($slots < $server['server_slots'])
			{
			$this->serversModel->slotsServer($serverid, $slots);	
			$this->data['status'] = "success";
			$logData = array(
							'server_id'			=> $serverid,
							'reason'            => 'Изменили на $slots слотов!',
							'status'            => 1
						);
            $this->serverLogModel->createLog($logData);
			$this->data['success'] = "Изменено количество слотов!";
            return json_encode($this->data);			
			}
			if($balance >= $price) {
				$this->serversModel->slotsServer($serverid, $slots);
				$this->usersModel->downUserBalance($userid, $price);
				$wasteData = array(
					'user_id'			=> $userid,
					'waste_ammount'	=> $price,
					'waste_status'	=> 1,
					'waste_usluga'	=> "Увеличено до $slots слотов для сервера gs$serverid"
				  ); 	
		        $this->wasteModel->createWaste($wasteData);
		        $this->usersModel->upUserRMoney($userid, 1.00);
				
				$this->data['status'] = "success";
				$logData = array(
							'server_id'			=> $serverid,
							'reason'            => 'Изменено количество слотов.',
							'status'            => 1
						);
                $this->serverLogModel->createLog($logData);
				$this->data['success'] = "Установлено $slots слотов! (- $price руб.)";
				$this->data['info'] = "Вам начислено 10 монет.";
			    } else {
				$this->data['status'] = "error";
				$logData = array(
							'server_id'			=> $serverid,
							'reason'            => '[SLOTS] Не достаточно средств!',
							'status'            => 3
						);
                $this->serverLogModel->createLog($logData);
				$this->data['error'] = "На Вашем счету недостаточно средств!";
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
	
	private function validatePOST() {
		$this->load->checkLicense();
		$this->load->library('validate');
		
		$validateLib = new validateLibrary();
		
		$result = null;
		
		$editpassword = @$this->request->post['editpassword'];
		$password = @$this->request->post['password'];
		$password2 = @$this->request->post['password2'];
		
		if($editpassword) {
			if(!$validateLib->password($password)) {
				$result = "Пароль должен содержать от 6 до 32 латинских букв, цифр и знаков <i>,.!?_-</i>!";
			}
			elseif($password != $password2) {
				$result = "Введенные вами пароли не совпадают!";
			}
		}
		return $result;
	}
}
?>
