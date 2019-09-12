<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class restoreController extends Controller {
	public function index() {
		$this->document->setActiveSection('account');
		$this->document->setActiveItem('restore');
		$this->data['recaptcha'] = $this->config->recaptcha;
		
		if($this->user->isLogged()) {
			$this->session->data['error'] = "Вы уже авторизированы!";
			$this->response->redirect($this->config->url);
		}

		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('account/restore/index', $this->data);
	}

	public function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array();
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < 10; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    	return implode($pass);
	}
		
	public function ajax() {
		if($this->user->isLogged()) {  
	  		$this->data['status'] = "error";
			$this->data['error'] = "Вы уже авторизированы!";
			return json_encode($this->data);
		}
		
		$this->load->library('mail');
		$this->load->model('users');
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST();
			if(!$errorPOST) {
				$email = @$this->request->post['email'];
				
				// Генерация ключа восстановления
				$user = $this->usersModel->getUserByEmail($email);
				
				$password = $this->randomPassword();
				
				$this->usersModel->updateUser($user['user_id'], array('user_password' => $password));
				
				$mailLib = new mailLibrary();
				
				$mailLib->setFrom($this->config->mail_from);
				$mailLib->setSender($this->config->mail_sender);
				$mailLib->setTo($email);
				$mailLib->setSubject('Восстановление пароля');
				
				$mailData = array();
				
				$mailData['firstname'] = $user['user_firstname'];
				$mailData['lastname'] = $user['user_lastname'];
				$mailData['email'] = $email;
				$mailData['restorelink'] = $password;
				$text = $this->load->view('mail/account/restore', $mailData);
				
				$mailLib->setText($text);
				$mailLib->send();
				
				$this->data['status'] = "success";
				$this->data['success'] = "На ваш E-Mail отправлена информация для восстановления пароля!";
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			}
		}

		return json_encode($this->data);
	}
	
	private function validate($userid, $restoreKey) {
		$this->load->library('validate');
		
		$validateLib = new validateLibrary();
		
		$result = null;
		
		if(!$validateLib->md5($restoreKey) || !$this->usersModel->getTotalUsers(array('user_id' => (int)$userid, 'user_restore_key' => $restoreKey))) {
			$result = "Указанный ключ восстановления неверный!";
		}
		return $result;
	}
	
	private function validatePOST() {
		$this->load->library('validate');
		
		$validateLib = new validateLibrary();
		
		$result = null;
		
		$email = @$this->request->post['email'];
		$recaptcha = @$this->request->post['g-recaptcha-response'];
		
		if(!$validateLib->email($email)) {
			$result = "Укажите свой реальный E-Mail!";
		}
		elseif($captcha != $captchahash) {
			$result = "Укажите правильный код с картинки!";
		}
		elseif($this->usersModel->getTotalUsers(array('user_email' => $email)) < 1) {
			$result = "Пользователь с указанным E-Mail не зарегистрирован!";
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
