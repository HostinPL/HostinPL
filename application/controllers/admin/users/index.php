<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class indexController extends Controller {
	private $limit = 20;
	public function index($page = 1) {
		$this->document->setActiveSection('admin');
		$this->document->setActiveItem('users');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 2) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->library('pagination');
		$this->load->model('users');
		
		$options = array(
			'start' => ($page - 1) * $this->limit,
			'limit' => $this->limit
		);
		
		$total = $this->usersModel->getTotalUsers();
		$users = $this->usersModel->getUsers(array(), array(), $options);
		
		$paginationLib = new paginationLibrary();
		
		$paginationLib->total = $total;
		$paginationLib->page = $page;
		$paginationLib->limit = $this->limit;
		$paginationLib->url = $this->config->url . 'admin/users/index/index/{page}';
		
		$pagination = $paginationLib->render();
		
		$this->data['users'] = $users;
		$this->data['pagination'] = $pagination;
		
		$this->getChild(array('common/admheader', 'common/footer'));
		return $this->load->view('admin/users/index', $this->data);
	}
	
	
	
	public function ajax() {
		$this->load->checkLicense();
		if(!$this->user->isLogged()) {  
	  		$this->data['status'] = "error";
			$this->data['error'] = "Вы не авторизированы!";
			return json_encode($this->data);
		}
		if($this->user->getAccessLevel() < 3) {
			$this->data['status'] = "error";
			$this->data['error'] = "У вас нет доступа к данному функции!";
			return json_encode($this->data);
		}
		
		$this->load->model('users');
		$this->load->model('news');
		$users = $this->usersModel->getUsers(array(), array(), array());
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST();
			if(!$errorPOST) {
				$minsum = @$this->request->post['minsum'];
				$maxsum = @$this->request->post['maxsum'];
				$typesum = @$this->request->post['typesum'];
				$oneuser = @$this->request->post['oneuser'];
				$oneuserID = @$this->request->post['oneuserID'];
				$createnews = @$this->request->post['createnews'];
				
				if($typesum) {
					if($oneuser) {
						$rsum = rand($minsum, $maxsum);
						
						$this->usersModel->upUserBalance($oneuserID, $rsum);
						
						$this->data['status'] = "info";
						$this->data['info'] = "".$rsum." - Реальные деньги выданы пользователю!";
					} else {
						if($createnews) {
							foreach($users as $item) {
								if($item['user_status'] == 1) {
									$userid = $item['user_id'];
									$rsum = rand($minsum, $maxsum);
									$this->usersModel->upUserBalance($oneuserID, $rsum);		
								}
							}
							if(empty($users)) {
								$this->data['status'] = "error";
								$this->data['error'] = "Критическая ошибка";
							}
							
							$today = date("Y-m-d H:i");

							$name = "Выдача бонусных монет всем )";
							$text = "Сегодня ".$today." администрацией была проведена раздача реальных денег, их получили все активированные пользователи! ";
							$category = "1";
							$img_preview = "1";
							$userid = $this->user->getId();
							
							$newsData = array(
								'user_id'			=> $userid,
								'news_title'		=> $name,
								'news_text'			=> $text,
								'category_id'		=> $category,
								'place'		=> $place
							);
							$this->newsModel->createNews($newsData);
							
						
							$this->data['status'] = "success";
							$this->data['success'] = "Реальные деньги выданы!";
						} else {
							foreach($users as $item) {
								if($item['user_status'] == 1) {
									$userid = $item['user_id'];
									$rsum = rand($minsum, $maxsum);
									$this->usersModel->upUserBalance($oneuserID, $rsum);		
								}
							}
							if(empty($users)) {
								$this->data['status'] = "error";
								$this->data['error'] = "Критическая ошибка";
							}	
							$this->data['status'] = "success";
							$this->data['success'] = "Реальные деньги выданы!";
						}
					}
				} else {	
					if($oneuser) {
						$rsum = rand($minsum, $maxsum);
						$this->usersModel->upUserRMoney($oneuserID, $rsum);
						
						$this->data['status'] = "info";
						$this->data['info'] = "".$rsum." - Бонусные монеты выданы пользователю!";
					} else {
						if($createnews) {
							foreach($users as $item) {
								if($item['user_status'] == 1) {
									$userid = $item['user_id'];
									$rsum = rand($minsum, $maxsum);
									$this->usersModel->upUserRMoney($userid, $rsum);		
								}
							}
							if(empty($users)) {
								$this->data['status'] = "error";
								$this->data['error'] = "Критическая ошибка";
							}
							
							
							$today = date("Y-m-d H:i");

							$name = "Выдача бонусных монет всем )";
							$text = "Сегодня ".$today." администрацией была проведена раздача бонусных монет, их получили все активированные пользователи! ";
							$category = "1";
							$place = "1";
							$userid = $this->user->getId();
							
							$newsData = array(
								'user_id'			=> $userid,
								'news_title'		=> $name,
								'news_text'			=> $text,
								'category_id'		=> $category,
								'place'				=> $place
							);
							$this->newsModel->createNews($newsData);
						
							$this->data['status'] = "success";
							$this->data['success'] = "Бонусные монеты выданы!";
						} else {
							foreach($users as $item) {
								if($item['user_status'] == 1) {
									$userid = $item['user_id'];
									$rsum = rand($minsum, $maxsum);
									$this->usersModel->upUserRMoney($userid, $rsum);		
								}
							}
							if(empty($users)) {
								$this->data['status'] = "error";
								$this->data['error'] = "Критическая ошибка";
							}
						
							$this->data['status'] = "success";
							$this->data['success'] = "Бонусные монеты выданы!";
						}
					}
				}
				// Сюда можно логирование
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
		
		$minsum = @$this->request->post['minsum'];
		$maxsum = @$this->request->post['maxsum'];
		$oneuser = @$this->request->post['oneuser'];
		$oneuserID = @$this->request->post['oneuserID'];
		
		if(!$validateLib->money($maxsum)) {
			$result = "Укажите сумму в допустимом формате!";
		}
		elseif(1 > $minsum || $minsum > 5000) {
			$result = "Укажите сумму от 1 до 5000";
		}
		
		if($oneuser) {
			if(!$this->usersModel->getTotalUsers(array('user_id' => (int)$oneuserID))) {
				$result = "Запрашиваемый пользователь не существует!";
			}
		}
		 
		return $result;
	}
}
?>
