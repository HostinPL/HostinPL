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
		$this->document->setActiveItem('tickets');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 2) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->library('pagination');
		$this->load->model('mail');
		
		$getData = array();

		if(isset($this->request->get['status'])) {
			$getData['inbox.status'] = (int)$this->request->get['status'];
		}
		
		$getSort = array(
			'status'		=> 'DESC',
			'inbox_date_add'	=> 'DESC'
		);
		
		$getOptions = array(
			'start' => ($page - 1) * $this->limit,
			'limit' => $this->limit
		);
		
		$total = $this->mailModel->getTotalInbox($getData);
		$this->data['mail'] = $mail = $this->mailModel->getInboxs($getData, $getSort, $getOptions);
		
		$paginationLib = new paginationLibrary();
		
		$paginationLib->total = $total;
		$paginationLib->page = $page;
		$paginationLib->limit = $this->limit;
		$paginationLib->url = $this->config->url . 'admin/infobox/index/index/{page}';
		
		$pagination = $paginationLib->render();

		$this->data['pagination'] = $pagination;
		
		$this->getChild(array('common/admheader', 'common/footer'));
		return $this->load->view('admin/infobox/index', $this->data);
	}
}
?>
