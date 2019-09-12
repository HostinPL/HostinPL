<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class indexController extends Controller {
	private $limit = 20;
	public function index($page = 1) {
		$this->load->checkLicense();
		$this->document->setActiveSection('servers');
		$this->document->setActiveItem('index');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 0) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->library('pagination');
		$this->load->model('servers');
		$this->load->model('serversOwners');
		
		$userid = $this->user->getId();
		
		$options = array(
			'start' => ($page - 1) * $this->limit,
			'limit' => $this->limit
		);
		
		$this->data['servers'] = $servers = $this->serversModel->getServers(array('user_id' => (int)$userid), array('games', 'locations'), array(), $options);
		$this->data['serversOwners'] = $serversOwners = $this->serversOwnersModel->getOwners(array('servers_owners.user_id' => $userid), array('servers', 'games', 'locations'));
		
		$paginationLib = new paginationLibrary();
		
		$paginationLib->total = $this->serversModel->getTotalServers(array('user_id' => (int)$userid));
		$paginationLib->page = $page;
		$paginationLib->limit = $this->limit;
		$paginationLib->url = $this->config->url . 'servers/index/index/{page}';
		
		$this->data['pagination'] = $paginationLib->render();
		
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('servers/index', $this->data);
	}
	
	public function action($serverid = null, $action = null) {
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

		$this->load->model('servers');

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
//Место для логирования об запуске сервера
						$this->data['status'] = "success";
						$this->data['success'] = "Сервер запущен!";
					} else {
						$this->data['status'] = "error";
//Место для логирования об ошибке запуска сервера
						$this->data['error'] = $result['description'];
					}
				} else {
					$this->data['status'] = "error";
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
//Место для логирования об перезапуске сервера
						$this->data['success'] = "Сервер перезапущен!";
					} else {
						$this->data['status'] = "error";
//Место для логирования об ошибке перезапуск сервера
						$this->data['error'] = $result['description'];
					}
				} else {
					$this->data['status'] = "error";
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
//Место для логирования об остановке сервера
						$this->data['success'] = "Сервер выключен!";
					} else {
						$this->data['status'] = "error";
//Место для логирования об ошибке остановки сервера
						$this->data['error'] = $result['description'];
					}
				} else {
					$this->data['status'] = "error";
				    $this->data['error'] = "Сервер должен быть включен!";
				}
				break;
			}
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
}
?>
