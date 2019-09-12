<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class createController extends Controller {
	public function index() {
		$this->load->checkLicense();
		$this->document->setActiveSection('admin');
		$this->document->setActiveItem('locations');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 3) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->getChild(array('common/admheader', 'common/footer'));
		return $this->load->view('admin/promo/create', $this->data);
	}
	
	public function ajax() {
		$this->load->checkLicense();
		if(!$this->user->isLogged()) {  
	  		$this->data['status'] = "error";
			$this->data['error'] = "Вы не авторизированы!";
			return json_encode($this->data);
		}
		if($this->user->getAccessLevel() < 3) {
			$this->data['status'] = "error";
			$this->data['error'] = "У вас нет доступа к данному разделу!";
			return json_encode($this->data);
		}
		
		$this->load->model('promos');
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST();
			if(!$errorPOST) {
				$cod = @$this->request->post['cod'];
                $uses = @$this->request->post['uses'];
				$skidka = @$this->request->post['skidka'];
				
				$locationData = array(
					'cod'		=> $cod,
					'uses'		=> $uses,
					'used'		=> 0,
					'skidka'	=> (int)$skidka
				);
				
				$this->promosModel->createPromo($locationData);
				
				$this->data['status'] = "success";
				$this->data['success'] = "Вы успешно создали промо-Код!";
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
		
		$cod = @$this->request->post['cod'];
        $uses = @$this->request->post['uses'];
		$skidka = @$this->request->post['skidka'];
		
		if(mb_strlen($cod) < 2 || mb_strlen($cod) > 32) {
			$result = "Код должен содержать от 2 до 32 символов!";
		}
        elseif(mb_strlen($uses) < 1 || mb_strlen($uses) > 10000) {
            $result = "Введите количество использований от 1 до 10000!";
        }
		 
		return $result;
	}
}
?>
