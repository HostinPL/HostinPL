<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class ftpController extends Controller {
	public function index($serverid = null) {
		$this->load->checkLicense();
		$this->document->setActiveSection('servers');
		$this->document->setActiveItem('index');
		$this->data['title'] = $this->config->title;
		$this->data['description'] = $this->config->description;
		$this->data['keywords'] = $this->config->keywords;
		$this->data['logo'] = $this->config->logo;
		$this->data['url'] = $this->config->url;
		$this->data['public'] = $this->config->public;
		$this->data['webhosting'] = $this->config->webhosting;
		$this->data['styles'] = $this->config->styles;
		
		$this->data['activesection'] = $this->document->getActiveSection();
		$this->data['activeitem'] = $this->document->getActiveItem();

		if($this->user->isLogged()) {
			$this->data['logged'] = true;
			$this->data['user_email'] = $this->user->getEmail();
			$this->data['user_firstname'] = $this->user->getFirstname();
			$this->data['user_lastname'] = $this->user->getLastname();
			$this->data['user_balance'] = $this->user->getBalance();
			$this->data['user_access_level'] = $this->user->getAccessLevel();
			$this->data['user_img'] = $this->user->getUser_img();
		} else {
			$this->data['logged'] = false;
			$this->data['user_access_level'] = 0;
		}

		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 0) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->library('query');
		$this->load->model('servers');
		$this->load->model('serversStats');
	    $this->load->model('tickets');
		$this->load->model('ticketsMessages');
		$this->load->model('users');
  		$error = $this->validate($serverid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'servers/index');
		}
		
		$userid = $this->user->getId();
		
		$server = $this->serversModel->getServerById($serverid, array('games', 'locations'));
		$this->data['server'] = $server;
		
		if($server['server_status'] == 2) {
			$queryLib = new queryLibrary($server['game_query']);
			$queryLib->connect($server['location_ip'], $server['server_port']);
			$query = $queryLib->getInfo();
			$queryLib->disconnect();
			
			$this->data['query'] = $query;
		}
		
		$stats = $this->serversStatsModel->getServerStats($serverid, "NOW() - INTERVAL 1 DAY", "NOW()");
		$rtickets = $this->ticketsModel->getTickets($getData, array('users'), $getSort, $getOptions);
		$total = $this->ticketsModel->getTotalTickets(array('user_id' => (int)$userid));
		$tickets = $this->ticketsModel->getTickets(array('user_id' => (int)$userid), array(), $sort, $options);
		$ticket = $this->ticketsModel->getTicketById($ticketid, array('users'));
		$messages = $this->ticketsMessagesModel->getTicketsMessages(array('ticket_id' => $ticketid), array('users'));
		$this->data['rtickets'] = $rtickets;
		$this->data['ticket'] = $ticket;
		$this->data['messages'] = $messages;
		$this->data['tickets'] = $tickets;
		$visitors = $this->usersModel->getAuthLog($userid);
		$this->data['visitors'] = $visitors;
		$this->data['stats'] = $stats;
		
		
		if(isset($_COOKIE["data-theme-ftp"])){
			$this->data['theme'] = $_COOKIE['data-theme-ftp'];
		} else{
			$this->data['theme'] = "/application/public/css/theme.css";
		}
		
		$this->getChild(array('common/footer'));
		return $this->load->view('servers/ftp', $this->data);
	}
	
	public function action_theme_ftp($action = null) {
		$this->load->checkLicense();
		if(!$this->user->isLogged()) {
			$this->data['status'] = "error";
			$this->data['error'] = "Вы не авторизированы!";
			return json_encode($this->data);
		}
		if($this->user->getAccessLevel() < 1) {
			$this->data['status'] = "error";
			$this->data['error'] = "У вас нет доступа к данному разделу!";
			return json_encode($this->data);
		}
		
		$this->data['userid'] = $userid = $this->user->getId();

		switch($action) {
			case 'default': {	
					$name = '/application/public/css/theme.css';
					setcookie('data-theme-ftp',$name,time() + (86400 * 5), '/' );
					$this->data['status'] = "success";
					$this->data['success'] = "Тема установлена!";
				break;
			}
			case 'windows': {	
					$name = '/application/public/css/elfinderT/windows-10/css/theme.css';
					setcookie('data-theme-ftp',$name,time() + (86400 * 5), '/' );
					$this->data['status'] = "success";
					$this->data['success'] = "Тема установлена!";
				break;
			}
			case 'material': {	
					$name = '/application/public/css/elfinderT/Material/css/theme.css';
					setcookie('data-theme-ftp',$name,time() + (86400 * 5), '/' );
					$this->data['status'] = "success";
					$this->data['success'] = "Тема установлена!";
				break;
			}
			case 'materialgray': {	
					$name = '/application/public/css/elfinderT/Material/css/theme-gray.css';
					setcookie('data-theme-ftp',$name,time() + (86400 * 5), '/' );
					$this->data['status'] = "success";
					$this->data['success'] = "Тема установлена!";
				break;
			}
			default: {
				$this->data['status'] = "error";
				$this->data['error'] = "Вы выбрали несуществующее действие!";
				break;
			}
		}

		return json_encode($this->data);
	}
	

	

	
	private function validate($serverid) {
		$this->load->checkLicense();
		$result = null;
		
		$userid = $this->user->getId();
		
		if(!$this->serversModel->getTotalServerOwners(array('server_id' => (int)$serverid, 'user_id' => (int)$userid, 'owner_status' => 1))) {
			if(!$this->serversModel->getTotalServers(array('server_id' => (int)$serverid, 'user_id' => (int)$userid))) {
				$result = "Запрашиваемый сервер не существует!";
			}
		}
		return $result;
	}
	
	

	public function getftp($serverid = null) {
  if(!$this->user->isLogged()) {
   $this->session->data['error'] = "Вы не авторизированы!";
   $this->response->redirect($this->config->url . 'account/login');
  }
  if($this->user->getAccessLevel() < 0) {
   $this->session->data['error'] = "У вас нет доступа к данному разделу!";
   $this->response->redirect($this->config->url);
  }
  
  $this->load->model('servers');
  
  $error = $this->validate($serverid);
  if($error) {   
    $this->session->data['error'] = $error;
    $this->response->redirect($this->config->url . 'servers/index');
  }
  
  $server = $this->serversModel->getServerById($serverid, array('games', 'locations'));  
  
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
function logger($cmd, $result, $args, $elfinder) {
    $log = sprintf('[%s] %s:', date('r'), strtoupper($cmd));
    foreach ($result as $key => $value) {
        if (empty($value)) {
            continue;
        }
        $data = array();
        if (in_array($key, array('error', 'warning'))) {
            array_push($data, implode(' ', $value));
        } else {
            if (is_array($value)) { // changes made to files
                foreach ($value as $file) {
                    $filepath = (isset($file['realpath']) ? $file['realpath'] : $elfinder->realpath($file['hash']));
                    array_push($data, $filepath);
                }
            } else { // other value (ex. header)
                array_push($data, $value);
            }
        }
        $log .= sprintf(' %s(%s)', $key, implode(', ', $data));
    }
    $log .= "\n";

    $logfile = 'files/log.txt';
    $dir = dirname($logfile);
    if (!is_dir($dir) && !mkdir($dir)) {
        return;
    }
    if (($fp = fopen($logfile, 'a'))) {
        fwrite($fp, $log);
        fclose($fp);
    }
}
  $opts = array(
   'roots' => array(
    array(
     'driver' => 'FTP',
	 'URL' => 'ftp://gs'.$server['server_id'].':'.$server['server_password'].'@'.$server['location_ip'].':21/',
     'host'   => $server['location_ip'],
     'user'   => 'gs'.$server['server_id'],
     'pass'   => $server['server_password'],
     'port'   => 21,  
     'mode'   => 'passive',
     'path'   => '/',
	 'read' => true,
	 'write' => true,
	 'utf8fix' => true,
	   'bind' => array(
        'mkdir mkfile rename duplicate upload rm paste' => 'logger'
    ),
	'rootAlias'=>'Server Root',
              'fileURL'=>True,
              'dotFiles'=>True,
              'dirSize'=>True,
              'fileMode'=>0644,
              'dirMode'=>0775,
              'imgLib'=>False,
              'tmbDir'=>'.tmb',
              'tmbAtOnce'=>5,
              'debug'=>True
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
