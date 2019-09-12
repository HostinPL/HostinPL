<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class loginController extends Controller {
	private $limit = 6;
	public function index($page = 1) {
		$this->load->checkLicense();
		$this->document->setActiveSection('account');
		$this->document->setActiveItem('login');
		$this->data['recaptcha'] = $this->config->recaptcha;
		
		if($this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url);
		}
		$this->load->library('pagination');
        $this->load->model('news');
		$sort = array(
			//'ticket_status'		=> 'DESC',
			'news_date_add'	=> 'DESC'
		);
		
		$options = array(
			'start'		=>	($page - 1) * $this->limit,
			'limit'		=>	$this->limit
		);
		
		$total = $this->newsModel->getTotalNews();
		$tickets = $this->newsModel->getNews(array(), array(), $sort, $options);
		
		$paginationLib = new paginationLibrary();
		
		$paginationLib->total = $total;
		$paginationLib->page = $page;
		$paginationLib->limit = $this->limit;
		$paginationLib->url = $this->config->url . '/account/login/index/{page}';
		
		$pagination = $paginationLib->render();
		
		$this->data['tickets'] = $tickets;
		$this->data['pagination'] = $pagination;
		$this->getChild(array('common/loginheader', 'common/loginfooter'));
		return $this->load->view('account/login', $this->data);
	}
	
	//Авторизация через вк	
	public function vk() {
		if($this->user->isLogged()) {
	  		$this->data['status'] = "error";
			$this->data['error'] = "Вы уже авторизированы!";
			return json_encode($this->data);
		}

		$this->load->model('users');
		$userid = $this->user->getId();
   
        if($this->request->post['auth']){
			$id = $this->request->post['response']['session']['user']['id'];

			if($u = $this->usersModel->getUserByUser_vk_id($id, "user_vk_id")){
				$this->session->data['user_id'] = $u['user_id'];
				$this->data['status'] = "success";
				$this->data['success'] = "Вы успешно авторизировались!";
			} else {
				$this->session->data['auth_vk'] = $id;
				$this->data['status'] = "auth_error";
				$this->data['auth_error'] = "Внутренняя ошибка!(Либо не привязана учётка)";
			}
			return json_encode($this->data);
		}
		
		if($this->request->post['auth_vk']) {
			if($user = @file_get_contents("https://api.vk.com/method/users.get?uids={$this->session->data['auth_vk']}&fields=uid,first_name,last_name,screen_name,sex,bdate,photo_big"))
			$this->data['user'] = json_decode($user, true);
			$email = @$this->request->post['email'];
			$password = @$this->request->post['password'];
		}
		return json_encode($this->data);
	}
	
	public function ajax() {
		$this->load->model('users');
		$this->load->checkLicense();
		if($this->user->isLogged()) {  
	  		$this->data['status'] = "error";
			$this->data['error'] = "Вы не авторизированы!";
			return json_encode($this->data);
		}
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST();
			if(!$errorPOST) {
				$email = @$this->request->post['email'];
				$password = @$this->request->post['password'];
				
				$user = @$this->usersModel->getUserByEmail($email);
				if($user and $user['user_activate'] !== '1'){											
					$this->data['status'] = "error";
					$this->data['error'] = "Данный аккаунт не активирован!";
					return json_encode($this->data);
				}
				if($this->user->login($email, $password)) {
					

					$userid=$this->usersModel->getIdByEmail($email);$ip=$this->request->server['REMOTE_ADDR'];
					$this->usersModel->createAuthLog($userid['user_id'],$ip,'1',$password);
					$this->data['status'] = "success";
					$this->data['success'] = "Вы успешно вошли!";
				} else {
					
					$userid=$this->usersModel->getIdByEmail($email);$ip=$this->request->server['REMOTE_ADDR'];
					$this->usersModel->createAuthLog($userid['user_id'],$ip,'0',$password);
					
					$this->data['status'] = "error";
					$this->data['error'] = "Вы ввели не верный логин или пароль!";
				}
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			}
			
		}else{
			$this->data['status'] = "error";
			$this->data['error'] = "Не POST запрос";
		}

		return json_encode($this->data);
	}
	
	private function validatePOST() {
	
		$this->load->library('validate');
		
		$validateLib = new validateLibrary();
		
		$result = null;
		
		$email = @$this->request->post['email'];
		$password = @$this->request->post['password'];
		$recaptcha = @$this->request->post['g-recaptcha-response'];
		
		if(!$validateLib->email($email)) {
			$result = "Укажите свой реальный E-Mail!";
		}
		elseif(!$validateLib->password($password)) {
			$result = "Пароль должен содержать от 6 до 32 латинских букв, цифр и знаков <i>,.!?_-</i>!";
		}
		elseif(!$recaptcha) {
			$recaptcha = @$this->request->post['g-recaptcha-response'];	
			
			if(!$recaptcha) return 'Подтвердите, что вы не робот!';
			$url = 'https://www.google.com/recaptcha/api/siteverify';			
			$data = array('secret' => $this->config->secret_recaptcha, 'response' => $recaptcha);
			$options = array(
				'http' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'POST',
				'remoteip'  => 'remoteip',
				'content' => http_build_query($data),
				)
			);

			$context  = stream_context_create($options);
			$recaptcha_get = json_decode(file_get_contents($url, false, $context))->{'success'}; 	
			if($recaptcha_get != '1') return 'Проверьте правильность капчи!';
		}	
		return $result;
	}
}
?>
