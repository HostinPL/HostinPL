<?php
class resultController extends Controller {
	public function index() {
		$this->load->model('users');
		$this->load->model('invoices');
		$this->load->model('waste');
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST();
			if(!$errorPOST) {
				$ammount = $this->request->post['amount'];
				$invid = $this->request->post['label'];
				
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
		
		$ammount = $this->request->post['amount'];
		$invoiceid = $this->request->post['label'];
		$signature = $this->request->post['sha1_hash'];		
		$notification_type = $this->request->post['notification_type'];
		$operation_id = $this->request->post['operation_id'];
		$amount = $this->request->post['amount'];
		$currency = $this->request->post['currency'];
		$datetime = $this->request->post['datetime'];
		$sender = $this->request->post['sender'];
		$codepro = $this->request->post['codepro'];
		$unaccepted = $this->request->post['unaccepted'];
		
		$password = $this->config->yk_password1;
		
		if(!$this->invoicesModel->getTotalInvoices(array('invoice_id' => (int)$invoiceid))) {
			$result = "Invalid invoice!";
		}elseif($signature != sha1($notification_type.'&'.$operation_id.'&'.$amount.'&'.$currency.'&'.$datetime.'&'.$sender.'&'.$codepro.'&'.$password.'&'.$invoiceid)) {
			$result = "Invalid signature!";
		}elseif($codepro === true) {
			$result = "Invalid codepro!";
		}elseif($unaccepted === true) {
			$result = "Invalid unaccepted!";
		}
		return $result;
	}
}
?>
