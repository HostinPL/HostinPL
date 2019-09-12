<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class yandexkassaController extends Controller {
	public function index() {
		$this->load->checkLicense();
		$this->document->setActiveSection('account');
		$this->document->setActiveItem('pay');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 0) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		$this->data['yandexkassa'] = $robokassa = $this->config->yandexkassa;

		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('account/robopay', $this->data);
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
		
		$this->load->model('invoices');
		$userid = $this->user->getId();
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST();
			if(!$errorPOST) {
				$ammount = @$this->request->post['ammount'];
				
				$invoiceData = array(
					'user_id'			=> $userid,
					'invoice_ammount'	=> $ammount,
					'invoice_status'	=> 0,
					'system'	        => 2
				);
				$invid = $this->invoicesModel->createInvoice($invoiceData);
				
				$url = "https://money.yandex.ru/quickpay/confirm.xml";
				$url .= "?receiver=".$this->config->yk_login."";
				$url .= "&quickpay-form=shop";
				$url .= "&paymentType=PC";
				$url .= "&paymentType=AC";
				$url .= "&paymentType=MC";
				$url .= "&label=$invid";
				$url .= "&successURL=https://zon.su/";
				
				$url .= "&targets=Пополнение баланса аккаунта (ID " . $userid . ")";
				$url .= "&sum=$ammount";
				
				$this->data['status'] = "success";
				$this->data['url'] = $url;
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			}
		}

		return json_encode($this->data);
	}
	
	private function validatePOST() {
	
		$this->load->library('validate');
		
		$validateLib = new validateLibrary();
		
		$result = null;
		
		$ammount = @$this->request->post['ammount'];
		if(!$validateLib->money($ammount)) {
			$result = "Укажите сумму пополнения в допустимом формате!";
		}
		elseif(10 > $ammount || $ammount > 5000) {
			$result = "Укажите сумму от 10 до 5000 рублей!";
		}
		return $result;
	}
}
?>
