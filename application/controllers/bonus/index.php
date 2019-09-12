<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class indexController extends Controller {
	public function index() {
		$this->load->checkLicense();
		if(!$this->user->isLogged()) {
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 1) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->model('users');

		$userid = $this->user->getId();
		$users = $this->usersModel->getUserById($userid, array(), array());
		$this->data['users'] = $users;
		
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('bonus/index', $this->data);
	}
	public function ajax_action_exchange($action = null) {
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
		$this->load->model('waste');

		$userid = $this->user->getId();
		$users = $this->usersModel->getUserById($userid, array(), array());

		switch($action) {
			case '100DEB': {	
				$rmoney = $users['rmoney'];
				$sum = "100";
				$upsum = "50";
					if ($rmoney >= $sum){

				$this->usersModel->downUserBalance($userid, $price);
					$wasteData = array(
					'user_id'			=> $userid,
					'waste_ammount'	=> 50,
					'waste_status'	=> 0,
					'waste_usluga'	=> "Обменял $sum бонусов на $upsum рублей"
				);
				$this->wasteModel->createWaste($wasteData);
						
						$this->usersModel->upUserBalance($userid, $upsum);
						$this->usersModel->downUserRMoney($userid, $sum);
						
						$this->data['status'] = "success";
						$this->data['success'] = "Деньги отправлены. Вам начисленно ".$upsum." руб!";
					} else {
						$this->data['status'] = "error";
						$this->data['error'] = "У вас недостаточно монет!";
					}
				break;
			}
			case '300DEB': {	
				$rmoney = $users['rmoney'];
				$sum = "300";
				$upsum = "150";
					if ($rmoney >= $sum){
						
				$this->usersModel->downUserBalance($userid, $price);
					$wasteData = array(
					'user_id'			=> $userid,
					'waste_ammount'	=> 150,
					'waste_status'	=> 0,
					'waste_usluga'	=> "Обменял $sum бонусов на $upsum рублей"
				);
				$this->wasteModel->createWaste($wasteData);
						
						$this->usersModel->upUserBalance($userid, $upsum);
						$this->usersModel->downUserRMoney($userid, $sum);
						
						$this->data['status'] = "success";
						$this->data['success'] = "Деньги отправлены. Вам начисленно ".$upsum." руб!";
					} else {
						$this->data['status'] = "error";
						$this->data['error'] = "У вас недостаточно монет!";
					}
				break;
			}
			case '600DEB': {	
				$rmoney = $users['rmoney'];
				$sum = "600";
				$upsum = "300";
					if ($rmoney >= $sum){
						
				$this->usersModel->downUserBalance($userid, $price);
					$wasteData = array(
					'user_id'			=> $userid,
					'waste_ammount'	=> 300,
					'waste_status'	=> 0,
					'waste_usluga'	=> "Обменял $sum бонусов на $upsum рублей"
				);
				$this->wasteModel->createWaste($wasteData);
						
						$this->usersModel->upUserBalance($userid, $upsum);
						$this->usersModel->downUserRMoney($userid, $sum);
						
						$this->data['status'] = "success";
						$this->data['success'] = "Деньги отправлены. Вам начисленно ".$upsum." руб!";
					} else {
						$this->data['status'] = "error";
						$this->data['error'] = "У вас недостаточно монет!";
					}
				break;
			}
			case '1000DEB': {	
				$rmoney = $users['rmoney'];
				$sum = "1000";
				$upsum = "507";
					if ($rmoney >= $sum){
						
				$this->usersModel->downUserBalance($userid, $price);
					$wasteData = array(
					'user_id'			=> $userid,
					'waste_ammount'	=> 507,
					'waste_status'	=> 0,
					'waste_usluga'	=> "Обменял $sum бонусов на $upsum рублей"
				);
				$this->wasteModel->createWaste($wasteData);
						
						$this->usersModel->upUserBalance($userid, $upsum);
						$this->usersModel->downUserRMoney($userid, $sum);
						
						$this->data['status'] = "success";
						$this->data['success'] = "Деньги отправлены. Вам начисленно ".$upsum." руб!";
					} else {
						$this->data['status'] = "error";
						$this->data['error'] = "У вас недостаточно монет!";
					}
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
}
?>