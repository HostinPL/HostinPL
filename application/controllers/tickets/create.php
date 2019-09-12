<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class createController extends Controller {
	public function index($ticketid = null) {
		$this->load->checkLicense();
		$this->document->setActiveSection('tickets');
		$this->document->setActiveItem('create');
		$this->data['url'] = $this->config->url;
		$this->data['recaptcha'] = $this->config->recaptcha;
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 0) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		$this->load->model('servers');
		$this->load->model('ticketsCategory');
		$this->load->model('users');
		$category = @$this->request->post['category'];
		$category = $this->ticketsCategoryModel->getTicketsCategory(array('category_status' => 1));
		$userid = $this->user->getId();
		$options = array(
			'start' => ($page - 1) * $this->limit,
			'limit' => $this->limit
		);
		$servers = $this->serversModel->getServers(array('user_id' => (int)$userid), array('games', 'locations'), array(), $options);
        $this->data['category'] = $category;
		$this->data['servers'] = $servers;
		$this->data['user_img'] = $this->user->getUser_img();
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('tickets/create', $this->data);
	}

	public function ajax($ticketid = null) {
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
		
		$this->load->model('tickets');
		$this->load->model('ticketsMessages');
		$this->load->model('ticketsCategory');
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST();
			if(!$errorPOST) {
				$name = @$this->request->post['name'];
				$text = @$this->request->post['text'];
				$category = @$this->request->post['category'];
				$userid = $this->user->getId();
				$ticketData = array(
					'user_id'			=> $userid,
					'ticket_name'		=> $name,
					'ticket_status'		=> 1,
					'category_id'		=> $category
				);
				$ticketid = $this->ticketsModel->createTicket($ticketData);				
				$messageData = array(
					'ticket_id'			=> $ticketid,
					'user_id'			=> $userid,
					'ticket_message'	=> $text
				);
				$this->ticketsMessagesModel->createTicketMessage($messageData);
				
				$this->data['status'] = "success";
				$this->data['success'] = "Вы успешно создали запрос!";
				$this->data['id'] = $ticketid;
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			}
		}

		return json_encode($this->data);
	}
	
	private function validatePOST() {
		$this->load->checkLicense();
		$result = null;
		
		$name = @$this->request->post['name'];
		$text = @$this->request->post['text'];
		$recaptcha = @$this->request->post['g-recaptcha-response'];
		
		if(mb_strlen($name) < 6 || mb_strlen($name) > 32) {
			$result = "Название тикета должно содержать от 6 до 32 символов!";
		}
		elseif(mb_strlen($text) < 10 || mb_strlen($text) > 10000) {
			$result = "Текст тикета должен содержать от 10 до 350 символов!";
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
