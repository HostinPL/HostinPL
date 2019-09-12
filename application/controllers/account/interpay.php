<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class interpayController extends Controller {

	public function index() {
		
		$this->document->setActiveSection('account');
		$this->document->setActiveItem('unitpay');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 0) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		$this->load->model('users');
		$this->load->model('invoices');
		$interkassa = $this->config->interkassa;
		$this->data['interkassa'] = $interkassa;

		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('account/interpay', $this->data);
	}
 
 
	public function ajax() {
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
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST();
			if(!$errorPOST) {
				$ammount = @$this->request->post['ammount'];
				
				$userid = $this->user->getId();
				
				$invoiceData = array(
					'user_id'			=> $userid,
					'invoice_ammount'	=> $ammount,
					'invoice_status'	=> 0,
					'system'	=> 3
				);
				$invid = $this->invoicesModel->createInvoice($invoiceData);
				$desc = "Пополнение баланса аккаунта (ID " . $userid . ")";
				$url = "https://sci.interkassa.com/";
				/* Параметры: */
				$url .= "?ik_co_id=57e931c53d1eafce4e8b456d";
				$url .= "&ik_pm_no=$invid";
				$url .= "&ik_am=$ammount";
				$url .= "&ik_cur=RUB";				
				$url .= "&ik_desc=$desc";
				
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
		elseif(1 > $ammount || $ammount > 5000) {
			$result = "Укажите сумму от 1 до 5000 рублей!";
		}
		return $result;
	}
}
?>
