<?php
/*
Copyright (c) 2014 LiteDevel

Данная лицензия разрешает лицам, получившим копию данного программного обеспечения
и сопутствующей документации (в дальнейшем именуемыми «Программное Обеспечение»),
безвозмездно использовать Программное Обеспечение в  личных целях, включая неограниченное
право на использование, копирование, изменение, добавление, публикацию, распространение,
также как и лицам, которым запрещенно использовать Програмное Обеспечение в коммерческих целях,
предоставляется данное Программное Обеспечение,при соблюдении следующих условий:

Developed by LiteDevel
*/
class indexController extends Controller {
	private $limit = 20;
	public function index($page = 1) {
		$this->load->checkLicense();
		$this->data['db_password'] = $this->config->db_password;
		$this->document->setActiveSection('webhost');
		$this->document->setActiveItem('index');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не залогинены!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 0) {
			$this->session->data['error'] = "Нет доступа!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->library('pagination');
		$this->load->model('webhost');
		
		$userid = $this->user->getId();
		
		$options = array(
			'start' => ($page - 1) * $this->limit,
			'limit' => $this->limit
		);
		
		$total = $this->webhostModel->getTotalWebhosts(array('user_id' => (int)$userid));
		$webhosts = $this->webhostModel->getWebhosts(array('user_id' => (int)$userid), array('web_tarifs', 'locations'), array(), $options);
		
		$paginationLib = new paginationLibrary();
		
		$paginationLib->total = $total;
		$paginationLib->page = $page;
		$paginationLib->limit = $this->limit;
		$paginationLib->url = $this->config->url . 'webhost/index/index/{page}';
		
		$pagination = $paginationLib->render();
		
		$this->data['webhosts'] = $webhosts;
		$this->data['pagination'] = $pagination;
		
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('webhost/index', $this->data);
	}
}
?>
