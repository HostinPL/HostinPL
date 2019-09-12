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
class ftpController extends Controller {
	public function index($webid = null) {
		$this->load->checkLicense();
		$this->document->setActiveSection('webhost');
		$this->document->setActiveItem('index');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "No dostup!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 0) {
			$this->session->data['error'] = "No dostup!";
			$this->response->redirect($this->config->url);
		}
		$this->load->model('webhost');
  		$error = $this->validate($webid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'webhost/index');
		}
		
		$userid = $this->user->getId();
		
		$webhost = $this->webhostModel->getWebhostById($webid, array('web_tarifs', 'locations'));
		$this->data['webhost'] = $webhost;
		$ispdomain = $this->config->ispdomain;
		$this->data['ispdomain'] = $ispdomain;
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('webhost/ftp', $this->data);
	}
	

	

	
	private function validate($webid) {
		$this->load->checkLicense();
		$result = null;
		
		$userid = $this->user->getId();
		
		if(!$this->webhostModel->getTotalWebhosts(array('web_id' => (int)$webid, 'user_id' => (int)$userid))) {
			$result = "No dostup!";
		}
		return $result;
	}
	
	

	public function getftp($webid = null) {
  if(!$this->user->isLogged()) {
   $this->session->data['error'] = "Вы не авторизированы!";
   $this->response->redirect($this->config->url . 'account/login');
  }
  if($this->user->getAccessLevel() < 0) {
   $this->session->data['error'] = "У вас нет доступа к данному разделу!";
   $this->response->redirect($this->config->url);
  }
  
  $this->load->model('webhost');
  
  $error = $this->validate($webid);
  if($error) {   
    $this->session->data['error'] = $error;
    $this->response->redirect($this->config->url . 'servers/index');
  }
  
  $webhost = $this->webhostModel->getWebhostById($webid, array('web_tarifs', 'locations'));  
  
  include_once 'engine_ftp/elFinderConnector.class.php';
  include_once 'engine_ftp/elFinder.class.php';
  include_once 'engine_ftp/elFinderVolumeDriver.class.php';
  include_once 'engine_ftp/elFinderVolumeLocalFileSystem.class.php';
  include_once 'engine_ftp/elFinderVolumeFTP.class.php';
 
function access($attr, $path, $data, $volume) {
	return strpos(basename($path), '.') === 0       // if file/folder begins with '.' (dot)
		? !($attr == 'read' || $attr == 'write')    // set read+write to false, other (locked+hidden) set to true
		:  null;                                    // else elFinder decide it itself
}

  $opts = array(
   'roots' => array(
    array(
     'driver' => 'FTP',
	 'URL' => 'ftp://ws'.$webhost['web_id'].':'.$webhost['web_password'].'@'.$this->config->ispdomain.':21',
     'host'   => $this->config->ispdomain,
     'user'   => 'ws'.$webhost['web_id'],
     'pass'   => $webhost['web_password'],
     'port'   => 21,  
     'mode'   => 'active',
     'path'   => '/www/vk.com',
	 'utf8fix' => true,
    ),

	'attributes' => array(
		 		array(
					'pattern' => '~/\.~',
		 			'read' => true,
		 			'write' => true,
		 			'hidden' => true
					
		 		),
		 		
		 	)
   )
  );

  $connector = new elFinderConnector(new elFinder($opts));
  $connector->run();
}

}
?>
