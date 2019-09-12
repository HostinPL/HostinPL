<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class invoicesController extends Controller {
	private $limit = 8;
	public function index($page = 1) {
		$this->load->checkLicense();
		$this->document->setActiveSection('account');
		$this->document->setActiveItem('invoices');
		$this->data['title'] = $this->config->title;
		$this->data['description'] = $this->config->description;
		$this->data['mail_from'] = $this->config->mail_from;	
		$this->data['homed'] = $this->config->homed;	
		$this->data['city_country'] = $this->config->city_country;	
		$this->data['phone'] = $this->config->phone;
		$this->data['logo'] = $this->config->logo;			
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 0) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->library('pagination');
		$this->load->model('invoices');
		$this->load->model('users');
		$userid = $this->user->getId();
		$sort = array(
			'invoice_status'		=> 'DESC',
			'invoice_id'	=> 'DESC'
		);
		$getOptions = array(
			'start' => ($page - 1) * $this->limit,
			'limit' => $this->limit
		);
		
		$total = $this->invoicesModel->getTotalInvoices(array('user_id' => (int)$userid));
		$invoices = $this->invoicesModel->getInvoices(array('user_id' => (int)$userid), array(), $sort, $getOptions);
		
		$paginationLib = new paginationLibrary();
		
		$paginationLib->total = $total;
		$paginationLib->page = $page;
		$paginationLib->limit = $this->limit;
		$paginationLib->url = $this->config->url . 'account/invoices/index/{page}';
		
		$pagination = $paginationLib->render();
		
		$this->data['invoices'] = $invoices;
		$this->data['pagination'] = $pagination;
		$this->data['user_email'] = $this->user->getEmail();
		$this->data['user_id'] = $userid;
		$this->data['user_firstname'] = $this->user->getFirstname();
		$this->data['user_lastname'] = $this->user->getLastname();
		$this->data['user_balance'] = $this->user->getBalance();
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('account/invoices', $this->data);
	}
}
?>
