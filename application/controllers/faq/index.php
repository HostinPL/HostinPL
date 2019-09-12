<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class indexController extends Controller {
	public function index() {
		$this->load->checkLicense();
		if(!$this->user->isLogged()) {
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 0) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->model('servers');
		$this->load->model('tickets');
		$this->load->model('users');
		$this->load->library('pagination');
		$this->load->model('invoices');
		$this->data['user_img'] = $this->user->getUser_img();
		
		$userid = $this->user->getId();

				$getOptions = array(
			'start' => ($page - 1) * $this->limit,
			'limit' => $this->limit
		);
		
		$this->data['logged'] = true;
		$this->data['user_email'] = $this->user->getEmail();
		$this->data['user_id'] = $userid;
		$this->data['user_firstname'] = $this->user->getFirstname();
		$this->data['user_lastname'] = $this->user->getLastname();
		$this->data['user_balance'] = $this->user->getBalance();
		
		$ticketsSort = array(
			'ticket_status'		=> 'DESC',
			'ticket_date_add'	=> 'DESC'
		);
		
		$options = array(
			'start' => 0,
			'limit' => 5
		);
		
		$servers = $this->serversModel->getServers(array('user_id' => (int)$userid), array('games', 'locations'), array(), $options);
		$tickets = $this->ticketsModel->getTickets(array('user_id' => (int)$userid), array(), $ticketsSort, $options);
		$visitors = $this->usersModel->getAuthLog($userid);
		$total = $this->invoicesModel->getTotalInvoices(array('user_id' => (int)$userid));
		$invoices = $this->invoicesModel->getInvoices(array('user_id' => (int)$userid), array(), array(), $getOptions);
		$paginationLib = new paginationLibrary();
		$paginationLib->total = $total;
		$paginationLib->page = $page;
		$paginationLib->limit = $this->limit;
		$paginationLib->url = $this->config->url . 'account/invoices/index/{page}';
		$this->data['visitors'] = $visitors;
		$this->data['servers'] = $servers;
		$this->data['tickets'] = $tickets;
		$pagination = $paginationLib->render();
		
		$this->data['invoices'] = $invoices;
		$this->data['pagination'] = $pagination;
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('faq/index', $this->data);
	}
}
?>