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
class controlController extends Controller {
	public function index($webid = null) {
		$this->load->checkLicense();
		$this->document->setActiveSection('webhost');
		$this->document->setActiveItem('index');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 0) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		$userid = $this->user->getId();	
		$this->load->model('webhost');		
        $this->load->model('webhostTarifs');
		$this->load->model('locations'); 
		$error = $this->validate($webid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'webhost/index');
		}
		$webhost = $this->webhostModel->getWebhostById($webid, array('users','web_tarifs', 'locations'));
		$tarifs = $this->webhostTarifsModel->getTarifs(array('tarif_status' => 1));
		$locations = $this->locationsModel->getLocations(array('location_status' => 1));
		$ispdomain = $this->config->ispdomain;
		$this->data['webhost'] = $webhost;
		$this->data['tarifs'] = $tarifs;
		$this->data['ispdomain'] = $ispdomain;
		$this->data['locations'] = $locations;
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('webhost/control', $this->data);
	}
	
	public function action($webid = null, $action = null) {
		$this->load->checkLicense();
		if(!$this->user->isLogged()) {
			$this->data['status'] = "error";
			$this->data['error'] = "Вы не авторизированы!";
			return json_encode($this->data);
		}
		if($this->user->getAccessLevel() < 0) {
	  		$this->data['status'] = "error";
			$this->data['error'] = "У вас нет доступа к данному разделу!";
			return json_encode($this->data);
		}
		$this->load->model('webhost');
		$this->load->model('webhostTarifs');
		$this->load->library('ssh2');
		$ssh2Lib = new ssh2Library();
		
		$error = $this->validate($webid);
		if($error) {
			$this->data['status'] = "error";
			$this->data['error'] = $error;
			return json_encode($this->data);
		}
		
		$webhost = $this->webhostModel->getWebhostById($webid, array('users', 'locations', 'web_tarifs'));		
		switch($action) {
			default: {
				$this->data['status'] = "error";
				$this->data['error'] = "Вы выбрали несуществующее действие!";
				break;
			}
		}
		
		return json_encode($this->data);
	}
	public function buy_months($webid = null) {
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
		
		$this->load->model('users');
		$this->load->model('webhost');
		$months = $this->request->post['months'];
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$userid = $this->user->getId();
			$balance = $this->user->getBalance();
			
			$webhost = $this->webhostModel->getWebhostById($webid, array('web_tarifs'));
			
			$price = $webhost['tarif_price'];
					switch($months) {
						case "3":
							$months = 3;
							$price = $price * 0.95;
							break;
						case "6":
							$months = 6;
							$price = $price * 0.90;
							break;
						case "12":
							$months = 12;
							$price = $price * 0.85;
							break;
						default:
							$months = 1;
					}
			$price = $price * $months;
			if($balance >= $price) {
				if($webhost['web_status'] == 0) {
					$this->webhostModel->updateWebhost($webid, array('web_status' => 1));
					$this->webhostModel->extendWebhost($webid,$months,true);
				} else {
					$this->webhostModel->extendWebhost($webid,$months,false);
				}
				$this->usersModel->downUserBalance($userid, $price);
				
				$this->data['status'] = "success";
				$this->data['success'] = "Вы успешно оплатили веб-хостинг на $months месяцев!";
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = "На Вашем счету недостаточно средств!";
			}
		}

				return json_encode($this->data);
	}

	private function validate($webid) {
		$this->load->checkLicense();
		$result = null;
		
		$userid = $this->user->getId();
		
		if(!$this->webhostModel->getTotalWebhosts(array('web_id' => (int)$webid, 'user_id' => (int)$userid))) {
			$result = "Запрашиваемый веб-хостинг не существует!";
		}
		return $result;
	}
	
	private function validatePOST() {
		$this->load->checkLicense();
		$this->load->library('validate');
		
		$validateLib = new validateLibrary();
		
		$result = null;
		
		$editpassword = @$this->request->post['editpassword'];
		$password = @$this->request->post['password'];
		$password2 = @$this->request->post['password2'];
		
		if($editpassword) {
			if(!$validateLib->password($password)) {
				$result = "Пароль должен содержать от 6 до 32 латинских букв, цифр и знаков <i>,.!?_-</i>!";
			}
			elseif($password != $password2) {
				$result = "Введенные вами пароли не совпадают!";
			}
		}
		return $result;
	}
}
?>
