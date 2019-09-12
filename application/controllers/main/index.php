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
		$this->document->setActiveSection('main');
		$this->load->model('servers');
		$this->load->model('tickets');
		$this->load->model('invoices');
		$this->load->model('users');
		
		$userid = $this->user->getId();
		
		$this->data['logged'] = true;
		$this->data['user_email'] = $this->user->getEmail();
		$this->data['user_id'] = $userid;
		$this->data['public'] = $this->config->public;
		$this->data['user_firstname'] = $this->user->getFirstname();
		$this->data['user_lastname'] = $this->user->getLastname();
		$this->data['user_balance'] = $this->user->getBalance();
		$this->data['user_img'] = $this->user->getUser_img();
		$ticketsSort = array(
			'ticket_status'		=> 'DESC',
			'ticket_date_add'	=> 'DESC'
		);
		$getData = array();
		if(isset($this->request->get['userid'])) {
			$getData['servers.user_id'] = (int)$this->request->get['userid'];
		}
		
		if(isset($this->request->get['gameid'])) {
			$getData['servers.game_id'] = (int)$this->request->get['gameid'];
		}
		
		if(isset($this->request->get['locationid'])) {
			$getData['servers.location_id'] = (int)$this->request->get['locationid'];
		}
		$options = array(
			'start' => 0,
			'limit' => 1000
		);
						$getOptions = array(
			'start' => ($page - 1) * $this->limit,
			'limit' => $this->limit
		);
		$users = $this->usersModel->getUserById(array('user_id' => (int)$userid), array('users'), array(), $options);
		$tservers = $this->serversModel->getServers(array('user_id' => (int)$userid), array('games', 'locations'), array(), $options);		
		$total = $this->serversModel->getTotalServers($getData);
		$servers = $this->serversModel->getServers($getData, array('games', 'locations'), array(), $getOptions);
		$tickets = $this->ticketsModel->getTickets(array('user_id' => (int)$userid), array(), $ticketsSort, $options);
		$invoices = $this->invoicesModel->getInvoices(array('user_id' => (int)$userid), array(), array(), $options);
		$this->data['tservers'] = $tservers;
		$this->data['servers'] = $servers;		
		$this->data['invoices'] = $invoices;
		$this->data['tickets'] = $tickets;
		$this->data['users'] = $users;

		$this->load->checkLicense();
		$this->document->setActiveSection('news');
		$this->document->setActiveItem('index');

		$this->load->library('pagination');
		$this->load->model('news');
		$this->load->model('newsMessages');
		$userid = $this->user->getId();
		
		$sort = array(
			//'ticket_status'		=> 'DESC',
			'news_date_add'	=> 'DESC'
		);
		
		$options = array(
			'start'		=>	($page - 1) * $this->limit,
			'limit'		=>	$this->limit
		);
		
		$total = $this->newsModel->getTotalNews();
		$tickets = $this->newsModel->getNews(array(), array('news_category'), $sort, $options);			
		$messages = $this->newsMessagesModel->getNewsMessages(array('news_id' => $newid), array('users'));
		
		$paginationLib = new paginationLibrary();
		
		$paginationLib->total = $total;
		$paginationLib->page = $page;
		$paginationLib->limit = $this->limit;
		$paginationLib->url = $this->config->url . 'news/index/index/{page}';
		
		$pagination = $paginationLib->render();
		$nolog = $this->user->isLogged();
		$this->data['nolog'] = $nolog;
		$this->data['tickets'] = $tickets;
		$this->data['pagination'] = $pagination;
		$this->data['messages'] = $messages;

		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('main/index', $this->data);
	}
}
?>