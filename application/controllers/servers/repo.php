<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class repoController extends Controller {
	public function index($serverid = null) {
		$this->load->checkLicense();
		$this->data['title'] = $this->config->title;
		$this->data['description'] = $this->config->description;
		$this->data['keywords'] = $this->config->keywords;
		$this->data['logo'] = $this->config->logo;
		$this->data['url'] = $this->config->url;
		$this->data['public'] = $this->config->public;
		$this->data['webhosting'] = $this->config->webhosting;
		$this->data['styles'] = $this->config->styles;
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 0) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		$this->data['logged'] = true;
		$this->data['user_email'] = $this->user->getEmail();
		$this->data['user_firstname'] = $this->user->getFirstname();
		$this->data['user_lastname'] = $this->user->getLastname();
		$this->data['user_balance'] = $this->user->getBalance();
		$this->data['user_access_level'] = $this->user->getAccessLevel();
		$this->data['user_img'] = $this->user->getUser_img();
		
		$this->load->model('servers');
		$this->load->model('adaps');
		$this->load->model('tickets');
		$this->load->model('ticketsMessages');
		$this->load->model('users');

		$error = $this->validate($serverid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'servers/index');
		}
		
		$getData = array('adap_status' => 1);
		if(isset($this->request->get['systemid'])) {
			$getData['adap_act'] = (int)$this->request->get['systemid'];
		}

		$userid = $this->user->getId();
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
		$this->data['server'] = $server = $this->serversModel->getServerById($serverid, array('games', 'locations'));
		$total = $this->adapsModel->getTotalAdaps($getData);
		$this->data['adaps'] = $adaps = $this->adapsModel->getAdaps($getData, array('games'), array(), array());
		
		$this->getChild(array('common/footer'));
		return $this->load->view('servers/repo', $this->data);
	}
	
	public function actionrepos($serverid = null, $action = null) {
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
		$balance = $this->user->getBalance();
		//Подгрузка моделей
		$this->load->model('servers');
		$this->load->library('ssh2');
		$this->load->model('adaps');
		$this->load->model('users');
		//Проверка на наличие такого ид сервера
		$error = $this->validate($serverid);
		if($error) {
			$this->data['status'] = "error";
			$this->data['error'] = $error;
			return json_encode($this->data);
		}
		//Узнаём параметры сервера а так же по его ид его локацию игру и пользователя
		$server = $this->serversModel->getServerById($serverid, array('users', 'locations', 'games'));
		//Выводим весь список дополнений
		$adaps = $this->adapsModel->getAdaps(array(),array('games'),array(), $options);
		//Новый класс
		$ssh = new ssh2Library();
		//Конект ssh к машине
		$connect = $ssh->connect($server['location_ip'], $server['location_user'], $server['location_password']);
		//Парсим все дополнения
		foreach($adaps as $item){
			//Говорим что нужно делать с ид 
			if($action == $item['adap_id']) {
				//Проверяем статус сервера
				if($server['server_status'] == 1) {
					//Проверяем платный ли дополнение
					if($item['adap_category'] == 1) {
						//Проверка на достаточный баланс пользователя
						if($balance >= $item['adap_price']) {
							//Забераем сумму за установку
							$this->usersModel->downUserBalance($userid, $item['adap_patch']);
							//Проверяем не сборка ли это ?)
							if($item['adap_act'] == 4) {
								//Выполнение установки массив
								$cmd = "cd /home/gs".$server['server_id']."; ls | xargs rm -rf;";
								$cmd .= "cd /home/gs".$server['server_id'].";";
								$cmd .= "screen -AmdSL repo_wget".$server['server_id']." wget ".$item['adap_url'].";";
								//Отправка почти массива
								$ssh->execute($connect, $cmd);
								//Закрываем соединение 
								$ssh->disconnect($connect);
								//Выставляем права для cron
								$this->serversModel->updateServer($serverid, array(
									'server_status' => 7,
									'repozitory_item' => $item['adap_arch'],
									'server_install' => 1
								));
								//Вывод лога
								$this->data['status'] = "success";
								$this->data['success'] = "Сборка ".$item['adap_name']." поставлена на установку, с вашего счёта снято ".$item['adap_price']." р!";
							//Если не сборка то обычная установка
							} else {
								//Выполнение установки массив
								$cmd = "cd /home/gs".$server['server_id']."".$item['adap_patch'].";";
								$cmd .= "wget ".$item['adap_url'].";";
								$cmd .= "unzip ".$item['adap_arch'].";";
								$cmd .= "rm ".$item['adap_arch'].";";
								
								$cmd .= "cd /home/;chmod 777 -R /home/gs" . $server['server_id'] . "".$item['adap_patch'].";";
								$cmd .= "sudo chown -R gs" . $server['server_id'] . ":gameservers /home/gs" . $server['server_id'] . "".$item['adap_patch'].";";
								//Отправка почти массива
								$ssh->execute($connect, $cmd);
								//Закрываем соединение 
								$ssh->disconnect($connect);
								//Вывод лога
								$this->data['status'] = "success";
								$this->data['success'] = "Вы успешно установили ".$item['adap_name']." с вашего счёта снято ".$item['adap_price']." р!";
							}
						//Если баланс не достаточный
						} else {
							//Лог 
							$this->data['status'] = "error";
							$this->data['error'] = "На Вашем счету недостаточно средств!";
						}
					//Если дополнение бесплатно
					} else {
						//Проверяем не сборка ли это ?)
						if($item['adap_act'] == 4) {
							//Выполнение установки массив
							$cmd = "cd /home/gs".$server['server_id']."; ls | xargs rm -rf;";
							$cmd .= "cd /home/gs".$server['server_id'].";";
							$cmd .= "screen -AmdSL install_".$server['server_id']." wget ".$item['adap_url'].";";
							//Отправка почти массива
							$ssh->execute($connect, $cmd);
							//Закрываем соединение 
							$ssh->disconnect($connect);
							//Выставляем права для cron
							$this->serversModel->updateServer($serverid, array(
								'server_status' => 7,
								'repozitory_item' => $item['adap_arch'],
								'server_install' => 1
							));
							//Вывод лога
							$this->data['status'] = "success";
							$this->data['success'] = "Сборка ".$item['adap_name']." поставлена на установку, с вашего счёта снято ".$item['adap_price']." р!";
						//Если не сборка то обычная установка
						} else {
							//Выполнение установки массив
							$cmd = "cd /home/gs".$server['server_id']."".$item['adap_patch'].";";
							$cmd .= "wget ".$item['adap_url'].";";
							$cmd .= "unzip ".$item['adap_arch'].";";
							$cmd .= "rm ".$item['adap_arch'].";";
							
							$cmd .= "cd /home/;chmod 777 -R /home/gs" . $server['server_id'] . "".$item['adap_patch'].";";
							$cmd .= "sudo chown -R gs" . $server['server_id'] . ":gameservers /home/gs" . $server['server_id'] . "".$item['adap_patch'].";";
							//Отправка почти массива
							$ssh->execute($connect, $cmd);
							//Закрываем соединение 
							$ssh->disconnect($connect);
							//Вывод лога
							$this->data['status'] = "success";
							$this->data['success'] = "Вы успешно установили ".$item['adap_name']." с вашего счёта снято ".$item['adap_price']." р!";
						}
						//Вывод лога
						$this->data['status'] = "success";
						$this->data['success'] = "Вы успешно установили ".$item['adap_name']."!";
					}
				//Если сервер включен
				} else {
					$this->data['status'] = "error";
					$this->data['error'] = "Сервер должен быть выключен!";
			    }
            }
		}
		//Отправка в закодированном виде логов 
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