<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class editController extends Controller {
	public function index($categoryid = null) {
		$this->load->checkLicense();
 
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 3) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->model('newsCategory');
		
		$error = $this->validate($categoryid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'admin/newscategory/index');
		}
		
		$category = $this->newsCategoryModel->getNewsCategoryById($categoryid);
		
		$this->data['category'] = $category;
		$this->getChild(array('common/admheader', 'common/footer'));
		return $this->load->view('admin/newscategory/edit', $this->data);
	}
	
	public function ajax($categoryid = null) {
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
		
		$this->load->model('newsCategory');
		
		$error = $this->validate($categoryid);
		if($error) {
			$this->data['status'] = "error";
			$this->data['error'] = $error;
			return json_encode($this->data);
		}
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST();
			if(!$errorPOST) {
				$name = @$this->request->post['name'];
				$status = @$this->request->post['status'];
				
				$adapData = array(
					'category_name'			=> $name,
					'category_status'		=> (int)$status
				);
				
				
				$this->newsCategoryModel->updateNewsCategory($categoryid, $adapData);
				
				$this->data['status'] = "success";
				$this->data['success'] = "Вы успешно отредактировали категорию!";
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			}
		}

		return json_encode($this->data);
	}
	
	public function delete($categoryid = null) {
		$this->load->checkLicense();
		$this->document->setActiveSection('admin');
		$this->document->setActiveItem('adaps');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 3) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->model('newsCategory');
		
		$error = $this->validate($categoryid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'admin/newscategory/index');
		}
		
		$this->newsCategoryModel->deleteNewsCategory($categoryid);
		
		$this->session->data['success'] = "Вы успешно удалили категорию!";
		$this->response->redirect($this->config->url . 'admin/newscategory/index');
		return null;
	}
	
	private function validate($categoryid) {
		$result = null;
		$this->load->model('newsCategory');
		if(!$this->newsCategoryModel->getTotalNewsCategory(array('category_id' => (int)$categoryid))) {
			$result = "Запрашиваемая категория не существует!";
		}
		return $result;
	}
	
	private function validatePOST() {
		$this->load->library('validate');
		
		$validateLib = new validateLibrary();
		
		$result = null;
		
		$name = @$this->request->post['name'];
				$status = @$this->request->post['status'];
		
		if(mb_strlen($name) < 2 || mb_strlen($name) > 32) {
			$result = "Название категории должно содержать от 2 до 32 символов!";
		}
		elseif($status < 0 || $status > 1) {
			$result = "Укажите допустимый статус!";
		}
		return $result;
	}
}
?>
