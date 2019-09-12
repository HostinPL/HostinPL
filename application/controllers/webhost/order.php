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
class orderController extends Controller {
	public function index() {
		$this->load->checkLicense();
		$this->document->setActiveSection('webhost');
		$this->document->setActiveItem('order');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 0) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		$this->load->model('locations');
		$locations = $this->locationsModel->getLocations(array('location_status' => 1));
		$this->data['locations'] = $locations;
		$this->load->model('webhostTarifs');
		$tarifs = $this->webhostTarifsModel->getTarifs(array('tarif_status' => 1));
		$this->data['tarifs'] = $tarifs;
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('webhost/order', $this->data);
	}
	
	public function promo() {
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
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$code = $this->request->post['code'];
			$skidka = $this->usersModel->getSkidkaByCode($code, false);$kofficent=(100-$skidka['skidka'])/100;
			if($skidka['skidka'] == NULL){
				$this->data['status'] = "error";
				$this->data['error'] = "Данного кода не существует";
			}else{
				$this->data['status'] = "success";
				$this->data['success'] = "Вы активировали скидку ".$skidka['skidka']."%";
				$this->data['skidka'] = $kofficent;
			}
		}

		return json_encode($this->data);
	}
	
	public function ajax() {
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
		$this->load->model('locations');
		$this->load->model('webhost');
		$this->load->model('webhostTarifs');
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST();
			if(!$errorPOST) {
				$locationid = $this->request->post['locationid'];
				$tarifid = $this->request->post['tarifid'];
				$domain = $this->request->post['domain'];
				$months = $this->request->post['months'];
				/*Генерация пароля*/
				$chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP!@";
                $max=10; 
                $size=StrLen($chars)-1; 
			    $password=null;
				while($max--) 
                $password.=$chars[rand(0,$size)];
			    /*Остальная информация*/
				$userid = $this->user->getId();
				$balance = $this->user->getBalance();
				$tarif = $this->webhostTarifsModel->getTarifById($tarifid);	
				$code = $this->request->post['promo'];
				$skidka = $this->usersModel->getSkidkaByCode($code,true);$kofficent=(100-$skidka['skidka'])/100;				
					$price = $tarif['tarif_price'];
				
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
				
					if($skidka['skidka'] != NULL){
						$price = $price * $kofficent;
					}
				
					if($balance >= $price) {
						$webData = array(
							'user_id'			=> $userid,
							'location_id'		=> $locationid,
							'web_password'		=> $password,
							'web_domain'		=> $domain,
							'tarif_id'		    => $tarifid,
							'web_status'		=> 1,
							'web_months'		=> $months
						);
						$webid = $this->webhostModel->createWebhost($webData);
						$this->webhostModel->installWebhost($webid,$password,$domain);
						$this->usersModel->downUserBalance($userid, $price);
					
						$this->data['status'] = "success";
						$this->data['success'] = "Веб-хостинг №".$webid." успешно заказан.";
						$this->data['id'] = $webid;
					} else {
						$this->data['status'] = "error";
						$this->data['error'] = "На Вашем счету недостаточно средств!";
					}
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			}
		}

		return json_encode($this->data);
	}
	
	private function validatePOST() {
		$this->load->checkLicense();
		$this->load->library('validate');
		
		$validateLib = new validateLibrary();
		
		$result = null;
		$locationid = @$this->request->post['locationid'];
		$tarifid = @$this->request->post['tarifid'];
		$domain = @$this->request->post['domain'];
		$months = @$this->request->post['months'];
		
        if(!$validateLib->domain($domain)) {
			$result = "Не правильно введен домен!";
		}
		elseif($this->webhostModel->getTotalWebhosts(array('web_domain' => $domain))) {
			$result = "На данный домен уже заказан Веб-Хостинг!";
		}
		elseif(!$this->locationsModel->getTotalLocations(array('location_id' => (int)$locationid, 'location_status' => 1))) {
			$result = "Вы указали несуществующую локацию!";
		}
		return $result;
	}
}
?>
