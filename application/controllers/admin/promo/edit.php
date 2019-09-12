<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class editController extends Controller {
	public function index($promoid = null) {
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
		
		$this->load->model('promos');
		
		$error = $this->validate($promoid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'admin/promo/index');
		}
		
		$promo= $this->promosModel->getpromoById($promoid);
		
		$this->data['promo'] = $promo;
		
		$this->getChild(array('common/admheader', 'common/footer'));
		return $this->load->view('admin/promo/edit', $this->data);
	}
	
	public function ajax($promoid = null) {
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
		
		$error = $this->validate($promoid);
		if($error) {
			$this->data['status'] = "error";
			$this->data['error'] = $error;
			return json_encode($this->data);
		}
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST();
			if(!$errorPOST) {
				$cod = @$this->request->post['cod'];
				$uses = @$this->request->post['uses'];
				$skidka = @$this->request->post['skidka'];
				
				$locationData = array(
					'cod'			=> $cod,
					'uses'			=> $uses,
					'skidka'		=> (int)$skidka
				);
 
				
				$this->promosModel->updatepromo($promoid, $locationData);
				
				$this->data['status'] = "success";
				$this->data['success'] = "Вы успешно отредактировали промо-код!";
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			}
		}

		return json_encode($this->data);
	}
	
	public function delete($promoid = null) {
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
		
		$this->load->model('promos');
		
		$error = $this->validate($promoid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'admin/promo/index');
		}
		
		$this->promosModel->deletepromo($promoid);
		
		$this->session->data['success'] = "Вы успешно удалили промо-код!";
		$this->response->redirect($this->config->url . 'admin/promo/index');
		return null;
	}
	
	private function validate($promoid) {
		$result = null;
		
		if(!$this->promosModel->getTotalpromo(array('id' => (int)$promoid))) {
			$result = "Запрашиваемый код не существует!";
		}
		return $result;
	}
	
	private function validatePOST() {
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
