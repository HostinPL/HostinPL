<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class indexController extends Controller {
	private $limit = 6;
	public function index($page = 1) {
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
		if(!$this->user->isLogged()) {
        $this->getChild(array('common/loginheader', 'common/loginfooter'));
		} else $this->getChild(array('common/header', 'common/footer'));
		
		return $this->load->view('news/index', $this->data);
	}
}
?>
