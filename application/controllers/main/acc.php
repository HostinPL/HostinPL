<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class accController extends Controller {
	public function index() {
		$this->load->checkLicense();
		$this->data['vk_id'] = $this->config->vk_id;
		$this->data['url'] = $this->config->url;
		if(!$this->user->isLogged()) {
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 0) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->library('pagination');
		$this->load->model('waste');
		$this->load->model('invoices');
		$this->load->model('servers');
		$this->load->model('tickets');
		$this->load->model('users');

		$userid = $this->user->getId();

		$getOptions = array(
			'start' => ($page - 1) * $this->limit,
			'limit' => $this->limit
		);

		$hostin = array(
			'waste_date_add'	=> 'DESC'
		);

		$pl = array(
			'start' => ($page - 1) * $this->limit,
			'limit' => 10
		);
		
		$total = $this->wasteModel->getTotalWaste($getData);
		$waste = $this->wasteModel->getWaste(array('user_id' => (int)$userid), array(), $hostin, $pl);
		
		$this->data['waste'] = $waste;
		$this->data['pagination'] = $pagination;

		$sort = array(
			'invoice_status'	=> 'DESC',
			'invoice_id'	=> 'DESC'
		);
		$getOptions = array(
			'start' => ($page - 1) * $this->limit,
			'limit' => $this->limit
		);
		
		$total = $this->invoicesModel->getTotalInvoices(array('user_id' => (int)$userid));
		$invoices = $this->invoicesModel->getInvoices(array('user_id' => (int)$userid), array(), $sort, $getOptions);

		$this->data['invoices'] = $invoices;
		$this->data['pagination'] = $pagination;
		$this->data['user_balance'] = $this->user->getBalance();

		$this->data['logged'] = true;
		$this->data['user_email'] = $this->user->getEmail();
		$this->data['user_id'] = $userid;
		$this->data['user_firstname'] = $this->user->getFirstname();
		$this->data['user_lastname'] = $this->user->getLastname();
		$this->data['user_balance'] = $this->user->getBalance();
		$this->data['user_img'] = $this->user->getUser_img();
		$ticketsSort = array(
			'ticket_status'		=> 'DESC',
			'ticket_date_add'	=> 'DESC'
		);
	    $userData = array(
			'firstname' => $this->user->getFirstname(),
			'lastname' => $this->user->getLastname(),
			'user_email' => $this->user->getEmail()			
		);
		$options = array(
			'start' => 0,
			'limit' => 100
		);

		
		$this->data['user'] = $userData;
		$users = $this->usersModel->getUserById($userid, array(), array(), $options);
		$this->data['users'] = $users;
		$servers = $this->serversModel->getServers(array('user_id' => (int)$userid), array('games', 'locations'), array(), $options);
		$tickets = $this->ticketsModel->getTickets(array('user_id' => (int)$userid), array(), $ticketsSort, $options);
		$userg = $this->usersModel->getUsers(array('servers'), array(), array());
		$visitors = $this->usersModel->getAuthLog($userid);
		$this->data['visitors'] = $visitors;
		$this->data['servers'] = $servers;
		$this->data['tickets'] = $tickets;
		$this->data['userg'] = $userg;
		$row['date'] = strtotime($users['user_date_reg']); 
        $now = time(); 
        $seconds = $now - $row['date']; 
        $days = floor($seconds / (24*60*60)); 

        $this->data['user_date_reg'] = $days; 

        $res = $this->pluralForm($days, 'день', 'дней', 'дня'); 
        $this->data['user_date'] = $res;
		
		
		
		
		$this->data['userid'] = $userid = $this->user->getId();
		$this->data['gameservers'] = $this->serversModel->getServers(array('user_id' => (int)$userid, 'server_status' => 0), array('games', 'locations'));
		
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('main/acc', $this->data);
	}
	
	public function action($action = null, $metod = null, $serverid = null) {
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
		$this->load->model('users');
		
		switch($action) {
			case 'promised': {
					switch($metod) {
						case 'gameserver': {	
							if($users['user_promised_pay'] == 0){
								$this->usersModel->updateUser($userid, array('user_promised_pay' => 1));
								$this->serversModel->promisedServer($serverid);
								$this->usersModel->downUserBalance($userid, $sum = "15");
																
								$this->data['status'] = "success";
								$this->data['success'] = "Вы активирали обещаный платёж!";
							} else {
								$this->data['status'] = "error";
								$this->data['error'] = "На данный момент Вам недоуступна данная функция!";
							}
							break;
						}
						default: {
							$this->data['status'] = "error";
							$this->data['error'] = "Вы выбрали несуществующее действие!";
							break;
						}
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
		
		$this->load->model('users');
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST();
			if(!$errorPOST) {
				$lastname = @$this->request->post['lastname'];
				$firstname = @$this->request->post['firstname'];
				$user_email = @$this->request->post['user_email'];
				$vk_id = @$this->request->post['vk_id'];
				$editpassword = @$this->request->post['editpassword'];
				$password = @$this->request->post['password'];
				
				$userid = $this->user->getId();
				
				$userData = array(
					'user_firstname'	=> $firstname,
					'user_lastname'		=> $lastname,
					'user_email'		=> $user_email,
					'user_vk_id'		=> $vk_id
				);
				
				if($editpassword) {
					$userData['user_password'] = $password;
				}
				
				$this->usersModel->updateUser($userid, $userData);
				
				$this->data['status'] = "success";
				$this->data['success'] = "Изменения сохранены!";
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			}
		}

		return json_encode($this->data);
	}
	
	public function img() {
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
			
			$uploaddir = 'avatar/full/';
			// это папка, в которую будет загружаться картинка
			$apend=date('YmdHis').rand(100,1000).'.jpg'; 
			// это имя, которое будет присвоенно изображению 
			$uploadfile = "$uploaddir$apend"; 
			//в переменную $uploadfile будет входить папка и имя изображения

			// В данной строке самое важное - проверяем загружается ли изображение (а может вредоносный код?)
			// И проходит ли изображение по весу. В нашем случае до 512 Кб
			if(($_FILES['userfile']['type'] == 'image/gif' || $_FILES['userfile']['type'] == 'image/jpeg' || $_FILES['userfile']['type'] == 'image/png') && ($_FILES['userfile']['size'] != 0 and $_FILES['userfile']['size']<=512000)) 
			{ 
			// Указываем максимальный вес загружаемого файла. Сейчас до 512 Кб 
			  if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) 
			   { 
			   //Здесь идет процесс загрузки изображения 
			   $size = getimagesize($uploadfile); 
			   // с помощью этой функции мы можем получить размер пикселей изображения 
				 if ($size[0] < 801 && $size[1]<1501) 
				 { 
				//Обновляем данные аватарки 
				$userid = $this->user->getId();
				$userData = array(
				'user_img'		    => $uploadfile
				);
						
				$this->usersModel->updateUser($userid, $userData);
				 // если размер изображения не более 500 пикселей по ширине и не более 1500 по  высоте 
				 //echo "Файл загружен. Путь к файлу: <b>http:/zon.su/".$uploadfile."</b>";
				 //Вывод пуш лога 
				$this->data['status'] = "success";
				$this->data['success'] = "Аватар загружен!";			 
				 } else {
				 //echo "Загружаемое изображение превышает допустимые нормы (ширина не более - 500; высота не более 1500)"; 
				 //Вывод пуш лога 
				 $this->data['error'] = 'Загружаемое изображение превышает допустимые нормы (ширина не более - 800; высота не более 1500)';
				 $this->data['status'] = "error";
				 unlink($uploadfile); 
				 // удаление файла 
				 } 
			   } else {
			   //echo "Файл не загружен, вернитеcь и попробуйте еще раз";
			   $this->data['error'] = 'Файл не загружен, вернитеcь и попробуйте еще раз';
			   $this->data['status'] = "error";
			   } 
			} else { 
			//echo "Размер файла не должен превышать 512Кб";
			$this->data['error'] = 'Размер файла не должен превышать 512Кб';
			$this->data['status'] = "error";
			} 	
		}
		return json_encode($this->data);
    }
	
	public function vk() {
		$this->data['url'] = $this->config->url;
		$this->document->setActiveSection('account');
		$this->document->setActiveItem('edit');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 1) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}

		$this->load->model('users');

        if($this->request->post['auth']){
	        $errorPOST = $this->validatePOST_VK();
			if(!$errorPOST) {
			    $id = $this->request->post['response']['session']['user']['id'];
				
				$userid = $this->user->getId();
				
				$userData = array(
					'user_vk_id'	    => $id
				);
				
				$this->usersModel->updateUser($userid, $userData);
				
				
				$this->data['status'] = "success";
			    $this->data['success'] = "Профиль привязан! Ваш ID".$id."";		
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			}
			return json_encode($this->data);
		}
	
		if($this->request->post['auth_vk']) {
			if($user = @file_get_contents("https://api.vk.com/method/users.get?uids={$this->session->data['auth_vk']}&fields=uid,first_name,last_name,screen_name,sex,bdate,photo_big"))
			$this->data['user'] = json_decode($user, true);
		}
		return json_encode($this->data);
	}
	
	private function validatePOST() {
	
		$this->load->library('validate');
		
		$validateLib = new validateLibrary();
		
		$result = null;
		
		$lastname = @$this->request->post['lastname'];
		$firstname = @$this->request->post['firstname'];
		$user_email = @$this->request->post['user_email'];
		$editpassword = @$this->request->post['editpassword'];
		$password = @$this->request->post['password'];
		$password2 = @$this->request->post['password2'];
		
		if(!$validateLib->lastname($lastname)) {
			$result = "Укажите свою реальную фамилию!";
		}
		elseif(!$validateLib->firstname($firstname)) {
			$result = "Укажите свое реальное имя!";
		}
		elseif($editpassword) {
			if(!$validateLib->password($password)) {
				$result = "Пароль должен содержать от 6 до 32 латинских букв, цифр и знаков <i>,.!?_-</i>!";
			}
			elseif($password != $password2) {
				$result = "Введенные вами пароли не совпадают!";
			}
		}
		return $result;
	}
	
	private function validatePOST_VK() {
		$this->load->library('validate');
		
		$validateLib = new validateLibrary();
		
		$result = null;
		
		//$id = @$this->request->post['id'];
		$id = @strtolower($this->request->post['id']);

		if($this->usersModel->getTotalUsers(array('user_vk_id' => $id))) {
			$result = "Указанный userID уже привязан!";
		}

		return $result;
	}

	public function pluralForm($n, $form1, $form2,$form5) { 
        $n = abs($n) % 100; 
        $n1 = $n % 10; 
        if ($n1 >= 5 && $n1 <= 4) return $form2; 
        if ($n >= 10 && $n <= 20) return $form2; 
        if ($n1 >= 2 && $n1 <= 4) return $form5; 
        if ($n1 == 1) return $form1; 
        if ($n == 0) return $form2; 
    }
}
?>