<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class headerController extends Controller {

	public function index() {
		$this->load->checkLicense();
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
		$logged = $this->data['logged'];
		$this->data['logged'] = $logged;
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
	    $this->load->model('tickets');
		$this->load->model('ticketsMessages');
		$this->load->model('users');
		$userid = $this->user->getId();
		
		$sort = array(
			'ticket_status'		=> 'DESC',
			'ticket_date_add'	=> 'DESC'
		);
		
		$options = array(
			'start'		=>	($page - 1) * $this->limit,
			'limit'		=>	$this->limit
		);
		$getData = array();
		
		if(isset($this->request->get['userid'])) {
			$getData['tickets.user_id'] = (int)$this->request->get['userid'];
		}
		$getOptions = array(
			'start' => ($page - 1) * $this->limit,
			'limit' => $this->limit
		);
		$rtickets = $this->ticketsModel->getTickets($getData, array('users'), $getSort, $getOptions);
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

		$offline = $this->config->offline;
		if($offline == 1){
			if($this->user->getAccessLevel() == 1) {
				$result = $this->config->offline_res;
				header ("Location: /offline?result=".$result."");
				return;
			}
			if($this->user->getAccessLevel() == 2) {
				$result = $this->config->offline_res;
				header ("Location: /offline?result=".$result."");
				return;
			}
			if($this->user->getAccessLevel() == 3) {
				return $this->load->view('common/header', $this->data);
			}
		} else{
			return $this->load->view('common/header', $this->data);
		}
 
	}
}
?>
