<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class perevodController extends Controller {
	public function index() {
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 0) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
        
 		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('account/perevod', $this->data);
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
		
		$this->data['userid'] = $userid = $this->user->getId();
		
		$this->load->model('users');
		$this->load->model('waste');
		
		$users = $this->usersModel->getUserById($userid, array(), array());
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validate_POST();
			if(!$errorPOST) {
				$id = @$this->request->post['userid'];
				$sum = @$this->request->post['sum'];
				$balance = $users['user_balance'];
				
				if ($balance >= $sum){
					if ($userid == $id){
						$this->data['status'] = "error";
						$this->data['error'] = "Вы указали свой ID";
					} else {
						$wasteData = array(
						  'user_id'			=> $userid,
						  'waste_ammount'	=> $sum,
						  'waste_status'	=> 1,
						  'waste_usluga'	=> "Перевод средств пользователю ID-".$id."",
					    ); 						
				        $this->wasteModel->createWaste($wasteData);
						$this->usersModel->upUserBalance($id, $sum);
						$this->usersModel->downUserBalance($userid, $sum);
						$this->data['status'] = "success";
						$this->data['success'] = "Средства переведены!";
					}
				} else {
					$this->data['status'] = "error";
					$this->data['error'] = "У вас недостаточно средств!";
				}
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			}
		}

		return json_encode($this->data);
	}
	
	private function validate_POST() {
		$this->load->library('validate');
		
		$validateLib = new validateLibrary();
		
		$result = null;

		$id = @$this->request->post['userid'];
		$sum = @$this->request->post['sum'];
		
		
		if(!$validateLib->money($sum)) {
			$result = "Укажите реальное число!";
		}
		elseif(!$this->usersModel->getTotalUsers(array('user_id' => $id))) {
			$result = "Данного ID не сушествует!";
		}
		return $result;
	}
}
?>
 
