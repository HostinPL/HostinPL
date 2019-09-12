<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class indexController extends Controller {
	private $limit = 100;
	public function index($page = 1) {
		$this->load->checkLicense();
		$this->load->library('query');
		$this->load->model('games');
		$this->load->model('servers');
		$this->load->model('serversStats');
		$this->load->library('pagination');
		
		$getData = array('server_status' => 2);
		
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

		$this->data['games'] = $games = $this->gamesModel->getGames(array('game_status' => 1));
		$this->data['servers'] = $servers = $this->serversModel->getServers($getData, array('games', 'locations'),array(),  $getOptions);
		
		$paginationLib = new paginationLibrary();
		$paginationLib->total = $this->serversModel->getTotalServers($getData);
		$paginationLib->page = $page;
		$paginationLib->limit = $this->limit;
		$paginationLib->url = $this->config->url . 'monitor/index/index/{page}';
		$this->data['pagination'] = $paginationLib->render();

		$this->getChild(array('common/header', 'common/footer', 'common/mongames'));
		return $this->load->view('monitor/index', $this->data);
	}
}
?>
