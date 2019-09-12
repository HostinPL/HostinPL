<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class resultController extends Controller {
	public function index() {
		$this->load->model('users');
		$this->load->model('invoices');
		$this->load->model('waste');
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST();
			if(!$errorPOST) {
				$ammount = $this->request->post['OutSum'];
				$invid = $this->request->post['InvId'];
				$signature = $this->request->post['SignatureValue'];
				
				$invoice = $this->invoicesModel->getInvoiceById($invid);
				$userid = $invoice['user_id'];
				
				if($ammount > 50){
					$this->usersModel->updateUser($userid, $userData = array('user_promised_pay' => 0));
				}

				$wasteData = array(
					'user_id'		=> $userid,
					'waste_ammount'	=> $ammount,
					'waste_status'	=> 0,
					'waste_usluga'	=> "Пополнение баланса пользователя",
				); 						
				$this->wasteModel->createWaste($wasteData);
				
				$this->usersModel->upUserBalance($userid, $ammount);
				$this->invoicesModel->updateInvoice($invid, array('invoice_status' => 1));
				return "OK$invid\n";
			} else {
				return "Error: $errorPOST";
			}
		} else {
			return "Error: Invalid request!";
		}
	}
	
	private function validatePOST() {
		$result = null;
		
		$ammount = $this->request->post['OutSum'];
		$invid = $this->request->post['InvId'];
		$signature = $this->request->post['SignatureValue'];
		
		$password2 = $this->config->rk_password2;
		
		if(!$this->invoicesModel->getTotalInvoices(array('invoice_id' => (int)$invid))) {
			$result = "Invalid invoice!";
		}
        elseif(strtoupper($signature) != strtoupper(md5("$ammount:$invid:$password2"))) {

			$result = "Invalid signature!";
		}
		return $result;
	}
}
?>
