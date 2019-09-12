<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class loginheaderController extends Controller {
	public function index() {
		$this->load->checkLicense();
		$this->data['title'] = $this->config->title;
		$this->data['description'] = $this->config->description;
		$this->data['keywords'] = $this->config->keywords;
		$this->data['logo'] = $this->config->logo;
		$this->data['public'] = $this->config->public;
		$this->data['count'] = $this->config->count;
		$this->data['vk_id'] = $this->config->vk_id;
		$this->data['vk_stat'] = $this->config->vk_stat;
		$this->data['styles'] = $this->config->styles;
		$this->data['recaptcha'] = $this->config->recaptcha;
		
		if(isset($this->session->data['error'])) {
			$this->data['error'] = $this->session->data['error'];
			unset($this->session->data['error']);
		}
		
		if(isset($this->session->data['warning'])) {
			$this->data['warning'] = $this->session->data['warning'];
			unset($this->session->data['warning']);
		}
		
		if(isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		}
			$this->load->model('users');
		$userid = $this->user->getId();
				$user = $this->usersModel->getUserById($_GET['ref'], array(), array(), $options);
		$this->data['user'] = $user;

		return $this->load->view('common/loginheader', $this->data);
	}
	public function ajax() {
		$this->load->checkLicense();
		if($this->user->isLogged()) {  
	  		$this->data['status'] = "error";
			$this->data['error'] = "Вы уже авторизированы!";
			return json_encode($this->data);
		}
		$this->load->library('mail');
		$this->load->model('users');
		//if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST();
			if(!$errorPOST) {
				$lastname = @$this->request->get['lastname'];
				$firstname = @$this->request->get['firstname'];
				$email = @$this->request->get['email'];
				$password = @$this->request->get['password'];
                $ref = @$this->request->get['ref'];
				
				$random = md5(uniqid(rand(),true)); 
				
				$userData = array(
					'user_email'		=> $email,
					'user_password'		=> $password,
					'user_firstname'	=> $firstname,
					'user_lastname'		=> $lastname,
					'user_status'		=> 1,
					'user_balance'		=> 0,
					'user_access_level'	=> 1,
					'ref'               => $ref,
					'rmoney'	=> 0,
					//активация 
					'user_activate'		=> $this->config->register,
					'key_activate'		=> $random
					
				);
				$this->usersModel->createUser($userData);
				$this->usersModel->upUserBalance($ref, 0.25);
				$this->usersModel->upUserRMoney($ref, 0.25);
				$mailLib = new mailLibrary();
				
				$mailLib->setFrom($this->config->mail_from);
				$mailLib->setSender($this->config->mail_sender);
				$mailLib->setTo($email);
				$mailLib->setSubject('Регистрация аккаунта');
				
				$mailData = array();
				
				$mailData['firstname'] = $firstname;
				$mailData['lastname'] = $lastname;
				$mailData['email'] = $email;
				$mailData['password'] = $password;
				$mailData['key'] = $random;
				
				$text = $this->load->view('mail/account/register', $mailData);
				
				$mailLib->setText($text);
				$mailLib->send();
				
				$this->data['status'] = "success";
				$this->data['success'] = "Вы успешно зарегистрировались!";
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			//}
		}

		return json_encode($this->data);
	}
	
	private function validatePOST() {
	
		$this->load->library('validate');
		
		$validateLib = new validateLibrary();
		
		$result = null;
		
		$lastname = @$this->request->get['lastname'];
		$firstname = @$this->request->get['firstname'];
		$email = @$this->request->get['email'];
		$password = @$this->request->get['password'];
		$password2 = @$this->request->get['password2'];
		$recaptcha = @$this->request->get['g-recaptcha-response'];

		if(!$validateLib->lastname($lastname)) {
			$result = "Укажите свою реальную фамилию!";
		}
		elseif(!$validateLib->firstname($firstname)) {
			$result = "Укажите свое реальное имя!";
		}
		elseif(!$validateLib->email($email)) {
			$result = "Укажите свой реальный E-Mail!";
		}
		elseif(!$validateLib->password($password)) {
			$result = "Пароль должен содержать от 6 до 32 латинских букв, цифр и знаков <i>,.!?_-</i>!";
		}
		elseif($password != $password2) {
			$result = "Введенные вами пароли не совпадают!";
		}
		elseif($captcha != $captchahash) {
			$result = "Укажите правильный код с картинки! Попробуйте нажать на картинку, чтобы обновить ее.";
		}
		elseif($this->usersModel->getTotalUsers(array('user_email' => $email))) {
			$result = "Указанный E-Mail уже зарегистрирован!";
		}
		elseif(!$recaptcha) {
			$recaptcha = @$this->request->get['g-recaptcha-response'];	
			
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
	
	
	public function ajax_infobox() {
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOSTInfo();
			if(!$errorPOST) {				
				if(@$this->request->post['msg'] == ""){
					$this->data['status'] = "error";
					$this->data['error'] = "Введите команду!";
				}elseif(@$this->request->post['msg'] != ""){
					$this->load->model('mail');
					$firstname = @$this->request->post['firstname'];
					$lastname = @$this->request->post['lastname'];
					$email = @$this->request->post['email'];
					$subject = @$this->request->post['subject'];
					$msg = @$this->request->post['msg'];
					$msgData = array(
						'user_email'		=> $email,
						'user_firstname'	=> $firstname,
						'user_lastname'		=> $lastname,
						'category'			=> $subject,
						'text'				=> $msg,
						'status'	        => 1
					);
					
					$msg_id = $this->mailModel->createInbox($msgData);	

					$this->data['status'] = "success";
					$this->data['success'] = "Ваше письмо отправлено! Номер IN".$msg_id."";
				}

			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			}
		}

		return json_encode($this->data);
	}

	private function validatePOSTInfo() {	
		$this->load->library('validate');
		
		$validateLib = new validateLibrary();
		
		$result = null;
		
		$firstname = @$this->request->post['firstname'];
		$lastname = @$this->request->post['lastname'];
		$email = @strtolower($this->request->post['email']);
		$subject = @$this->request->post['subject'];
		$msg = @$this->request->post['msg'];
		$recaptcha = @$this->request->post['g-recaptcha-response'];
	
		if(!$validateLib->lastname($lastname)) {
			$result = "Укажите свою реальную фамилию!";
		}
		elseif(!$validateLib->firstname($firstname)) {
			$result = "Укажите свое реальное имя!";
		}
		elseif(!$validateLib->email($email)) {
			$result = "Укажите свой реальный E-Mail!";
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
