<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class orderController extends Controller {
	public function index() {
		$this->load->checkLicense();
		$this->data['serv_test'] = $this->config->serv_test;
		$this->document->setActiveSection('servers');
		$this->document->setActiveItem('order');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 0) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->model('games');
		$this->load->model('locations');
		
		$games = $this->gamesModel->getGames(array('game_status' => 1));
		$locations = $this->locationsModel->getLocations(array('location_status' => 1));
		
		$this->data['games'] = $games;
		$this->data['locations'] = $locations;
		
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('servers/order', $this->data);
	}
	
	public function promo() {
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
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$code = $this->request->post['code'];
			$skidka = $this->usersModel->getSkidkaByCode($code, false);
			$kofficent=(100-$skidka['skidka'])/100;
			if($skidka['skidka'] == NULL){
				$this->data['status'] = "error";
				$this->data['error'] = "Данного кода не существует";
			}else{
				$this->data['status'] = "success";
				$this->data['success'] = "Вы активировали скидку ".$skidka['skidka']."%";
				$this->data['skidka'] = $kofficent;
			}
		}

		return json_encode($this->data);
	}
	
		public function ajax() {
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
		$this->load->model('locations');
		$this->load->model('servers');

		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST();
			if(!$errorPOST) {
				$gameid = $this->request->post['gameid'];
				$locationid = $this->request->post['locationid'];
				$slots = $this->request->post['slots'];
				$months = $this->request->post['months'];
				$password = $this->request->post['password'];

				$userid = $this->user->getId();
				$balance = $this->user->getBalance();
				$firstname = $this->user->getFirstname();
				$lastname = $this->user->getLastname();
				$email = $this->user->getEmail();
				$test_server = $this->user->getTest_server();

				$game = $this->gamesModel->getGameById($gameid);
				$port = $this->serversModel->getServerNewPort($locationid, $game['game_min_port'], $game['game_max_port']);
				$user = $this->usersModel->getUserById($userid, array(), array(), $options);
				$code = $this->request->post['promo'];
				$skidka = $this->usersModel->getSkidkaByCode($code,true);$kofficent=(100-$skidka['skidka'])/100;
				if($port) {
					$price = $slots * $game['game_price'];
				
					switch($months) {
						case "0":
							$test_periud = true;
						break;
						case "1":
						    $months = 1;
							$test_periud = false;
							break;
						case "3":
							$months = 3;
							$price = $price * 0.95;
							$test_periud = false;
							break;
						case "6":
							$months = 6;
							$price = $price * 0.90;
							$test_periud = false;
							break;
						case "12":
							$months = 12;
							$price = $price * 0.85;
							$test_periud = false;
							break;
						default:
							$months = 1;
							$test_periud = false;
					}
				
					$price = $price * $months;
					if($test_periud == true){
						$balance_servers = $game['game_price'] * $slots;
						if($test_server == 1){
						$serverData = array(
							'user_id'			=> $userid,
							'game_id'			=> $gameid,
							'location_id'		=> $locationid,
							'server_mysql'			=> 0,
							'server_slots'		=> $slots,
							'server_port'		=> $port,
							'server_password'	=> $password,
							'server_status'		=> 3,
							'test_periud'		=> $test_periud,
							'server_months'		=> $months
						);
					
						$serverid = $this->serversModel->createServer($serverData);
						$this->usersModel->downUserBalance($userid, $price);
						$wasteData = array(
						  'user_id'			=> $userid,
						  'waste_ammount'	=> $price,
						  'waste_status'	=> 1,
						  'waste_usluga'	=> "Заказ сервера gs$serverid"
					    ); 
				        $this->wasteModel->createWaste($wasteData);
						$getpref = $price - (70 / 100 * $price);
						$this->usersModel->upUserBalance($user['ref'], $getpref);
				        $this->usersModel->upUserRMoney($user['ref'], $getpref);
				    
						$this->data['status'] = "success";
						$this->data['success'] = "Сервер поставлен в очередь на установку.";
						$this->data['id'] = $serverid;
						} else {
							$this->data['status'] = "error";
							$this->data['error'] = "Вы уже брали тестовый период, либо у вас нет одобрения администратора!";
						}
					}elseif($balance >= $price AND $test_periud == false) {
						$serverData = array(
							'user_id'			=> $userid,
							'game_id'			=> $gameid,
							'location_id'		=> $locationid,
							'server_mysql'			=> 0,
							'server_slots'		=> $slots,
							'server_port'		=> $port,
							'server_password'	=> $password,
							'server_status'		=> 3,
							'test_periud'		=> $test_periud,
							'server_months'		=> $months
						);
					
						$serverid = $this->serversModel->createServer($serverData);
						$this->usersModel->downUserBalance($userid, $price);
						$wasteData = array(
						  'user_id'			=> $userid,
						  'waste_ammount'	=> $price,
						  'waste_status'	=> 1,
						  'waste_usluga'	=> "Заказ сервера gs$serverid"
					    ); 
				        $this->wasteModel->createWaste($wasteData);
						$getpref = $price - (70 / 100 * $price);
						$this->usersModel->upUserBalance($user['ref'], $getpref);
				        $this->usersModel->upUserRMoney($user['ref'], $getpref);
						
						$this->usersModel->upUserRMoney($userid, 10.00);
						$this->data['status'] = "success";
						$this->data['success'] = "Сервер поставлен в очередь на установку.";
						$this->data['info'] = "Вам начислено 10 монет";
						$this->data['id'] = $serverid;		
					} else {
						$this->data['status'] = "error";
						$this->data['error'] = "На Вашем счету недостаточно средств";
					}
				} else {
					$this->data['status'] = "error";
					$this->data['error'] = "На выбранной Вами локации нет свободных портов для данной игры";
				}
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			}
		}

		return json_encode($this->data);
	}
	
	public function ajaxD() {
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
		$this->load->model('locations');
		$this->load->model('servers');
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST();
			if(!$errorPOST) {
				$gameid = $this->request->post['gameid'];
				$locationid = $this->request->post['locationid'];
				$slots = $this->request->post['slots'];
				$months = $this->request->post['months'];
				$password = $this->request->post['password'];
	
				
				$userid = $this->user->getId();
				$balance = $this->user->getBalance();
				
				$game = $this->gamesModel->getGameById($gameid);
				$port = $this->serversModel->getServerNewPort($locationid, $game['game_min_port'], $game['game_max_port']);
				$user = $this->usersModel->getUserById($userid, array(), array(), $options);
				$code = $this->request->post['promo'];
				$skidka = $this->usersModel->getSkidkaByCode($code,true);$kofficent=(100-$skidka['skidka'])/100;
				if($port) {
					$price = $slots * $game['game_price'];
				
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
				
					if($skidka['skidka'] != NULL){
						$price = $price * $kofficent;
					}
				
					if($balance >= $price) {
						$serverData = array(
							'user_id'			=> $userid,
							'game_id'			=> $gameid,
							'location_id'		=> $locationid,
							'server_mysql'			=> 0,
							'server_slots'		=> $slots,
							'server_port'		=> $port,
							'server_password'	=> $password,
							'server_status'		=> 3,
							'server_months'		=> $months
						);
					
						$serverid = $this->serversModel->createServer($serverData);
						$this->usersModel->downUserBalance($userid, $price);
						$wasteData = array(
					  'user_id'			=> $userid,
					  'waste_ammount'	=> $price,
					  'waste_status'	=> 1,
					  'waste_usluga'	=> "Заказ сервера gs$serverid"
				  ); 
				     $this->wasteModel->createWaste($wasteData);
						$getpref = $price - (70 / 100 * $price);
						$this->usersModel->upUserBalance($user['ref'], $getpref);
				        $this->usersModel->upUserRMoney($user['ref'], $getpref);
				        $this->usersModel->upUserRMoney($userid, 10.00);
						$this->data['status'] = "success";
						$this->data['success'] = "Сервер поставлен в очередь на установку.";
						$this->data['id'] = $serverid;						
					} else {
						$this->data['status'] = "error";
						$this->data['error'] = "На Вашем счету недостаточно средств!";
					}
				} else {
					$this->data['status'] = "error";
					$this->data['error'] = "На выбранной Вами локации нет свободных портов для данной игры!";
				}
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			}
		}

		return json_encode($this->data);
	}
	
	private function validatePOST() {
		$this->load->checkLicense();
		$this->load->library('validate');
		
		$validateLib = new validateLibrary();
		
		$result = null;
		
		$gameid = @$this->request->post['gameid'];
		$locationid = @$this->request->post['locationid'];
		$slots = @$this->request->post['slots'];
		$months = @$this->request->post['months'];
		$password = @$this->request->post['password'];
		$password2 = @$this->request->post['password2'];
		
		if(!$this->gamesModel->getTotalGames(array('game_id' => (int)$gameid, 'game_status' => 1))) {
			$result = "Вы указали несуществующую игру!";
		}
		elseif(!$this->locationsModel->getTotalLocations(array('location_id' => (int)$locationid, 'location_status' => 1))) {
			$result = "Вы указали несуществующую локацию!";
		}
		elseif(!$this->gamesModel->validateSlots($gameid, $slots)) {
			$result = "Вы указали недопустимое количество слотов!";
		}
		elseif(!$validateLib->password($password)) {
			$result = "Пароль должен содержать от 6 до 32 латинских букв, цифр и знаков <i>,.!?_-</i>!";
		}
		elseif($password != $password2) {
			$result = "Введенные вами пароли не совпадают!";
		}
		return $result;
	}
}
?>
