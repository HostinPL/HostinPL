<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class mongamesController extends Controller {
	public function index() {
		$this->load->checkLicense();
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 0) {
			$this->session->data['error'] = "Blocked!";
			$this->response->redirect($this->config->url);
		}
		$this->load->library('query');
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
		$options = array(
			'start' => 0,
			'limit' => 1000
		);
		$servers = $this->serversModel->getServers($getData, array('games', 'locations'),array(),  $options);
		$this->data['servers'] = $servers;

		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('common/mongames', $this->data);
	}
}
?>