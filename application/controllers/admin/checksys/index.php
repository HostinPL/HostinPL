<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class indexController extends Controller {
	private $limit = 20;
	public function index($page = 1) {
		$this->load->checkLicense();
		
		$this->document->setActiveSection('admin');
		$this->document->setActiveItem('servers');
		$this->data['token'] = $this->config->token;
		$this->data['url'] = $this->config->url;
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 2) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->library('pagination');
		$this->load->model('servers');
		
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
		
		$getOptions = array(
			'start' => ($page - 1) * $this->limit,
			'limit' => $this->limit
		);
		
		$total = $this->serversModel->getTotalServers($getData);
		$servers = $this->serversModel->getServers($getData, array('games', 'locations'), array(), $getOptions);
		
		$paginationLib = new paginationLibrary();
		
		$paginationLib->total = $total;
		$paginationLib->page = $page;
		$paginationLib->limit = $this->limit;
		$paginationLib->url = $this->config->url . 'admin/servers/index/index/{page}';
		
		$pagination = $paginationLib->render();
		
		$this->data['servers'] = $servers;
		$this->data['pagination'] = $pagination;
		
		$this->getChild(array('common/admheader', 'common/footer'));
		return $this->load->view('admin/checksys/index', $this->data);
	}
}
?>
